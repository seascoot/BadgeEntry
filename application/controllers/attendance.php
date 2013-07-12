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
 
class Attendance extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("meetings_model", "m");
	$this->template->set('site_title', 'BadgeEntry');
	$this->template->set('page_title', '');
    }
    
   	function index() {
	    $this->load->library("table");
	    
	    $data['title'] = "Current Attendance";
	    
	    //which meeting are we in?
	    $tmp = $this->_currentMeeting();
	    $data['meetingTitle'] = $tmp['meetingTitle'];
	    $data['meetingDate'] = $tmp['meetingDate'];
	    $meetingID = $tmp['meetingID'];
	    
	    //who's here right now?
	    /*$this->db->select('people.firstName, people.lastName, people.type');
	    $this->db->from('people');
	    $this->db->join('attendance', 'people.id = attendance.person_id');
	    $this->db->where("attendance.meeting_id", $meetingID);
	    $this->db->where("attendance.type", "enter");
	    $query = $this->db->get();*/
	    $this->db->select('firstName');
	    $this->db->select('lastName');
	    $this->db->select('type');
	    $this->db->where("status", "enter");
	    $this->db->order_by("type");
	    $this->db->order_by('firstName');
	    $query = $this->db->get("people");
	    
	    //create attendance table
	    $data['list'] = ($query->num_rows() >= 1) ? $query->result_array() : false;
	    $data['heading'] = array(
	                                'First name',
	                                'Last name',
	                                'Type'
	                            );
	    
	    //load view
	    $this->load->view("home/attendance/index", $data);
	}
	
//	function signin() {
//	    $this->load->helper("form");
//	    $this->template->javascript('assets/js/signinout.js');
//		$this->template->stylesheet('assets/css/signinout.css');
//		//$this->template->javascript('assets/js/url.js');
//		$url_js = site_url('attendance/findnames/signin');
//		$this->template->set('extraHeadData', "<script type=\"text/javascript\">
//        var url = \"$url_js\";</script>");
//		$data = $this->_currentMeeting();
//	    $data['title'] = "Sign Someone In";
//	    $data['mode'] = 'signin';
//	    $this->load->view("home/attendance/signinout", $data);
//	}

	function signin() {
            $this->load->helper("form");
            $this->template->javascript('assets/js/underscore-min.js');
            $this->template->javascript('assets/js/typeahead.min.js');
 //           $this->template->javascript('assets/js/my-phpjavascript.js.php');
            $data = $this->_currentMeeting();
//            $data['search_url'] = site_url('attendance/get_people');
            $data['title'] = "Sign Someone In";
            $data['attributes_form'] = array('id' => 'signInOutForm','class' => 'form-horizontal validate', 'enctype' => 'multipart/form-data');
            $data['mode'] = 'signin';
            $this->load->view("home/attendance/signinout", $data);
	}	

	function signout() {
            $this->load->helper("MY_form");
            $this->template->javascript('assets/js/underscore-min.js');
            $this->template->javascript('assets/js/typeahead.min.js');
            $this->template->javascript('assets/js/my-phpjavascript.js.php');
            $data = $this->_currentMeeting();
            $data['attributes_form'] = array('id' => 'signInOutForm','class' => 'form-horizontal validate', 'enctype' => 'multipart/form-data');
            $data['id'] = '';
            $data['title'] = "Sign Someone Out";
            $data['mode'] = 'signout';
            $this->load->view("home/attendance/signinout", $data);
	
	}
	
	function random() {
	    $who = $this->uri->segment(3);
	    if(!$who) $who = 'any';
	    
	    $this->db->select('firstName');
	    $this->db->select('lastName');
	    $this->db->where("status", "enter");
	    
	    switch($who) {
	        case 'kid':
	        case 'guest':
	        case 'staff':
	        case 'parent':
	            $this->db->where("type", $who);
	    }
	    
	    $this->db->order_by('RAND()');
	    $this->db->limit(1);
	    $query = $this->db->get("people");
	    
	    if($query->num_rows() != 1) $this->load->view("home/error", array('error' => "No one was selected. Maybe nobody in this category ($who) is here."));
	    
	    $data['firstName'] = $query->row()->firstName;
	    $data['lastName'] = $query->row()->lastName;
	    $data['who'] = $who;
	    $data['title'] = "Random Person";
	    $this->load->view("home/attendance/random", $data);
	}
	
//	function findnames() {
//	    $mode = $this->uri->segment(3);
//	    $meeting = $this->_currentMeeting();
//		$name = $this->input->post('name');
//	    $name = trim($name);
//	    $this->db->select("id, concat(firstName,' ', lastName) as name, type");
//	    $this->db->from('people');
//	    if($mode == 'signin') $this->db->where("status !=", "enter");
//	    else $this->db->where("status", "enter");
//	    $this->db->like("concat(firstName,' ', lastName)", $name);
//	    $this->db->order_by('name');
//	    $query = $this->db->get();
//	    
//	    $data = array();
//	    
//	    foreach($query->result() as $row) {
//	        $id = $row->id;
//	        $data['list'][$id]['name'] = $row->name;
//	        $data['list'][$id]['type'] = $row->type;
//	        $data['list'][$id]['id'] = $id;
//	    }

//	public function findnames() {
//		$this->load->model('findnames_model');
//	    $data['query'] = $this->findnames_model->matchednames();
//	    $this->load->view("home/snippets/nameList", $data);
//	}

	function get_people() {
                $this->config->set_item('disable_template', TRUE);
		$this->load->model('People_model');
		$name = $this->input->post('query');
		$this->People_model->get_person($name);
//		if (isset($_GET['typeahead'])){
//			$q = strtolower($_GET['typeahead']);
//			$this->people_model->get_person($q);
//		}
//		echo "Last query: ".$this->db->last_query()."<br/>";
//	    echo "Number of rows returned: ".$query->num_rows();
//	    echo "<pre>" . print_r($query, true) . "</pre>";
//	    echo "<pre>" . print_r($query->row(), true) . "</pre>";
//	    $data['query'] = $this->people_model->get();


//		if($data ==false)
//			{
//			die('There are no results!');
//			}
			// there's results..
//			echo $data;
//			print_r($data ->result());
//			var_dump($people_list);			
	}
	
	function dosigninout() {
	    $mode = $this->uri->segment(3);
	    switch($mode) {
	        case 'signin':
	            $mode = 'enter';
	            break;
	        case 'signout':
	            $mode = 'exit';
	            break;
	        default:
	            $this->load->view("home/error", array('error' => "Invalid mode specified."));
	    }
	    $meeting = $this->_currentMeeting();
	    $person = $this->input->post('person_id');
	    /*echo "<pre>" . print_r($_POST, true) . "</pre>";
	    $this->db->select("CONCAT(firstName,' ', lastName) AS name, type",FALSE);
	    $this->db->where("id", $person);
	    $query = $this->db->get("people");
	    echo "Last query: ".$this->db->last_query()."<br/>";
	    echo "Number of rows returned: ".$query->num_rows();
	    echo "<pre>" . print_r($query, true) . "</pre>";
	    echo "<pre>" . print_r($query->row(), true) . "</pre>";*/
	    
	    if(!$this->_validPerson($person, $this->input->post('person_name'))) $this->load->view("home/error", array('error' => "You requested an operation with ".$this->input->post('person_name')." who has an ID of $person. The name and ID don't match."));
	    //echo "<pre>" . print_r($meeting, true) . "</pre>";
	    $this->db->insert("attendance", array('person_id' => $person, 'meeting_id' => $meeting['meetingID'], 'type' => $mode));
	    $this->db->where("id", $person);
	    $this->db->update("people", array('status' => $mode));
	    $redirectTo = (isset($_POST['redirect'])) ? $this->input->post('redirect') : false;
	    if($redirectTo) redirect($redirectTo);
        else redirect('attendance');
	}
	
	function _currentMeeting() {
	    $meetingID = $this->m->meetingInProgress();
	    if($meetingID === false) $this->load->view("home/error", array('error' => "No meeting is currently in progress. That means that no one's officially here. Please start a meeting, then come back."));
	    
	    $this->db->select(array('meetingTitle', 'date'));
	    $this->db->where("id", $meetingID);
	    $query = $this->db->get("meetings");
	    
	    if($query->num_rows() == 0) $this->load->view("home/error", array('error' => "No such meeting. This error should never occur. File: ".__FILE__." Line: ".__LINE__));
	    $data['meetingTitle'] = $query->row()->meetingTitle;
	    $data['meetingDate'] = $query->row()->date;
	    $data['meetingID'] = $meetingID;
	    
	    return $data;
	}
	
	function _validPerson($id, $name) {
	    //echo "<pre>" . print_r(array('id' => "'$id'", 'name' => "'$name'"), true) . "</pre>";
	    $this->db->select("firstName");
	    $this->db->select('lastName');
	    $this->db->where("id", $id);
	    $query = $this->db->get("people");
        /*echo "<pre>" . print_r($this->db->last_query(), true) . "</pre>";
	    echo "<pre>" . print_r(array('mysql_error' => "'".mysql_error()."'"), true) . "</pre>";
	    echo "<pre>" . print_r($query, true) . "</pre>";
	    echo "<pre>" . print_r($query->num_rows(), true) . "</pre>";
	    echo "<pre>" . print_r($query->row(), true) . "</pre>";*/
	    
	    if($query->num_rows() != 1) return false;
	    if($query->row()->firstName . " " . $query->row()->lastName != $name) return false;
	    return true;
	}
}
