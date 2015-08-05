<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Show
 * @subpackage	ShowModelCore
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Show_model_core extends CI_Model 

{



	function __construct()

	{

		parent::__construct();

		$this->load->database();

	}



    function get_all_active_blog_posts_by_range($start,$limit='',$sort_by='',$sort='desc',$type="all")

    {

        if($type!='all')
            $this->db->where('type',$type);

        $this->db->order_by($sort_by, $sort);

        $this->db->where('status',1); 

        if($start==='all')

        {

            $query = $this->db->get('blog');

        }

        else

        {

            $query = $this->db->get('blog',$limit,$start);

        }

        return $query;

    }

    

    function count_all_active_blog_posts($type="all")

    {

        if($type!='all')
            $this->db->where('type',$type);

        $this->db->where('status',1);

        $query = $this->db->get('blog');

        return $query->num_rows();

    }


	function get_all_active_posts_by_range($start,$limit='',$sort_by='',$sort='desc')

	{

		$this->db->order_by($sort_by, $sort);

		$this->db->where('status',1); 

		if($start==='all')

		{

			$query = $this->db->get('posts');

		}

		else

		{

			$query = $this->db->get('posts',$limit,$start);

		}

		return $query;

	}

	

	function count_all_active_posts()

	{

		$this->db->where('status',1);

		$query = $this->db->get('posts');

		return $query->num_rows();

	}



	#get all recent estates information

	#set a big number as the limit value to get all the records from start to the end

    function get_recent_estates($start,$limit='10',$order_by='id',$order_type='desc') {

    	

    	$this->db->order_by($order_by,$order_type);

		if($this->session->userdata('view_orderby')!='')

		{

			$order_by 	= ($this->session->userdata('view_orderby')!='')?$this->session->userdata('view_orderby'):'title';

			$order_type = ($this->session->userdata('view_ordertype')!='')?$this->session->userdata('view_ordertype'):'ASC';

			$this->db->order_by($order_by,$order_type);

		}
		else
			$this->db->order_by($order_by,$order_type);



    	if($start==='all')

		{

			$query = $this->db->get_where('posts',array('status'=>1));

		}

		else

		{

			$query = $this->db->get_where('posts',array('status'=>1),$limit,$start);

		}

		

		return $query;

    }





    #get all featured estates information

	#set a big number as the limit value to get all the records from start to the end

    function get_featured_estates($start,$limit='10',$order_by='id',$order_type='desc') {

    	


		if($this->session->userdata('view_orderby')!='')

		{

			$order_by 	= ($this->session->userdata('view_orderby')!='')?$this->session->userdata('view_orderby'):'title';

			$order_type = ($this->session->userdata('view_ordertype')!='')?$this->session->userdata('view_ordertype'):'ASC';

			$this->db->order_by($order_by,$order_type);

		}
		else
			$this->db->order_by($order_by,$order_type);

    	$this->db->where('featured',1);



    	if($start==='all')

		{

			$query = $this->db->get_where('posts');

		}

		else

		{

			$query = $this->db->get_where('posts',array('status'=>1),$limit,$start);

		}



		return $query;

    }



    function count_all_featured_estates() {

    	$this->db->where('featured',1);

    	$query = $this->db->get_where('posts',array('status'=>1));

    	return $query->num_rows();

    }



    function count_all_estates_by_agent($agent_id){

    	$this->db->where('created_by',$agent_id);

    	$query = $this->db->get_where('posts',array('status'=>1));

    	return $query->num_rows();	

    }



    function get_estates_by_agent($agent_id, $start='all', $limit='10') {

    	

    	$this->db->order_by('id','desc');

    	$this->db->where('created_by',$agent_id);



    	if($start==='all')

		{

			$query = $this->db->get_where('posts',array('status'=>1));

		}

		else

		{

			$query = $this->db->get_where('posts',array('status'=>1),$limit,$start);

		}

		return $query;

    }



    function get_latitude_longitude($address) {
	

		$address = trim($address);
		$address = str_replace(" ", "+", $address);

    	$details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&sensor=false";
 
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $details_url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = json_decode(curl_exec($ch), true);

		curl_close($ch);

		// If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST

		if ($response['status'] != 'OK') {

			return null;

		}



		//print_r($response);

		//print_r($response['results'][0]['geometry']['location']);



		$latLng = $response['results'][0]['geometry']['location'];


		return $latLng;

    }



    function get_advanced_search_result($data,$start = '0',$limit = '10') {

		$distance_unit = get_settings('business_settings', 'show_distance_in', 'miles');

		if(isset($data['sort_by']) && trim($data['sort_by'])!='') {
			$info = explode('_',$data['sort_by']);
			$this->db->order_by($info[0],$info[1]);
		}
		else
		{
			$this->db->order_by('featured', 'desc');
			$this->db->order_by('id', "desc");
		}


        if(isset($data['city']) && $data['city']!='any')
        {
            $this->db->where('city',$data['city']);
        }

        if(isset($data['category']) && $data['category']!='any')
        {
            $this->db->where('category',$data['category']);

        }

        if(isset($data['plainkey']) && trim($data['plainkey'])!='') {

    		$search_string = rawurldecode($data['plainkey']);
    		$search_string = trim($search_string);
			$search_string = explode(" ", $search_string);

    		$sql = "";
    		$flag = 0;

    		foreach ($search_string as $key) {
				if($flag==0) {
					$flag = 1;
				}
				else {
					$sql .= "AND ";
				}
				$sql .= "search_meta LIKE '%".$key."%' ";
			}
			$this->db->where($sql);
    	}

        if(isset($data['distance']) && $data['distance'] !=''
			&& isset($data['geo_lat']) && $data['geo_lat']!=''
			&& isset($data['geo_lng']) && $data['geo_lng'] !='')
        {

			$radius = (int)$data['distance'];
			$latitude = floatval($data['geo_lat']);
			$longitude = floatval($data['geo_lng']);



			$radius_in_kms = $distance_unit == 'miles' ? $radius * 1.60934 : $radius;

			$radius_condition = "(6371.0 * 2 * ASIN(SQRT(POWER(SIN((".$latitude." - latitude) * PI() / 180 / 2), 2) + COS(".$latitude." * PI() / 180)
                                    * COS(latitude * PI() / 180) * POWER(SIN((".$longitude." - longitude) * PI() / 180 / 2), 2))) <= ".$radius_in_kms.")";

			$this->db->where($radius_condition);
		}

		$this->db->where('status',1);

		


        if($start==='all')
            $query = $this->db->get('posts');
        elseif($start==='total')
        {
            $query = $this->db->get('posts');
            return $query->num_rows();
        }
        else
    	   $query = $this->db->get('posts',$limit,$start);

//         echo $this->db->last_query();
//         die;
	    return $query;

    }


	function get_post_by_unique_id($unique_id)

	{

		$query = $this->db->get_where('posts',array('unique_id'=>$unique_id));

		return $query;

	}



	function get_page_by_alias($alias)

    {

    	$query = $this->db->get_where('pages',array('alias'=>$alias));

    	return $query;

    }



    function get_alias_by_url($url)

    {

    	$query = $this->db->get_where('pages',array('content_from'=>'Url','url'=>$url));

    	if($query->num_rows()>0)

    	{

    		$row = $query->row();

    		return $row->alias;

    	}

    	else

    		return '';

    }



    function get_page_by_url($url)

    {

    	$query = $this->db->get_where('pages',array('url'=>$url));

    	return $query;

    }



    function get_user_by_userid($user_id)

    {

    	$query = $this->db->get_where('users',array('id'=>$user_id));

    	return $query;

    }


    function get_user_row_by_userid($user_id)

    {

    	$query = $this->db->get_where('users',array('id'=>$user_id));

    	return $query->row();

    }



    function get_users_by_range($start,$limit='',$sort_by='id',$sort='desc')

    {
        if($this->input->post('agent_key')!='')
        {
            $key = $this->input->post('agent_key');
            $this->db->like('first_name',$key);
            $this->db->or_like('last_name',$key);
            $this->db->or_like('user_email',$key);
        }

        $this->db->order_by($sort_by, $sort);

        $this->db->where('status',1);

        if($start==='all')

        {

            $query = $this->db->get('users');

        }
        elseif($start==='total')

        {

            $query = $this->db->get('users');
            return $query->num_rows();
        }
        else

        {

            $query = $this->db->get('users',$limit,$start);

        }

        return $query;

    }



    function get_all_estates_agent($user_id,$start,$limit,$order_by='id',$order_type='asc')

	{

		if($this->session->userdata('view_orderby')!='')

		{

			$order_by 	= ($this->session->userdata('view_orderby')!='')?$this->session->userdata('view_orderby'):'title';

			$order_type = ($this->session->userdata('view_ordertype')!='')?$this->session->userdata('view_ordertype'):'ASC';

			$this->db->order_by($order_by,$order_type);

		}
		else
			$this->db->order_by($order_by,$order_type);


		$this->db->where('created_by',$user_id);

		$query = $this->db->get_where('posts',array('status'=>1),$limit,$start);

		return $query;

	}



	function count_all_estates_agent($user_id)

	{

		$this->db->where('created_by',$user_id);

		$query = $this->db->get_where('posts',array('status'=>1));

		return $query->num_rows();

	}

	function get_location_id_by_name($name,$type)
	{
		$this->db->where(array('status'=>1,'type'=>$type));
		$this->db->like('name', $name); 
		$query = $this->db->get('locations');
        $ids = array();
		if($query->num_rows()>0)
		{
			// $row = $query->row();
			// return $row->id;
            foreach ($query->result() as $row) {
                $ids[] = $row->id;
            }
            return $ids;
		}
		else
		{
			return '';
		}
	}

	function get_country_name_by_id($id)
	{
		$query = $this->db->get_where('locations',array('id'=>$id));
		if($query->num_rows()<=0)
		{
			return '';
		}
		else
		{
			return $query->row()->name;
		}
	}

	function get_locations_json($term='',$type,$parent)
	{

		$state_active = get_settings('business_settings', 'show_state_province', 'yes');
		$this->db->like('name',$term);
		if($state_active == 'yes')
		{
			$query = $this->db->get_where('locations',array('status'=>1,'type'=>$type,'parent'=>$parent));
		}
		else
		{
			$query = $this->db->get_where('locations',array('status'=>1,'type'=>$type,'parent_country'=>$parent));
		}

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

}



/* End of file install.php */

/* Location: ./application/modules/show/models/show_model_core.php */