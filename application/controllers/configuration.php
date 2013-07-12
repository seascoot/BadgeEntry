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

class Configuration extends CI_Controller {

    function __construct() {
        parent::__construct();
		$this->template->set('site_title', 'BadgeEntry');
		$this->template->set('page_title', '');
	}
	
	function index() {
	    if(!isset($this->conf->option['config_level'])) $this->conf->option['config_level'] = -1;
	    switch($this->conf->option['config_level']) {
	        case -1:
	        case 0:
	            $this->options();
	            break;
	        case 1:
	            if(isset($_POST['baseURL'])) $this->options();
	            else redirect('configuration/badges/intro');
	            break;
	        default:
	            $data['title'] = "Configuration Options";
	            $this->load->view("home/config/index", $data);
	    }
	}
	
	function options() {
	    if(!$this->conf->databaseExists) $this->db();
	    else {
            if(isset($_POST['baseURL'])) $data['message'] = $this->_process_options();
            $this->load->helper("form");
            $data['title'] = "Setup";
            $data['baseURL'] = (isset($this->conf->option['base_url'])) ? $this->conf->option['base_url'] : 'http://'.$_SERVER['SERVER_ADDR'].'/';
            $data['event_name'] = (isset($this->conf->option['event_name'])) ? $this->conf->option['event_name'] : '';
            $data['profiling'] = (isset($this->conf->option['profiling_enabled'])) ? $this->conf->option['profiling_enabled'] : false;
            $this->load->view("home/config/options", $data);
	    }
	}
	
	function badges($type = "intro") {
	    if($type == 'confirm' && isset($_POST['been_here'])) {
	        $stage = $_POST['been_here'];
	        if($stage == 1) {
	            $data['title'] = "Preview Badges";
	            $this->load->view("home/config/badges_preview", $data);
	        }
	        elseif($stage == 2) {
	            $this->conf->set_value('config_level', 2);
	            //$this->conf->enable_option('config_level');
	            $data['title'] = "Congratulations!";
	            $this->load->view("home/config/congratulations", $data);
	        }
	    }
        else {
	        $data['title'] = "Set Up Badges";
	        $this->load->view("home/config/badges", $data);
	    }
	}
	
	function db() {
	    $this->load->dbutil();
	    
	    // see whether the configured database exists and set some variables...
	    $databaseList = $this->dbutil->list_databases();
	    $db = $this->db->database;
	    $user = $this->db->username;
	    $dbType = $this->db->dbdriver;
	    if(!in_array($db,$databaseList)) {
	        //attempt to create the database
	        if(!$this->dbutil->create_database($db)) $this->load->view("error", array('error' => "I can't create the database $db. This probably means that the user $user doesn't have adequate priviledges. Please create the database manually, then refresh this page (F5 in most browsers) to continue."));
	    }
	    
	    //create the necessary tables...
	    $this->_import_schema($dbType);
	    
	    $data['title'] = "Success";
	    $this->load->view("home/config/db_success", $data);
	}
		
	function upgrade() {
	    // This function is called when BadgeEntry is upgraded. It
	    // should make any changes required by the upgrade. It should
	    // also check whether the upgrade path is a supported path
	    // and generate an error if not.
	    
	    // All upgrade paths to 0.7 are supported. Yay! It's easy when
	    // this is only the third release! 
	    
	    $this->conf->set_value('version',BADGEENTRY_VERSION);
	    $data['title'] = "Upgrade Success";
	    $this->load->view("home/config/upgrade_success", $data);
	}
	
	function _process_options() {
	    foreach($_POST as $k => $v) {
/*  removed for 2.0 compatibility	        $_POST['$k'] = $this->input->xss_clean($v); */
			$_POST['$k'] = $this->security->xss_clean($v);
	    }
	    $baseURL = $_POST['baseURL'];
	    $event_name = $_POST['event_name'];
	    $profiling = $_POST['profiling'];
	    
	    //process base URL
	    if(!preg_match('/^http[s]?:\/\//i',$baseURL)) $baseURL = "http://$baseURL";
	    if(!preg_match('/\/$/',$baseURL)) $baseURL .= '/';
	    
	    //process profiling
	    $profiling = ($profiling == 'yes') ? true : false;
	    
	    //save the settings
	    $this->conf->set_value('base_url', $baseURL);
	    $this->conf->set_value('event_name', $event_name);
	    $this->conf->set_value('profiling_enabled', $profiling);
	    $this->conf->set_value('version',BADGEENTRY_VERSION);
	    if($this->conf->option['config_level'] < 1) $this->conf->set_value('config_level', 1);
	    
	    //reload the settings (no longer necessary?)
	    //$this->conf->enable_options(array('base_url', 'event_name', 'profiling_enabled', 'config_level'));
	    
	    $str = 'Your settings have been saved. ';
	    if($this->conf->option['config_level'] <= 1) $str .= anchor('configuration/badges','Set up badges', array('class' => 'button')).' ';
	    elseif($this->conf->option['config_level'] >= 2) $str .= anchor('', 'Go to the start page', array('class' => 'button'));
	    return $str;
	}
	
	function _import_schema($db_type) {
	    // This function is called during the initial install. It
	    // should contain code to initialize the database from
	    // scratch.
	    
	    if($db_type == 'mysql') {
	        // FIXME: Should FILE_IGNORE_NEW_LINES and FILE_SKIP_EMPTY_LINES be or'd together?
	        $file = file(APPPATH."mysql_db_schema.sql",FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES);
	        $sql = "";
	        if($file === false) $this->load->view("error", array('error' => "Error reading the database schema file."));
	        foreach($file as $v) {
	            if(preg_match('/^\s*--/',$v)) continue;
	            $v = trim($v);
	            $sql .= "$v "; 
	        }
	        $sql = explode(';',$sql);
	        foreach($sql as $k => $v) {
	            $v = trim($v);
	            if(!$v) {
	                unset($sql[$k]);
	                continue;
	            }
	            $sql[$k] = $v;
	        }
	        
	        foreach($sql as $insert) {
	            $success = $this->db->query($insert);
	            if(!$success) $this->load->view("error", array('error' => "MySQL wasn't able to set up your database properly. Please check your settings and try again."));
	        }
	    }
	    else $this->load->view("error", array('error' => "I don't know how to initialize the schema for the database type $db_type. Please either choose a different database or manually create the schema as found in <code>".APPPATH."mysql_db_schema.sql</code>."));
	}
	
	function _import_schema_upgrade($db_type) {
	    // This function is called during the upgrade process. It should
	    // contain code to upgrade the database from the previous release.
	    
	    //BadgeEntry version test goes here to make sure we upgrade properly
	    return true;
	}
}
?>
