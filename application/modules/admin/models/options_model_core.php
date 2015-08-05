<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory options_model_core model
 *
 * This class handles options_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	options_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Options_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	# takes a key as parameter
	# key is the unique identification string for a option
	# values are first retrived using this key and returned as array
	function getvalues($key)
	{
		$query = $this->db->get_where('options',array('key'=>$key));
		if($query->num_rows()>0)
		{
			$row = $query->row();
			return json_decode($row->values);
		}
		else
			return '';	
	}

	# takes a key as parameter
	# key is the unique identification string for a option
	# values are first retrived using this key and returned as array
	
	function getvalues_array($key)
	{
		$query = $this->db->get_where('options',array('key'=>$key));
		if($query->num_rows()>0)
		{
			$row = $query->row_array();
			return json_decode($row->values);
		}
		else
			return '';	
	}
	
	function addvalues($data)
	{
		$this->db->insert('options',$data);
	}
	
	function updatevalues($key,$data)
	{
		$this->db->update('options',$data,array('key'=>$key));
	}
}

/* End of file options_model_core.php */
/* Location: ./system/application/controllers/options_model_core.php */