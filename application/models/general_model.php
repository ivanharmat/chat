<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_model extends CI_Model 
{
	public function load_common_data()
	{
		$common = array();
		if($this->session->userdata('client_logged_in') === TRUE)
		{
			$user = $this->get_user_info_id($this->session->userdata('client_id'));
			$common['user']['name'] = $user['name'];
		}
		return $common;
	}

	public function get_user_info_id($id)
	{
		return $this->db->get_where('users', array('id' => $id))->row_array();
	}


}