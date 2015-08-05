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
class Business_model_core extends CI_Model
{
	var $category,$menu;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->category = array();
	}

	function check_post_permission($id)
	{
		$post = $this->get_estate_by_id($id);
		if(is_admin()==FALSE && $post->created_by!=$this->session->userdata('user_id'))
		{
			return FALSE;
		}
		else
			return TRUE;
	}

	function get_post_by_id($id)
	{
		$query = $this->db->get_where('posts',array('id'=>$id,'status !='=>0));
		if($query->num_rows()>0)
		{
			return $query->row();
		}
		else
		{
			die('Post not found');
		}
	}

	function delete_review_by_id($id='')
	{
		$this->db->delete('review',array('id'=>$id));
	}

	function delete_post_by_id($id='')
	{
		$data['status'] = 0;
		$this->db->update('posts',$data,array('id'=>$id));
	}

	function update_post_by_id($data,$id)
	{
		$this->db->update('posts',$data,array('id'=>$id));
	}	

	function update_post_meta($data,$id,$key)
	{
		$this->db->update('post_meta',$data,array('post_id'=>$id,'key'=>$key));
	}

	function insert_post_meta($data)
	{
		$this->db->insert('post_meta',$data);
	}

	function get_all_post_based_on_user_type($start,$limit,$order_by='id',$order_type='asc')
	{
		if(!is_admin())
			$this->db->where('created_by',$this->session->userdata('user_id'));

		$this->db->order_by('id', "desc");
		$this->db->where('status !=',0);
		if($start=='all')
		{
			$query = $this->db->get('posts');
			return $query;			
		}
		elseif ($start=='total') 
		{
			$query = $this->db->get('posts');
			return $query->num_rows();			
		}
		else
		{
			$query = $this->db->get('posts',$limit,$start);
			return $query;			
		}	
	}


	#**************** location functions start ******************#
	function get_location_id_by_name($name,$type,$parent)
	{
		$query = $this->db->get_where('locations',array('status'=>1,'name'=>$name,'type'=>$type,'parent'=>$parent));
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
			$data['parent']	= $parent;
			$this->db->insert('locations',$data);
			return $this->db->insert_id();
		}
	}

	function get_locations_json($term='',$type,$parent)
	{
		$this->db->like('name',$term);
		$query = $this->db->get_where('locations',array('status'=>1,'type'=>$type,'parent'=>$parent));
		$data = array();
		foreach ($query->result() as $row) {
			$val = array();
			$val['id'] = $row->id;
			$val['label'] = $row->name;
			$val['value'] = trim($row->name);
			array_push($data,$val);
		}
		return $data;
	}

	function get_all_locations_json($term='')
	{
		$this->db->like('name',$term);
		$query = $this->db->get_where('locations',array('status'=>1));
		$data = array();
		foreach ($query->result() as $row) {
			$val = array();
			$val['id'] = $row->id;
			$val['label'] = $row->name;
			$val['value'] = trim($row->name);
			array_push($data,$val);
		}
		return $data;
	}

	function get_all_locations_by_parent($parent='')
	{
		$this->db->order_by('name','asc');
		$query = $this->db->get_where('locations',array('parent'=>$parent,'status'=>1));		
		return $query;
	}

	function get_all_locations($start,$limit)
	{
		$this->db->order_by('parent','asc');
		if($this->input->post('key')!='')
		{
			$this->db->like('name',$this->input->post('key'));
		}

		if($start=='all')
		{
			$query = $this->db->get_where('locations',array('status'=>1));
			return $query;			
		}
		elseif($start=='total')
		{
			$query = $this->db->get_where('locations',array('status'=>1));
			return $query->num_rows();						
		}
		else
		{
			$query = $this->db->get_where('locations',array('status'=>1),$limit,$start);
			return $query;						
		}
	}

	function get_all_locations_by_range($start,$sort_by='id')
	{
		$data = array();
		$this->db->order_by($sort_by, "asc");

		$state_active = get_settings('business_settings', 'show_state_province', 'yes');


		$this->db->where('status',1);
		$this->db->where('parent',0);
		$query = $this->db->get('locations');
		if($state_active == 'yes'){
			foreach ($query->result() as $country) {
				array_push($data,$country);
				$state_query = $this->db->get_where('locations',array('status'=>1,'parent'=>$country->id));
				foreach ($state_query->result() as $state) {
					array_push($data,$state);
					$city_query = $this->db->get_where('locations',array('status'=>1,'parent'=>$state->id));
					foreach ($city_query->result() as $city) {
						array_push($data,$city);
					}
				}
			}
		}
		else
		{
			foreach ($query->result() as $country) {
				array_push($data,$country);
				$city_query = $this->db->get_where('locations',array('status'=>1,'parent_country'=>$country->id, 'type'=> 'city'));
				foreach ($city_query->result() as $city) {
					array_push($data,$city);
				}
			}
		}


			return array_slice($data,$start);
	}
	
	
	function insert_location($data)
	{
		$this->db->insert('locations',$data);
		return $this->db->insert_id();
	}

	function get_locations_by_type($type)
	{
		$query = $this->db->get_where('locations',array('type'=>$type,'status'=>1));
		return $query;
	}

	function get_location_by_id($id)
	{
		$query = $this->db->get_where('locations',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			echo 'Invalid page id';die;
		}
		else
		{
			return $query->row();
		}
	}

	function delete_location_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->or_where('parent', $id);
		$this->db->or_where('parent_country', $id);
		$this->db->delete('locations'); 
	}


	function update_location($data,$id)
	{
		$this->db->update('locations',$data,array('id'=>$id));
	}

	#************* location function end ******************#


	function get_feature_payment_data_by_unique_id($unique_id)
	{
		$this->db->where('key','featurepayment_'.$unique_id);
		$query = $this->db->get_where('post_meta',array('status'=>1));
		return $query;
	}

	#************ email function start *****************#
	function get_all_emails_admin($start,$limit='')
	{
		if(!is_admin())
			$this->db->where('user_id',$this->session->userdata('user_id'));

		if($start=='all')
		{
			$this->db->like('key','query_email');
			$query = $this->db->get_where('user_meta',array('status'=>1));
			return $query;	
		}
		elseif($start=='total')
		{
			$this->db->like('key','query_email');
			$query = $this->db->get_where('user_meta',array('status'=>1));
			return $query->num_rows();				
		}
		else
		{
			$this->db->like('key','query_email');
			$query = $this->db->get_where('user_meta',array('status'=>1),$limit,$start);
			return $query;			
		}
	}

	function get_all_emails()
	{
		if(!is_admin())
			$this->db->where('user_id',$this->session->userdata('user_id'));

		$this->db->like('key','query_email');
		$query = $this->db->get_where('user_meta',array('status'=>1));
		return $query;
	}
	#************ email function start *****************#



    /*start get all property for site map*/
    function get_all_estates_admin($start,$limit,$order_by='id',$order_type='asc')
    {

        if($this->session->userdata('filter_purpose')!='')
        {
            $this->db->where('purpose',$this->session->userdata('filter_purpose'));
        }

        if($this->session->userdata('filter_type')!='')
        {
            $this->db->where('type',$this->session->userdata('filter_type'));
        }

        if($this->session->userdata('filter_condition')!='')
        {
            $this->db->where('estate_condition',$this->session->userdata('filter_condition'));
        }

        if($this->session->userdata('filter_status')!='')
        {
            $this->db->where('status',$this->session->userdata('filter_status'));
        }
        else
        {
            $where = "(status=1 or status=2)";
            $this->db->where($where);
        }

        if($this->session->userdata('filter_orderby')!='')
        {
            $order_by 	= ($this->session->userdata('filter_orderby')!='')?$this->session->userdata('filter_orderby'):'id';
            $order_type = ($this->session->userdata('filter_ordertype')!='')?$this->session->userdata('filter_ordertype'):'DESC';
            $this->db->order_by($order_by,$order_type);
        }
        else
        {
            $this->db->order_by('id','desc');
        }

        if($this->input->post('id_search')!='')
            $this->db->where('id',$this->input->post('id_search'));


        $query = $this->db->get('posts',$limit,$start);
        /*echo $this->db->last_query();
        die;*/
        return $query;
    }
    /*end get all property for site map */

    function get_all_transaction() {
    	$this->db->where('status',1);
    	//$this->db->where('is_active',2);
    	$this->db->where('amount >',0);
    	return $this->db->get('post_package');	
    }

    function delete_transaction($unique_id) {
    	$this->db->where('unique_id',$unique_id);
    	$this->db->set('status',0);
    	$this->db->update('post_package');
    }

	function get_all_reviews_based_on_post($post_id = 0)
	{
		$this->db->where('status',1);
		$this->db->where('post_id',$post_id);
		$query = $this->db->get('review');
		return $query;
	}

	function get_review_by_id($id)
	{
		$query = $this->db->get_where('review',array('id'=>$id));
		return $query;
	}
}

/* End of file category_model_core.php */
/* Location: ./system/application/models/category_model_core.php */