<?php

/*
 * BadgeEntry
 *
 * Copyright (C) 2007 Scott Severance <http://badgeentry.sourceforge.net>
 * Copyright (C) 2013 Clive S. Woodhouse
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
 *  Clive S. Woodhouse
 */
 
class People_model extends CI_Model{

   function __construct() {
        parent::__construct();
   }
	function get_person($name) {
		$modeinout = $this->uri->segment(3); 
                $this->db->select("id, CONCAT(firstName,' ', lastName) AS name, type",FALSE);
		$this->db->from('people');
		if($modeinout == 'signin'){
			$this->db->where('status !=', 'enter');
                }        
		else {
			$this->db->where('status', 'enter');
                }       
		$this->db->like("concat(firstName,' ', lastName)", $name);
		$this->db->order_by('name');
		$query = $this->db->get();
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
			$new_row['name']=htmlentities(stripslashes($row['name']));
			$new_row['id']=htmlentities(stripslashes($row['id']));
			$row_set[] = $new_row; //build an array
			}
		}
		echo json_encode($row_set); //format the array into json data
	}
//		$data = array();
//		foreach($query->result() as $row) {
//			$id = $row->id;
//			$data['list'][$id]['name'] = $row->name;
//			$data['list'][$id]['type'] = $row->type;
//			$data['list'][$id]['id'] = $id;
//		}
//		if($query->num_rows() == 0)
//		{
//			return false;
//		}
//		return $data;
//		old code start
//		$this->db->select("CONCAT(firstName,' ', lastName) AS name",FALSE);
//		$this->db->like("concat(firstName,' ', lastName)", $q);
//		$query = $this->db->get('people');

	//	$meeting = $this->_currentMeeting();
	
//		$name = $this->input->post('name');

//		$this->db->select("id, CONCAT(firstName,' ', lastName) AS name, type",FALSE);
//		$this->db->from('people');
//		if($mode == 'signin')
//			$this->db->where("status !=", "enter");
//		else
//			$this->db->where("status", "enter");
//		$this->db->like("concat(firstName,' ', lastName)", $q);
//		$this->db->order_by('name');
//		$query = $this->db->get();
//		    if($query->num_rows > 0){
//			foreach ($query->result_array() as $row){
//			$row_set[] = htmlentities(stripslashes($row['name'])); //build an array
//			}
//		if($query->num_rows > 0){
//			foreach ($query->result_array() as $row){
//			$new_row['label']=htmlentities(stripslashes($row['name']));
//			$new_row['value']=htmlentities(stripslashes($row['id']));
//			$row_set[] = $new_row; //build an array
//			}
//		echo json_encode($row_set); //format the array into json data
//		}
//		$query = $this->db->get();
//		$people_list = array();
//		foreach($query->result() as $row) {
//			$id = $row->id;
//			$people_list['list'][$id]['name'] = $row->name;
//			$people_list['list'][$id]['type'] = $row->type;
//			$people_list['list'][$id]['id'] = $id;
//		}
//		if($query->num_rows() == 0)
//		{
//			return false;
//		}
//		echo json_encode($people_list);
//		$people_list = json_encode($people_list);
//		return $people_list;
		//	echo json_encode($data);


}