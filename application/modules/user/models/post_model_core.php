<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		User
 * @subpackage	UserModelCore
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Post_model_core extends CI_Model 

{

	function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

	function get_all_categories()
	{
		$this->db->order_by('title','asc');
		$query = $this->db->get_where('categories',array('status'=>1));
		$categories = array();
		foreach ($query->result() as $row) {
			array_push($categories,$row);
		}
		return $categories;
	}

	function get_all_parent_categories()
	{
		$this->db->order_by('title','asc');
		$this->db->where('status',1);
		$query = $this->db->get('categories');
		return $query;
	}

	function get_all_child_categories($id, $limit = 'all')
	{
		$this->db->order_by('title','asc');
		$this->db->where('status',1);
		if($limit!= 'all')
			$this->db->limit($limit);
		$query = $this->db->get('categories');
		return $query;
	}

	function count_post_by_category_id($cat_id)
	{
		$this->db->where('category',$cat_id);
		$this->db->where('status',1);
		$query = $this->db->get('posts');
		return $query->num_rows();
	}

	function get_category_icon($cat_id)
	{
		$this->db->where('id',$cat_id);
		$query = $this->db->get('categories');
		if($query->num_rows()>0){
			$cat = $query->row();
			if($cat->fa_icon!='')
				return $cat->fa_icon;
			else
				return 'fa-picture-o';
		}
		return 'fa-picture-o';
	}

	function insert_post($data)
	{
		$this->db->insert('posts',$data);
		return $this->db->insert_id();
	}

	function update_post($data,$id)
	{
		$this->db->update('posts',$data,array('id'=>$id));
	}

	function get_post_by_id($id)
	{
		$query = $this->db->get_where('posts',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid post id';
			die;
		}
		else
		{
			return $query;
		}
	}

	function get_post_by_unique_id($unique_id)
	{
		$query = $this->db->get_where('posts',array('unique_id'=>$unique_id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid post id';
			die;
		}
		else
		{
			return $query;
		}
	}

	function get_recent_posts($limit=6) {
		$this->db->where('status',1);
		$this->db->limit($limit);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('posts');
		return $query;
	}

	function get_featured_posts($limit=6) {
		$this->db->where('status',1);
		$this->db->where('featured',1);
		$this->db->limit($limit);
		$this->db->order_by('id', 'desc');
		$query = $this->db->get('posts');
		return $query;
	}

	function get_category_posts($limit=6,$category_id='') {
		$this->db->where('status',1);
		$this->db->where('category',$category_id);
		$this->db->limit($limit);
		$this->db->order_by('id');
		$query = $this->db->get('posts');
		return $query;
	}

	function get_member_posts($limit=6,$user_id='') {
		$this->db->where('status',1);
		$this->db->where('created_by',$user_id);
		$this->db->limit($limit);
		$this->db->order_by('id');
		$query = $this->db->get('posts');
		return $query;
	}

	function get_location_posts($limit=6,$location_id='', $location_type='country') {
		$this->db->where('status',1);
		$this->db->where($location_type,$location_id);
		$this->db->limit($limit);
		$this->db->order_by('id');
		$query = $this->db->get('posts');
		return $query;
	}

	function inc_view_count_by_unique_id($unique_id) {
		$this->db->where('status',1);
		$this->db->where('unique_id',$unique_id);
		$this->db->set('total_view', 'total_view+1', FALSE);
		$this->db->update('posts');
	}

	function increment_featured_date($increment_day_count,$post_id) {


		$query = $this->db->get_where('posts', array('id' => $post_id));
		if($query->num_rows()>0)
			$row = $query->row();
		else
			return FALSE;

		$date = $row->featured_expiration_date;
		$date = new DateTime($date);
		$date->add(new DateInterval('P'.$increment_day_count.'D'));
		
		//die($date->format("Y-m-d H:i:s"));

		$this->db->where('id',$post_id);
		$this->db->set('featured_expiration_date', $date->format("Y-m-d H:i:s"));
		$this->db->set('featured',1);
		$this->db->update('posts');

		return TRUE;
	}



	function get_location_id_by_name($name,$type,$parent, $country)
	{
		if($parent ==0)
			$query = $this->db->get_where('locations',array('status'=>1,'name'=>$name,'type'=>$type, 'parent_country'=>$country));
		else
			$query = $this->db->get_where('locations',array('status'=>1,'name'=>$name,'type'=>$type,'parent'=>$parent, 'parent_country'=>$country));

		if($query->num_rows()>0)
		{
			$row = $query->row();
			return $row->id;
		}
		else
		{
			$data = array();
			$data['type'] 	= $type;
			$data['name'] 	= $name;
			$data['parent']	= $parent == 0 ? $country : $parent;
			$data['parent_country']= $country;
			$this->db->insert('locations',$data);
			return $this->db->insert_id();
		}
	}

}



/* End of file install.php */
/* Location: ./application/modules/user/models/user_model_core.php */