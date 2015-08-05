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



class Slider_model_core extends CI_Model 

{

	var $pages,$menu;



	function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->pages = array();

	}



	function get_all_posts_by_range($start,$limit='',$sort_by='')

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status !=',0); 

		if($start=='all')

		$query = $this->db->get('slider');

		else

		$query = $this->db->get('slider',$limit,$start);

		return $query;

	}

	

	function count_all_posts()

	{

		$this->db->where('status',1); 

		$query = $this->db->get('slider');

		return $query->num_rows();

	}

	

	function delete_post_by_id($id)

	{

		$data['status'] = 0;

		$this->db->update('slider',$data,array('id'=>$id));

	}



	function insert_post($data)

	{

		$this->db->insert('slider',$data);

		return $this->db->insert_id();

	}



	function update_post($data,$id)

	{

		$this->db->update('slider',$data,array('id'=>$id));

	}



	function get_post_by_id($id)

	{

		$query = $this->db->get_where('slider',array('id'=>$id));

		if($query->num_rows()<=0)

		{
			$res = new stdClass();
			return $res;

		}

		else

		{

			return $query->row();

		}

	}

}



/* End of file page_model_core.php */

/* Location: ./system/application/models/page_model_core.php */