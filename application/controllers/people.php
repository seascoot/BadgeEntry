
<?php

/*
 * BadgeEntry
 *
 * Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
 * Copyright (C) 2013 Clive S. Woodhouse <http://www.clivewoodhouse.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as
 * published by the Free Software Foundation; either version 2 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA
 * 02111-1307, USA.
 *
 * Authors:
 *  Scott Severance <http://www.scottseverance.us>
 *  Clive S. Woodhouse <http://www.clivewoodhouse.com> 
 *
 */

class People extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->load->helper('date');
		$this->load->library('table');
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', '');
	}
	
	function index() {
		$this->_peopleList('all');
	}
	function kids() {
	    $this->_peopleList('kid');
	}
	function staff() {
	    $this->_peopleList('staff');
	}
	function parents() {
	    $this->_peopleList('parent');
	}
	function guests() {
	    $this->_peopleList('guest');
	}
	
	public function edit() {
            $this->load->helper('form');
	    $this->load->helper('photo_upload');
	    $this->load->library('form_validation');
	    $this->load->helper('states');
            $data['attributes_form'] = array('class' => 'form-horizontal validate');
	    
	    if(is_numeric($this->uri->segment(3))) {
	        $data['id'] = $this->uri->segment(3);
	        $data['title'] = "Edit Person";
	    }
	    elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
	        $data['id'] = $_POST['id'];
	        $data['title'] = "Edit Person";
	    }
	    else {
	        $data['title'] = 'Add Person';
	    }
		$data['state_id'] = 'id="state" reqired"="required"';
		$data['person_types'] = 'placeholder="select type" required="required"';
		$data['stateList'] = states_list();
	    $data['type'] = 'kid';
	    $data['firstName'] = '';
	    $data['lastName'] = '';
	    $data['dateOfBirth'] = '';
	    $data['address'] = '';
	    $data['city'] = "";
	    $data['state'] = 'XX';
	    $data['zip'] = '';
            $data['phone'] = '';
	    $data['email'] = '';
	    $data['hasPhoto'] = 'false';
	    $data['parentsNames'] = '';
	    $data['parentsMustCheckOut'] = 'false';
		$data['person_type'] = array(
							'' => 'Please select a category...',
							'kid' => 'Kid',
							'staff' => 'Staff member',
							'parent' => 'Parent',
							'guest' => 'Guest'
				);
	    
	    if(isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $query = $this->db->get('people');
            if($query->num_rows() != 1) $this->load->view("home/error", array('error' => "Something is wrong with the query: ".__FILE__.":".__LINE__));
            $row = $query->row_array();
            
            foreach($row as $field => $value) {
                if($value) $data[$field] = $value;
            }
        }
        
        //validation
        
        $this->load->library('form_validation');
	$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');      
        if ($this->form_validation->run() == FALSE)
		{
                    $this->load->view('home/people/add_edit',$data);
		}

        else { //validation succeeded
            // Updating a current entry
            if(
                    isset($_POST['id']) && 
                    $this->db->get_where('people',array('id' => $_POST['id']))->num_rows() == 1
                    ) {
                echo "<pre>" . print_r(array($_POST,$_FILES), true) . "</pre>";
                //handle upload
                $this->_handlePhoto($_POST['id']);
                $this->db->where('id', $_POST['id']);
                $id = $_POST['id'];
                unset($_POST['id']);
                $this->db->update('people', $_POST);
    	    }
    	    // Adding a new entry
    	    elseif(!isset($_POST['id'])) {
    	        //unset($data['title'],$data['stateList']);
    	        $_POST['timeAdded'] = date('Y-m-d H:i:s');
    	        $this->db->insert("people", $_POST);
    	        $ins_id = $this->db->insert_id();
    	        $data['hasPhoto'] = $this->_handlePhoto($ins_id);
    	        if($data['hasPhoto']) {
    	            $this->db->where("id", $ins_id);
    	            $this->db->update("people", array('hasPhoto' => true));
    	        }
    	        $id = $ins_id;
    	        //print_r($_POST);
    	    }
    	    else { // We have bogus postdata
    	        $this->load->view("home/error", array('error' => "Unknown error with your postdata. File: ".__FILE__.":".__LINE__));
    	    }
    	    redirect("people/view/$id");
    	}
	}

	function delete() {
	    $this->load->helper('file');
	    $id = $this->uri->segment(3);
	    $this->db->where('id', "$id");
	    $query = $this->db->get('people');
	    if($query->num_rows() == 0) $this->load->view("home/error", array('error' => "No such person"));
	    $name = $query->row()->firstName .' '. $query->row()->lastName;
	    $hasPhoto = ($query->row()->hasPhoto == "true") ? true : false;
	    
	    // Check for attendance
	    $this->db->where('person_id', "$id");
	    $query = $this->db->get('attendance');
	    if($query->num_rows() > 0) {
    	    $this->load->view("home/error", array('error' => "Unable to delete $name. You can only delete people who haven't attended any meetings."));
    	}

    	// Do the work
    	$photo_delete_error = false;
    	if($hasPhoto) {
    	    foreach(array('large', 'medium', 'small') as $v) {
    	        if(!unlink("images/photos/$v/$id.jpg")) $photo_delete_error = true;
    	    }
    	}
    	$this->db->where('id', $id);
    	$this->db->delete('people');
    	if($photo_delete_error) $this->load->view("home/error", array('error' => "While $name has been deleted, one or more photos remain. Please manually delete them. They're located in images/photos in the various subdirectories and they're named $id.jpg.", 'title' => "$name has been partially deleted"));
    	else redirect("people");
	}
	
	function view() {
	    $this->load->helper("time");
	    $this->load->model("meetings_model", "m");
	    $id = $this->uri->segment(3);
	    $this->db->where("id", "$id");
	    $query = $this->db->get("people");
	    if($query->num_rows() == 0) $this->load->view("home/error", array('error' => "No such person", 'title' => '404 Not Found', 'http_status' => 404));
	    
	    $data = $query->row_array();
	    $data['title'] = 'Person Information';
	    $currentMeeting = $this->m->meetingInProgress();
	    if($currentMeeting !== false) {
	        $this->db->select('status');
	        $this->db->where("id", "$id");
	        $query = $this->db->get("people");
	        $data['mode'] = $query->row()->status;
	        switch($data['mode']) {
	            case 'enter': $data['mode'] = 'signout';  break;
	            case 'exit' : $data['mode'] = 'signin'; break;
	            default: $data['mode'] = 'signin';
	        }
	    }
	    else $data['mode'] = false;
	    $data['hasPhoto'] = ($data['hasPhoto'] == 'true') ? true : false;
	    $tmp = explode(' ',$data['lastModified']);
	    $tmp[1] = time24to12($tmp[1]);
	    $data['lastModified'] = implode(' ',$tmp);
	    $tmp = explode(' ',$data['timeAdded']);
	    $tmp[1] = time24to12($tmp[1]);
	    $data['timeAdded'] = implode(' ',$tmp);
	    
	    $print = $this->uri->segment(4);
	    if($print == 'badge.pdf') $this->_generatePDF($data);
	    else $this->load->view("home/people/view", $data);
	}
	
	function _generatePDF($x) {
	    ///////////////////////////////////////////////////////////////////////
	    // This function requires FPDF 1.7. Documentation is available online
	    // at <http://www.fpdf.org>.
	    //
	    // All measurements are in inches
	    ///////////////////////////////////////////////////////////////////////
	    
	    require('application/third_party/fpdf/fpdf.php');
	    $pwd = getcwd();
	    
	    ///////////////////////////////////////////////////////////////////////
	    // Which kind of barcodes do you want?
	    // Uncomment the next line to use vertical barcodes (default).
	       $barcode = sprintf('%s/images/barcodes-39/rotated/%04d.png',$pwd,(int)$x['id']);
	    // Or, uncomment the next line to use horizontal barcodes.
	    // $barcode = sprintf('%s/images/barcodes-39/%04d.png',$pwd,(int)$x['id']);
	    ///////////////////////////////////////////////////////////////////////
	    
	    $photo = sprintf("%s/images/photos/large/%s.jpg",$pwd,$x['id']);
	    $bg = sprintf('%s/images/badges/%s.png',$pwd,$x['type']);
	    
	    $pdf = new FPDF('l','in',array(3,5));
	    
	    ///////////////////////////////////////////////////////////////////////
	    // The page margins
	       $pdf->setMargins(0.15, 0.25);
	    ///////////////////////////////////////////////////////////////////////
	    
	    $pdf->addPage();
	    $pdf->SetAutoPageBreak(false);
	    $pdf->Image($bg,0,0,5);
	    
	    ///////////////////////////////////////////////////////////////////////
	    // The position of the photo. The numbers are for (in order):
	    // -- distance from the left
	    // -- distance from the top
	    // -- width of the image (or automaticalculated if 0)
	    // -- height of the image
	       if($x['hasPhoto']) $pdf->Image($photo,0.264,0.2175,0,1.711);
	    ///////////////////////////////////////////////////////////////////////
	    
	    ///////////////////////////////////////////////////////////////////////
	    // The position of the barcode. The measurements are the same as those
	    // of the photo.
	       $pdf->Image($barcode,4.24,1.21,0.5);
	    ///////////////////////////////////////////////////////////////////////
	    
	    ///////////////////////////////////////////////////////////////////////
	    // Commands to print the name. Read the docs for info. It's too complex
	    // to document here.
	       $pdf->setFont('Arial','B',48);
	       $pdf->Cell(0,2.2,'',0,2); //args: width, height, text, border, next cell location code
	       $pdf->Cell(0.025);
	       $pdf->Cell($pdf->GetStringWidth($x['firstName']),0,$x['firstName']);
	       $pdf->setFont('Arial','',12);
	       $pdf->Cell($pdf->GetStringWidth($x['lastName']),0.32,$x['lastName']);
	    ///////////////////////////////////////////////////////////////////////
	    
	    //$pdf->Output('/tmp/badge.pdf','F');
	    $pdf->Output($x['id'].'.pdf','I');
	}
		
	function _peopleList($type) {
	    $this->load->model("meetings_model", "m");
	    
	    switch($type) {
	        case 'all': $data['title'] = 'Registered People'; break;
	        case 'kid': $data['title'] = 'Registered Kids'; break;
	        case 'staff': $data['title'] = 'Registered Staff'; break;
	        case 'parent': $data["title"] = 'Registered Parents'; break;
	        case 'guest': $data["title"] = 'Registered Guests'; break;
	    }
	    
	    //are we currently in a meeting?
	    $data['meetingInProgress'] = ($this->m->meetingInProgress() === false) ? false : true;
	    
	    $this->db->select(array('id','firstName','lastName','type','dateOfBirth'));
	    if($type != 'all') $this->db->where('type', $type);
	    $this->db->order_by('type asc,firstName asc,lastName asc');
	    $query = $this->db->get('people');
	    
	    if($query->num_rows == 0) $data['list'] = false;
	    
	    foreach($query->result_array() as $row) {
	        $id = $row['id'];
	        $name = $row['firstName'].' '.$row['lastName'];
	        $data['list'][$id]['actions'] = anchor("people/view/$id", "Details",'class=button')."
                ".anchor("people/edit/$id", "Change",'class=button')."
                ".anchor("people/delete/$id", "Delete", array('class' => 'button','onclick' => "return confirm('Are you sure that you want to delete $name?')"));
	        if($type == 'all') {
	            //$data['list'][$id]['type'] = ($row['type'] == 'staff') ? 'Staff' : 'Kid';
	            $data["list"][$id]['type'] = ucfirst($row['type']);
	        }
	        $data['list'][$id]['name'] = $name;
	        
	        if($type == 'kid' || $type == 'all') {
	            //age stuff
	            $dob = $row['dateOfBirth']." 00:00:00";
                $age = $this->_findAge(strtotime($dob),$dob);
	            $data['list'][$id]['age'] = ($row['type'] == 'kid') ? $age : '&nbsp;';
	        }
	    }
	    
	    $heading[] = 'Actions';
	    if($type == 'all') $heading[] = 'Type';
	    $heading[] = 'Name';
	    if($type == 'kid' || $type == 'all') $heading[] = 'Age';
	    $data['heading'] = $heading;
	    
	    $data['display'] = $type; //Which table are we displaying?
	    $this->load->view('home/people/index',$data);
	}
	
	function _findAge($dob,$human = null) { //expects a UNIX timestamp
	    $age = timespan($dob, time());
	    //echo "\$dob = $dob<br/>\n\$human = $human</br>\n\$age = $age<br/><br/>\n\n";
	    return substr($age, 0, strpos($age,' '));
	}
	
	function _handlePhoto($id) {
	    //echo "<pre>" . print_r($_FILES, true) . "</pre>";
	    if(isset($_FILES['photo']) && $_FILES['photo']['tmp_name']) {
            if(!($this->form_validation->writable_directory(array('images/photos/large','images/photos/medium','images/photos/small'))
                    )) {
                $this->load->view("home/error", array('error' => "Error: ".$this->form_validation->error_string));
            }
            $pu = new Photo_upload($this);
            $_POST["hasPhoto"] = $pu->upload_photo($_FILES['photo']['tmp_name'],$id);
            //print_r($_FILES['photo']['tmp_name']);
            return $_POST['hasPhoto'];
        }
        return false;
	}
}
