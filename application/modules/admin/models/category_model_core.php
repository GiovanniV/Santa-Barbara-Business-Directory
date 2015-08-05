<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory category_model_core model
 *
 * This class handles category_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	category_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */
class Category_model_core extends CI_Model 
{
	var $category,$menu;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->category = array();
	}

	function get_all_parent_categories_by_range()
	{
		$this->db->order_by('id', "asc");
		$this->db->where('parent',0); 
		$this->db->where('status',1); 
		$query = $this->db->get('categories');
		return $query;
	}


	function get_all_categories_by_range($start,$sort_by='')
	{
		$this->db->order_by($sort_by, "asc");
		$this->db->where('status',1); 
		$query = $this->db->get('categories');
		return $query;
	}

	function delete_category_by_id($id)
	{
		$data['status'] = 0;
		$this->db->update('categories',$data,array('id'=>$id));
	}

	function insert_category($data)
	{
		$this->db->insert('categories',$data);
		return $this->db->insert_id();
	}

	function update_category($data,$id)
	{
		$this->db->update('categories',$data,array('id'=>$id));
	}

	function get_category_by_id($id)
	{
		$query = $this->db->get_where('categories',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid category id';die;
		}
		else
		{
			return $query->row();
		}
	}

}

/* End of file category_model_core.php */
/* Location: ./system/application/models/category_model_core.php */