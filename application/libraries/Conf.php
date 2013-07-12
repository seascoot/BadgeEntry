<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

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

define('BADGEENTRY_VERSION', '0.7');

class Conf {
    
    function Conf() {
        $this->CI =& get_instance();
        $this->databaseExists = $this->validateTable('config'); 
        if(!$this->databaseExists) {
            $this->dbError = "Your database isn't set up properly. Please reconfigure it before continuing. ".anchor('configuration/db','Reconfigure database &raquo;', array('class' => 'button'));
            return false;
        }
        $this->set_keys();
        $this->enable_options();
        $this->CI->output->enable_profiler(isset($this->option['profiling_enabled']) ? $this->option['profiling_enabled'] : false);
    }
    
    function get_value($key) {
        if(!$this->databaseExists) $this->CI->load->view("error", array('error' => $this->dbError, 'title' => 'Database Error'));
        $this->CI->db->select("value");
        $this->CI->db->where("key", $key);
        $query = $this->CI->db->get("config");
        if($query->num_rows() != 1) return false;
        $value = unserialize($query->row()->value);
        //$this->option[$key] = $value;
        return $value;
    }
    
    function set_value($key,$value) {
        if(!$this->databaseExists) $this->CI->load->view("error", array('error' => $this->dbError, 'title' => 'Database Error'));
        $value = serialize($value);
        
        $this->CI->db->where("key", $key);
        $query = $this->CI->db->get("config");
        if($query->num_rows() != 0) {
            $this->CI->db->where("key", "$key");
            $this->CI->db->update("config", array('value' => $value));
            if($this->CI->db->affected_rows() != 1) return false;
        }
        else {
            if(! $this->CI->db->insert("config", array('key' => $key, 'value' => $value))) $this->CI->load->view("error", array('error' => "I can't seem to set the configuration option '$key' to '$value'. The database said: FIXME: Don't know how to extract the error message."));
        }
        
        $value = unserialize($value);
        $this->CI->config->set_item($key,$value);
        $this->option[$key] = $value;
        return true;
    }
    
    function enable_option($keys = false) {
        if(!$this->databaseExists) $this->CI->load->view("error", array('error' => $this->dbError, 'title' => 'Database Error'));
        if($keys) {
            if(!is_array($keys)) $keys = array($keys);
        }
        else $keys = $this->keys;
        
        foreach($keys as $key) {
            $value = $this->get_value($key);
            $this->CI->config->set_item($key,$value);
            $this->option[$key] = $value;
        }
    }
    
    function enable_options($keys = false) {
        $this->enable_option($keys);
    }
    
    function set_keys() {
        if(!$this->databaseExists) $this->CI->load->view("error", array('error' => $this->dbError, 'title' => 'Database Error'));
        $this->keys = array();
        $this->CI->db->select("key");
        $query = $this->CI->db->get("config");
        foreach($query->result() as $row) {
            $this->keys[] = $row->key;
        }
    }
    
    function _test_database() {
        return ($this->CI->db->table_exists('config')) ? true : false;
    }
	
	function validateTable($tableName)
    {
        $result = $this->CI->db->list_tables();

        foreach( $result as $row ) {
            if( $row == $tableName )    return true;
        }
        return false;
    }
}
?>
