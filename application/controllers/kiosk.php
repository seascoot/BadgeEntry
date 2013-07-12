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
 
class Kiosk extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("meetings_model", "m");
		$this->config->set_item('disable_template', TRUE);
    }
    
   	function index() {
   	    $meetingID = $this->m->meetingInProgress();
   	    if($meetingID === false) $this->load->view("home/error", array(
   	        'error' => "You have to activate a meeting before you can use the kiosk.",
   	        'title' => "Kiosk Error",
   	        'refresh' => array(10)
   	    ));
        $this->db->select("mode");
        $this->db->select("meetingTitle");
        $this->db->where("id", "$meetingID");
        $query = $this->db->get("meetings");
        
        $data['modeRaw'] = $query->row()->mode;
        $data['mode'] = $this->m->getMeetingStatus($data['modeRaw']);
        $data['event'] = $this->conf->option['event_name'];
        $data['meetingTitle'] = $query->row()->meetingTitle;
        
   	    $this->load->view("home/kiosk/index", $data);
	}
	
	function process() {
	    $mode = $this->input->post('mode');
	    $id = (int)$this->input->post('id');
	    $meetingID = $this->m->meetingInProgress();
	    $data['event'] = $this->conf->option['event_name'];
	    $error = false;
	    $errorText = '';
	    
	    if($meetingID === false) $this->load->view("home/error", array(
   	        'error' => "You have to activate a meeting before you can use the kiosk.",
   	        'title' => "Kiosk Error",
   	        'refresh' => array(10,base_url().'home/kiosk')
   	    ));
   	    $this->db->select("mode");
   	    $this->db->where("id", "$meetingID");
   	    $query = $this->db->get("meetings");
   	    if($query->row()->mode != $mode) $this->load->view("home/error", array(
   	        'error' => "The meeting is in ".$query->row()->mode." mode, but you tried to $mode.<br />Please check the settings and try again.",
   	        'title' => "Kiosk Error",
   	        'refresh' => array(5,base_url().'home/kiosk')
   	    ));
	    
	    $this->db->select("firstName");
	    $this->db->select("lastName");
	    $this->db->select("hasPhoto");
	    $this->db->select("status");
	    $this->db->where("id", "$id");
	    $query = $this->db->get("people");
	    
	    if($query->num_rows() != 1) {
	        $error = true;
	        $errorText .= "I can't find anybody who matches that barcode. Maybe it didn't get scanned right.";
	    }
	    elseif($query->row()->status == $mode) {
	        $error = true;
	        switch($mode) {
	            case 'enter': $tmp = 'in'; break;
	            case 'exit' : $tmp = 'out'; break;
	        }
	        $errorText .= "You're already signed $tmp. I can't sign you $tmp again.";
	    }
	    
        if(!$error) {
            $data['name'] = $query->row()->firstName.' '.$query->row()->lastName;
            $data['hasPhoto'] = ($query->row()->hasPhoto == 'true') ? true : false;
            $data['greeting'] = ($mode == 'enter') ? 'Welcome' : 'Goodbye';
            $data['id'] = $id;
            
	        $this->db->insert("attendance", array('person_id' => $id, 'meeting_id' => $meetingID, 'type' => $mode));
    	    $this->db->where("id", $id);
    	    $this->db->update("people", array('status' => $mode));
    	    
    	    $this->load->view("home/kiosk/success", $data);
	    }
	    else {
	        $this->load->view("home/kiosk/error", array('error' => $errorText,'event' => $data['event']));
	    }
	}
	
	function checkMode() {
	    $id = $this->m->meetingInProgress();
	    $this->db->select("mode");
	    $this->db->where("id", "$id");
	    $query = $this->db->get("meetings");
	    header('Content-Type: text/plain');
	    if($query->num_rows() == 1) echo $query->row()->mode;
	    else echo 'error';
	}
}
