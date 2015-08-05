<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory admin_model_core model
 *
 * This class handles admin_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	admin_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Admin_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get_user_profile($user_name)
	{
		$query = $this->db->get_where('users',array('user_name'=>$user_name));
		return $query->row();
	}

	function get_user_profile_by_id($user_id)
	{
		$query = $this->db->get_where('users',array('id'=>$user_id));
		return $query->row();
	}
	
	function update_profile($data,$id)
	{
		$this->db->update('users',$data,array('id'=>$id));
		if($id==$this->session->userdata('user_id'))
		$this->session->set_userdata('user_name',$data['user_name']);
	}
}

/* End of file admin_model_core.php */
/* Location: ./system/application/models/admin_model_core.php */