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

class Meetings extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', '');
    }
	
	function index() {
	    $this->load->library("table");
	    $this->load->model("meetings_model", "m");
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', '');		
	    
	    $this->db->order_by('date asc, startTime asc');
	    if( $this->uri->segment(2) != 'all' ) {
	        $this->db->where("date >= NOW()");
	        $data["showAll"] = false;
	    }
	    else $data["showAll"] = true;
	    $query = $this->db->get("meetings");
	    if($query->num_rows() == 0) $data["list"] = false;
	    else {
	        foreach($query->result() as $row) {
	            $id = $row->id;
	            $mtgStart = trim($this->m->formatTime($row->started, true));
	            $deleteAvailable = ($mtgStart) ? '' : " " . anchor("meetings/delete/$id", "Delete",array('class' => "btn btn-mini", 'onclick' => "return confirmDelete('meeting','".$row->meetingTitle."')"));
	            $editAvailable = ($this->m->meetingClosedOut($id)) ? '' : anchor("meetings/edit/$id","Edit",'class="btn btn-mini"');
	            
	            $data["list"][$id]['actions'] = $editAvailable . $deleteAvailable;
	            $data['list'][$id]['actions'] .= $this->m->printMeetingStatus($row->mode, $id, 'button');
	            $data['list'][$id]['actions'] .= anchor("reports/attendance/$id", 'Attendance', array('class' => 'btn btn-mini'));
	            $data['list'][$id]['status'] = "<span class=\"single-line\">".$this->m->printMeetingStatus($row->mode, $id).'</span>';
	            $data['list'][$id]['meetingTitle'] = $row->meetingTitle;
	            $data["list"][$id]['date'] = '<span class="single-line">'.$row->date.'</span>';
	            $data['list'][$id]['startTime'] = '<span class="single-line">'.$this->m->formatTime($row->startTime).'</span>';
	            $data['list'][$id]['endTime'] = '<span class="single-line">'.$this->m->formatTime($row->endTime).'</span>';
	            $data['list'][$id]['started'] = $mtgStart;
	            $data['list'][$id]['ended'] = $this->m->formatTime($row->ended, true);
	        }
	    }
	    $data["heading"] = array ('Actions',
	                              "Mode",
	                              'Meeting title',
	                              'Date',
	                              'Start',
	                              'End',
	                              "Sign in began",
	                              "Sign out ended"
	                             );
	    $data["title"] = "Meetings";
	    
        $this->load->view("home/meetings/index", $data);
	}
	
	function all() {
        $this->index();
    }
    
    function add() {
        $this->edit();
    }
    
   	function edit() {
   	    $this->load->helper("time");
	    $this->load->helper('form');
	    $this->load->library('form_validation');
	    $this->load->model("meetings_model", "m");
		$data['attributes_form'] = array('class' => 'form-horizontal validate');		
	    
	    if(is_numeric($this->uri->segment(3))) {
	        $data['id'] = $this->uri->segment(3);
	        $data['title'] = "Edit Meeting";
	    }
	    elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {
	        $data['id'] = $_POST['id'];
	        $data['title'] = "Edit Meeting";
	    }
	    else {
	        $data['title'] = 'Add Meeting';
	    }
	    
	    $data["meetingTitle"] = '';
	    $data["date"] = '';
	    $data["startTime"] = '';
	    $data["endTime"] = '';
	    
	    if(isset($data['id'])) {
	        $this->db->select('id, meetingTitle, date, startTime, endTime');
            $this->db->where('id', $data['id']);
            $query = $this->db->get('meetings');
            if($query->num_rows() != 1) $this->load->view("home/error", array('error' => "Invalid meeting ID"));
            $row = $query->row_array();
            
            foreach($row as $field => $value) {
                if($value) $data[$field] = $value;
            }
            if($data['startTime']) $data['startTime'] = $this->m->formatTime($data['startTime']);
            if($data['endTime']) $data['endTime'] = $this->m->formatTime($data['endTime']);
        }
        
        //validation
        $this->load->library('form_validation');
	$this->form_validation->set_error_delimiters('<div class="text-error">', '</div>');
	$this->form_validation->set_rules('meetingTitle','meeting title','trim|required|alpha_punc|xss_clean');
	$this->form_validation->set_rules('date','meeting date','trim|required|valid_date|iso_date|xss_clean');		
	$this->form_validation->set_rules('startTime','starting time','trim|required|time12to24|xss_clean');
	$this->form_validation->set_rules('endTime','ending time','trim|required|time12to24|xss_clean');
        if($this->form_validation->run() == false) { //validation failed
            $this->load->view('home/meetings/edit',$data);
    	}
        else { //validation succeeded
            // Updating a current entry
            
            if($_POST['startTime'] === false || $_POST['endTime'] === false) {
                $this->load->view("home/error", array("The start or end time is invalid. You shouldn't ever see this message. Since you are seeing it, you've found a bug. Congratulations!\n<br />File: ".__FILE__."\n<br/>Line: ".__LINE__));
        }
            
        if(
            isset($_POST['id']) && 
                $this->db->get_where('meetings',array('id' => $_POST['id']))->num_rows() == 1
                    ) {
                $this->db->where('id', $_POST['id']);
                unset($_POST['id']);
                $this->db->update('meetings', $_POST);
            }
    	    // Adding a new entry
            elseif(!isset($_POST['id'])) {
    	        $this->db->insert("meetings", $_POST);
    	        $ins_id = $this->db->insert_id();
    	        //print_r($_POST);
            }
    	    else { // We have bogus postdata
    	        $this->load->view("home/error", array('error' => "Unknown error with your postdata. File: ".__FILE__.":".__LINE__));
            }
    	    redirect('meetings');
    	}
}
	
	function delete() {
	    $id = $this->uri->segment(3);
	    $error = false;
	    
	    if(!$id) $error = true;
	    if(!$error) {
	        $this->db->select('started');
	        $this->db->where("id", "$id");
	        $query = $this->db->get("meetings");
	        if($query->num_rows() != 1) $error = true;
	        elseif(trim($query->row()->started)) $error = true;
	        $query->free_result();
	    }
	    if($error) $this->load->view("home/error", array("You can't delete this!"));
	    
	    $this->db->where("id", "$id");
	    $this->db->delete("meetings");
	    redirect('meetings');
	}
	
	function signin() {
	    $this->_signInOut();
	}
	
	function signout() {
	    $this->_signInOut();
	}
	
	function closeout() {
	    $this->_signInOut();
	}
	
	function _signInOut($outputContent = true) { //$outputContent tells us whether we should output/redirect or if we're getting called by someone else.
	    //Can't use this function directly...
	    if(strtolower($this->uri->segment(2)) == '_signinout') {
	        $this->load->view("home/error",
	            array(
	                'http_status' => 404,
	                'title'       => '404 Not Found',
	                'error'       => "The page you requested couldn't be found. Please check the address and try again."
	            )
	        );
	    }
        
	    $id = $this->uri->segment(3);
	    $action = $this->uri->segment(2);
	    
	    //valid meeting?
	    $this->db->where("id", $id);
	    $query = $this->db->get("meetings");
	    if($query->num_rows() != 1) $this->load->view("home/error", array('http_status' => 404, 'error' => "No such meeting exists!"));
	    
	    //Current meeting mode
	    $meeting = $query->row();
	    $mode = $meeting->mode;
	    /*echo "<pre>" . print_r($mode, true) . "</pre>";*/
	    
	    //validate meeting mode
	    switch($action) {
	        case 'signout':
	            //make sure we're in signin mode
        	    if($mode != 'enter') $this->load->view("home/error", array("error" => "Can't sign out of a meeting that isn't currently marked as in progress."));
        	    break;
        	case 'signin':
        	    //currently in sign-in mode?
        	    if($mode == 'enter') $this->load->view("home/error", array('error' => "Already in sign in mode."));
        	    
        	    //is another meeting in progress?
        	    $this->db->select(array('meetingTitle','date'));
        	    $this->db->where("id !=", $id);
        	    $this->db->where("(mode = 'enter' OR mode = 'exit')");
        	    $query = $this->db->get("meetings");
        	    if($query->num_rows() != 0) $this->load->view("home/error", array("error" => "Another meeting, ". $query->row()->meetingTitle . " on " . $query->row()->date .", is currently in progress. You must first close out that meeting before you can start this one."));
        	    
        	    //has another meeting been started but not closed out?
        	    //Note: I believe that this test is bogus
        	    //$this->load->view("error", array('error' => 'FIXME: Not implemented yet.'));
        	    
        	    //has this meeting been closed out already?
        	    $this->db->select('id');
        	    $this->db->where("meeting_id", $id);
        	    $this->db->where("mode", 'closeout');
        	    $query = $this->db->get("meeting_modes");
        	    if($query->num_rows() != 0) $this->load->view("home/error", array('error' => "This meeting has been closed out. You can't make any further changes to it."));
        	    
        	    break;
        	case 'closeout':
        	    //is this meeting currently in signout mode?
        	    $this->db->select('mode');
        	    $this->db->where("id", "$id");
        	    $this->db->where("mode", "exit");
        	    $query = $this->db->get("meetings");
        	    if($query->num_rows() != 1) $this->load->view("home/error", array('error' => "This meeting must be in signout mode before you can close it."));
        	    
        	    //are there any people still in the meeting?
        	    $this->db->select(array('firstName', 'lastName'));
        	    $this->db->where("status", "enter");
        	    $query = $this->db->get("people");
        	    if($query->num_rows() != 0) {
        	        $tmp = '';
        	        foreach($query->result() as $row) $tmp .= '<li>'.$row->firstName.' '.$row->lastName.'</li>';
        	        $this->load->view(
        	            "home/error",
        	            array(
        	                'error' => "You can't close a meeting out until everyone is signed out. The following people are still signed in: <ul>".$tmp."</ul>",
        	                'title' => "Can't Close Meeting"
        	            )
        	        );
        	    }
        	    
        	    break;
        	default:
        	    $this->load->view("home/error", array("error" => "Congratulations! You've found a bug. File ".__FILE__." Line ".__LINE__));
	    }
	    
	    //Do signout
	    switch($action) {
	        case 'signout':
	            $this->db->where("id", $id);
	            $this->db->update("meetings", array('mode' => 'exit'));
	            $this->db->insert("meeting_modes", array('meeting_id' => $id, 'mode' => 'exit'));
	            break;
	        case 'signin':
	            $updateTime = ($meeting->started) ? $meeting->started : date('Y-m-d H:i:s');
	            $this->db->where("id", "$id");
	            $this->db->update("meetings", array('mode' => 'enter', 'started' => $updateTime));
	            $this->db->insert("meeting_modes", array('meeting_id' => $id, 'mode' => 'enter'));
        	    break;
        	case 'closeout':
        	    $this->db->where("id", "$id");
        	    $this->db->update("meetings", array('mode' => 'none', 'ended' => date('Y-m-d H:i:s')));
        	    $this->db->insert("meeting_modes", array('meeting_id' => $id, 'mode' => 'closeout'));
        	    break;
        	default:
        	    $this->load->view("home/error", array("error" => "Congratulations! You've found a bug. File ".__FILE__." Line ".__LINE__));
	    }
	    
	    //Redirect
	    if($outputContent) {
	        $all = (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'meetings/all') === false) ? '' : '/all';
            redirect('meetings'.$all);
        }
	}
}
