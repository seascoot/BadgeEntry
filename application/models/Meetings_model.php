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

class Meetings_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function getMeetingStatus($mode) {
        switch($mode) {
            case "enter": return "Sign in";
            case "exit" : return "Sign out";
            default     : return "&nbsp;";
        }
    }
    
    function meetingClosedOut($id) {
        $this->db->where("meeting_id", "$id");
        $this->db->where("mode", "closeout");
        $query = $this->db->get("meeting_modes");
        if($query->num_rows() != 0) return true;
        else return false;
    }
    
    function printMeetingStatus($mode,$id, $printWhat = 'mode') {
        $str = $this->getMeetingStatus($mode);
        
        //Has this meeting been closed out?
        if($this->meetingClosedOut($id)) return false;
        
        if($printWhat == 'mode') return $str;
        elseif($printWhat == 'button') {
            switch($str) {
                case "Sign in": return anchor("meetings/signout/$id", 'Sign out','class="btn btn-mini"');
                case "Sign out": return anchor("meetings/signin/$id", "Sign in",'class="btn btn-mini"') . anchor("meetings/closeout/$id", 'Close out','class="btn btn-mini" onclick="return confirm(\'Once you close a meeting, you will no longer be able to switch it to sign in or sign out mode. In other words, THIS ACTION CANNOT BE UNDONE.\n\nAre you sure you want to continue?\');"');
                default:
                    if($this->meetingInProgress(true) === false) return anchor("meetings/signin/$id", "Sign in",'class="btn btn-mini"');
            }
        }
        else $this->load->view("home/error", array('error' => "Invalid call: File ".__FILE__." line ".__LINE__));
    }
    
    function meetingInProgress($enterOnly = false) {
        //returns the ID of the current meeting, or false if there is no meeting in progress.
        $this->db->select('id');
        $this->db->where("mode", "exit");
        if(!$enterOnly) $this->db->or_where("mode", "enter");
        $query = $this->db->get("meetings");
        
        if($query->num_rows() == 0) return false;
        else return $query->row()->id;
    }
    
    function formatTime($time, $includesDate = false) {
        if($includesDate && $time) {
            $tmp = explode(" ",$time);
            $date = $tmp[0]." ";
            $time = $tmp[1];
        }
        else $date = null;
        $time = explode(':', $time);
        if(is_numeric($time[0])) {
            $ap = 'AM';
            $time[0] *= 1;
        }
        else $ap = '';
        if($time[0] > 12) {
            $time[0] -= 12;
            $ap = 'PM';
        }
        elseif(is_numeric($time[0]) && $time[0] == 0) $time[0] = 12;
        
        if(isset($time[2]) && (int)$time[2] == 0) unset($time[2]);
        /*echo "<pre>";
        var_dump($time);
        echo "</pre";*/
        
        return $date . implode(":", $time) . " $ap";
    }
    
    function signIn($meetingID) {
        $this->db->select('id');
        $this->db->where("mode", "exit");
        $query = $this->db->get("meetings");
        
        if($query->num_rows() > 0) {
            foreach($query->result() as $row) {
                $this->db->or_where("id", $row->id);
            }
            $this->db->update("meetings", array('mode' => 'none', 'ended' => 'NOW()'));
        }
        
        $this->db->where("id", $meetingID);
        $this->db->where("started", 'is null');
        $query = $this->db->get("meetings");
        
        if($query->num_rows()) {
            $this->db->where("id", $meetingID);
            $this->db->update("meetings", array('mode' => 'enter', 'started' => 'NOW()'));
            return true;
        }
        else return false;
    }
}