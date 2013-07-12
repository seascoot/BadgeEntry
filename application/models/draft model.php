<?php
class peopleTypeahead_model extends CI_Model{
  function get_people($q){
    $this->db->select("id, concat(firstName,' ', lastName) as name, type");
    $this->db->from('people');
	if($mode == 'signin')
		$this->db->where("status !=", "enter");
	else
		$this->db->where("status", "enter");
		$this->db->like('bird', $q);
	$this->db->like("concat(firstName,' ', lastName)", $q);
	$this->db->order_by('name');
    $query = $this->db->get('name');
    if($query->num_rows > 0){
      foreach ($query->result_array() as $row){
        $row_set[] = htmlentities(stripslashes($row['bird'])); //build an array
      }
      echo json_encode($row_set); //format the array into json data
    }
  }
}