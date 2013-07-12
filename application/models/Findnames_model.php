<?php
class Findnames_model extends CI_Model{

    function __construct()
    {
        parent::__construct();
    }
	public function matchednames() {
		$mode = $this->uri->segment(3);
	    $meeting = $this->_currentMeeting();
            $name = trim($_POST['name']);
	    $this->db->select("id, concat(firstName,' ', lastName) as name, type");
	    $this->db->from('people');
	    if($mode == 'signin')
			$this->db->where("status !=", "enter");
	    else
			$this->db->where("status", "enter");
	    $this->db->like("concat(firstName,' ', lastName)", $name);
	    $this->db->order_by('name');
	    $query = $this->db->get();
	    
	    $data = array();
	    
	    foreach($query->result() as $row) {
	        $id = $row->id;
	        $data['list'][$id]['name'] = $row->name;
	        $data['list'][$id]['type'] = $row->type;
	        $data['list'][$id]['id'] = $id;
	    }
		echo json_encode($data);

	}
}
