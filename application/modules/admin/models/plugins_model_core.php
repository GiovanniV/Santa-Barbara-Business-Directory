<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory plugins_model_core model
 *
 * This class handles plugins_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	plugins_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Plugins_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_all_plugins_by_range($start,$limit='',$sort_by='')
	{
		if($start=='all')
		$query = $this->db->get('plugins');
		else
		$query = $this->db->get('plugins',$limit,$start);
		return $query;
	}
	
	function enable_plugin($id)
	{
		$data['status'] = 1;
		$this->db->update('plugins',$data,array('id'=>$id));
	}
	
	function disable_plugin($id)
	{
		$data['status'] = 0;
		$this->db->update('plugins',$data,array('id'=>$id));
	}
}

/* End of file plugins_model_core.php */
/* Location: ./system/application/models/plugins_model_core.php */