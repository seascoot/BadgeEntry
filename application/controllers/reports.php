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

class Reports extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', '');
    }
    
   	function index() {
   	    $this->load->view("home/reports/index", array('title' => "Available Reports"));
	}
	
	function attendance() {
	    $this->load->helper("time");
	    $meeting = $this->uri->segment(3);
	    $data = array();
	    $data['meeting_id'] = $meeting;
	    $data['title'] = 'Meeting Report';
	    
	    if($meeting) {
	        $this->db->where("id", "$meeting");
	    }
	    $this->db->order_by('date,startTime,meetingTitle');
	    $query = $this->db->get("meetings");
	    if($query->num_rows() == 0) $this->load->view("home/error", array('error' => "Invalid meeting selected"));
	    
	    $i = 0;
	    foreach($query->result() as $row) {
	        $id = $row->id;
	        $data['list'][$i]['id'] = $id;
	        $data['list'][$i]['meetingTitle'] = $row->meetingTitle;
	        $data['list'][$i]['date'] = $row->date;
	        $data['list'][$i]['startTime'] = time24to12($row->startTime);
	        $data['list'][$i]['endTime'] = time24to12($row->endTime);
	        $data['list'][$i]['mode'] = ($row->mode == 'enter' || $row->mode == 'exit') ? "In progress" : "Not in progress";
	        if($row->started) {
	            $tmp = explode(' ',$row->started);
	            $tmp[1] = time24to12($tmp[1]);
	            $data['list'][$i]['started'] = implode(' ', $tmp);
	        }
	        else $data['list'][$i]['started'] = false;
	        if($row->ended) {
    	        $tmp = explode(' ',$row->ended);
	            $tmp[1] = time24to12($tmp[1]);
	            $data['list'][$i]['ended'] = implode(' ', $tmp);
	        }
	        else $data['list'][$i]['ended'] = false;
	        
	        if($meeting) {
	            $data['title'] = "Attendance Report";
	            $data['isMeeting'] = true;
	            $this->db->where("meeting_id", "$meeting");
	            $this->db->select('attendance.type');
	            $this->db->select('time');
	            $this->db->select('person_id');
	            $this->db->select('firstName');
	            $this->db->select('lastName');
	            //$this->db->select('people.type');
	            $this->db->from("attendance");
	            $this->db->join('people', 'attendance.person_id = people.id');
	            $this->db->order_by('meeting_id,firstName,lastName,time');
	            $query2 = $this->db->get();
	            
	            //echo "<pre>" . print_r($query2->result_array(), true) . "</pre>";
	            foreach($query2->result_array() as $key => $value) {
	                $j = $value['person_id'];
	                $data['list'][$i]['people'][$j][$key]['id'] = $j;
	                $data['list'][$i]['people'][$j][$key]['name'] = $value['firstName'].' '.$value['lastName'];
	                $data['list'][$i]['people'][$j][$key]['type'] = $value['type'];
	                $tmp = explode(' ', $value['time']);
	                $tmp[1] = time24to12($tmp[1]);
	                $data['list'][$i]['people'][$j][$key]['time'] = implode(' ', $tmp); 
	            }
	        }
	        else $data['isMeeting'] = false;
	        
	        $i++;
	    }
	    //echo "<pre>" . print_r($data, true) . "</pre>";
	    $this->load->view("home/reports/attendance", $data);
	}
	
	function people() {
	    $this->load->helper("time");
	    $id = $this->uri->segment(3);
	    if($id) $this->_personReport($id);
	    else $this->_allPeople();
	}
	
	function _allPeople() {
	    $this->db->select('id');
	    $this->db->select('firstName');
	    $this->db->select('lastName');
	    $this->db->select('type');
	    $this->db->select('timeAdded');
	    $this->db->select('lastModified');
	    $this->db->select('hasPhoto');
	    $this->db->order_by('lastName,firstName,type,timeAdded');
	    $query = $this->db->get("people");
	    
	    $data['title'] = 'People Report';
	    $data['list'] = $query->result_array();
	    
	    foreach($data['list'] as $k => $v) {
	        $tmp = explode(' ',$v['timeAdded']);
	        $tmp[1] = time24to12($tmp[1]);
	        $data['list'][$k]['timeAdded'] = implode(' ',$tmp);
	        
	        $tmp = explode(' ',$v['lastModified']);
	        $tmp[1] = time24to12($tmp[1]);
	        $data['list'][$k]['lastModified'] = implode(' ', $tmp);
	        
	        $data['list'][$k]['hasPhoto'] = ($data['list'][$k]['hasPhoto'] == 'true') ? true : false;
	        $data['list'][$k]['type'] = ucfirst($data['list'][$k]['type']);
	    }
	    
	    $this->load->view("home/reports/allPeople", $data);
	}
	
	function _personReport($id) {
	    $this->db->select('firstName');
	    $this->db->select('lastName');
	    $this->db->where("id", "$id");
	    $query = $this->db->get("people");
	    if($query->num_rows() != 1) $this->load->view("home/error", array('error' => "No such person"));
	    $name = $query->row()->firstName . ' ' . $query->row()->lastName;
	    
	    $data['title'] = "Report on $name";
	    $data['name'] = $name;
	    $data['id'] = $id;
	    
	    $this->db->from("attendance");
	    $this->db->join('meetings', 'attendance.meeting_id = meetings.id');
	    $this->db->select('attendance.type');
	    $this->db->select('attendance.time');
	    $this->db->select('meetings.meetingTitle');
	    $this->db->select('meetings.date');
	    $this->db->select("meetings.id");
	    $this->db->where("person_id", "$id");
	    $this->db->order_by('meetings.id, attendance.time');
	    $query = $this->db->get();
	    $tmp = $query->result_array();
	    $tmp2 = array();
	    foreach($tmp as $k => $v) {
	        $v['meeting_id'] = $v['id'];
	        unset($v['id']);
	        $v['type'] = ucfirst($v['type']);
	        $tmp3 = explode(' ',$v['time']);
	        $tmp3[1] = time24to12($tmp3[1]);
	        $v['time'] = implode(' ', $tmp3);
	        
	        $tmp2[$v['meeting_id']][$k] = $v;
	    }
	    $tmp2 = array_merge($tmp2);
	    foreach($tmp2 as $k => $v) {
	        $tmp2[$k] = array_merge($v);
	    }
	    $data['list'] = $tmp2;
	    unset($tmp,$tmp2,$tmp3);
	    
	    $this->load->view("home/reports/person", $data);
	}
}
