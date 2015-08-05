<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory distance_info_model_core model
 *
 * This class handles distance_info_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	distance_info_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Distance_info_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function get_all_distance_info_by_range($start,$limit='',$sort_by='')
	{
		
	}

	function get_all_distance_info()
	{
		$this->db->where('status','1');
		$this->db->where('key','distance_field');
		$query = $this->db->get('options');
		return $query;
	}
	
	function get_distance_info_by_alias($alias)
	{
		$query 	= $this->db->get_where('distance_info',array('alias'=>$alias));
		$row 	= $query->row();
		return $row;
	}

	function set_distance_info_status($alias,$status)
	{
		$data['status'] = $status;
		$this->db->update('distance_info',$data,array('alias'=>$alias));
	}

	function create_distance_info($data)
	{
		$data['alias'] = $this->get_alias($data['name']);
		$this->db->insert('distance_info',$data);
	}

	function get_alias($name)
	{
		$name = underscore($name);
		$query = $this->db->get_where('distance_info',array('alias'=>$name));
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

	#bulk update the distance_info table
	function bulk_update_distance_info($data,$ids) {
		
		if(!isset($ids) || !isset($data))
			return;

		$this->db->where_in('id',$ids);
		$this->db->update('options',$data);
	}

	#update a single record in distance_info table by id
	function update_distance_info($data,$id) {
		
		if(!isset($id) || !isset($data))
			return;
		
		$this->db->where('id',$id);
		$this->db->update('options',$data);
	}

	#insert distance_info information into the database
	function insert_distance_field($data) {

		$this->db->insert('options',$data);
		return $this->db->insert_id();
	}

	#get a single distance_info by id
	function get_distance_info_by_id($id)
	{
		$query = $this->db->get_where('options',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			return 'error';
		}
		else
		{
			return $query->row();
		}
	}

	function remove_non_existing_distance_fields($distances) {

		if(!empty($distances)) foreach ($distances as $key => $distance) {
			$info = json_decode($distance);
			$dis_info = $this->get_distance_info_by_id($info->{'id'});
			if($dis_info->status!='1')
				unset($distances[$key]);
		}
		return $distances;
	}
	
	function get_distance_info_of_a_post ($post_id) {

		$query = $this->db->get_where('post_meta',array('status'=>'1', 'post_id'=>$post_id, 'key'=>'distance_info'));
		
		if($query->num_rows()==1) $distances = json_decode($query->row()->value);
		else $distances = array();
		
		$distances = $this->remove_non_existing_distance_fields($distances);

		$ids_present = array();
		if(!empty($distances)) foreach ($distances as $key => $distance) {
			$info = json_decode($distance);
			$ids_present[] = $info->{'id'};
		}

		#get the remaining distance fields that are not set for the property
		$this->db->where('key','distance_field');
		$this->db->where('status','1');
		if(!empty($ids_present))
			$this->db->where_not_in('id', $ids_present);
		$query_id_not_present = $this->db->get('options');

		foreach ($query_id_not_present->result() as $row) {
			$id_not_present = array();
			$id_not_present['id'] = $row->id;
			$info = json_decode($row->values);
			$id_not_present['title'] = $info->{'title'};
			$id_not_present['icon'] = $info->{'icon'};
			$id_not_present['value'] = '';
			$id_not_present['units'] = '';
			$distances[] = json_encode($id_not_present);
		}
		
		// echo "<pre>";
		// foreach ($distances as $key => $distance) {
		// 	$info = json_decode($distance);
		// 	//$ids_present[] = $info->{'id'};
		// 	echo "id:".$info->{'id'}." title:".$info->{'title'}.' value:'.$info->{'value'}.' units:'.$info->{'units'}."<br />";
		// }

		// die;
		return $distances;
	}

	function get_existing_distance_info_of_a_post($post_id) {
        $query = $this->db->get_where('post_meta',array('status'=>'1', 'post_id'=>$post_id, 'key'=>'distance_info'));

        if($query->num_rows()==1) $distances = json_decode($query->row()->value);
		else $distances = array();
		$distances = $this->remove_non_existing_distance_fields($distances);
		return $distances;
    }
}

/* End of file distance_info_model_core.php */
/* Location: ./system/application/models/distance_info_model_core.php */