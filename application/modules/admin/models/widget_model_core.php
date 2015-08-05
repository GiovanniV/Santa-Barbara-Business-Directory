<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory widget_model_core model
 *
 * This class handles widget_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	widget_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Widget_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_all_widgets_by_range($start,$limit='',$sort_by='')
	{
		$this->db->where('status !=','2');
		if($start=='all')
		$query = $this->db->get('widgets');
		else
		$query = $this->db->get('widgets',$limit,$start);
		return $query;
	}
	
	function get_widget_by_alias($alias)
	{
		$query 	= $this->db->get_where('widgets',array('alias'=>$alias));
		$row 	= $query->row();
		return $row;
	}

	function set_widget_status($alias,$status)
	{
		$data['status'] = $status;
		$this->db->update('widgets',$data,array('alias'=>$alias));
	}

	function create_widget($data)
	{
		$data['alias'] = $this->get_alias($data['name']);
		$this->db->insert('widgets',$data);
	}

	function get_alias($name)
	{
		$name = underscore($name);
		$query = $this->db->get_where('widgets',array('alias'=>$name));
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
	
}

/* End of file widget_model_core.php */
/* Location: ./system/application/models/widget_model_core.php */