<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory package_model_core model
 *
 * This class handles package_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	package_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Package_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	function get_all_packages_by_type($type='post_package')
	{
		$types = array();
		$types[] = $type;
		$types[] = 'both_package';
		$this->db->where_in('type',$types);
		$this->db->where('status','1');
		$query = $this->db->get('packages');
		return $query;
	}

	function get_all_packages_by_range($start,$limit='',$sort_by='')
	{
		$this->db->where('status','1');
		if($start=='all')
		$query = $this->db->get('packages');
		else
		$query = $this->db->get('packages',$limit,$start);
		return $query;
	}
	
	function get_package_by_alias($alias)
	{
		$query 	= $this->db->get_where('packages',array('alias'=>$alias));
		$row 	= $query->row();
		return $row;
	}

	function set_package_status($alias,$status)
	{
		$data['status'] = $status;
		$this->db->update('packages',$data,array('alias'=>$alias));
	}

	function create_package($data)
	{
		$data['alias'] = $this->get_alias($data['name']);
		$this->db->insert('packages',$data);
	}

	function get_alias($name)
	{
		$name = underscore($name);
		$query = $this->db->get_where('packages',array('alias'=>$name));
		if($query->num_rows()>0)
		{
			$count = $query->num_rows();
			$count++;
			$name = $name.'_'.$count;
			return $name;
		}
		else
			return $name;
	}

	#bulk update the packages table
	function bulk_update_packages($data,$ids) {
		
		if(!isset($ids) || !isset($data))
			return;

		$this->db->where_in('id',$ids);
		$this->db->update('packages',$data);
	}

	#update a single record in packages table by id
	function update_package($data,$id) {
		
		if(!isset($id) || !isset($data))
			return;
		
		$this->db->where('id',$id);
		$this->db->update('packages',$data);
	}

	#insert package information into the database
	function insert_package($data) {

		$this->db->insert('packages',$data);
		return $this->db->insert_id();
	}

	#get a particular package by id
	function get_package_by_id($id)
	{
		$query = $this->db->get_where('packages',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid package id';die;
		}
		else
		{
			return $query->row();
		}
	}
	
}

/* End of file package_model_core.php */
/* Location: ./system/application/models/package_model_core.php */