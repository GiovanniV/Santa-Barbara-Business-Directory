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



class User_model_core extends CI_Model 

{

	function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

	function insert_user_data($data)
	{
		$this->db->insert('users',$data);
		return $this->db->insert_id();
	}

	
	function get_user_data_array_by_id($id)
	{

		$query = $this->db->get_where('users',array('id'=>$id));

		return $query->row_array();

	}

	function get_user_profile($user_email)

	{

		$query = $this->db->get_where('users',array('user_email'=>$user_email));

		return $query->row();

	}



	function get_user_profile_by_id($id)

	{

		$query = $this->db->get_where('users',array('id'=>$id));

		return $query->row();

	}

	

	function get_user_profile_by_user_name($user_name)

	{

		$query = $this->db->get_where('users',array('user_name'=>$user_name));

		if($query->num_rows()>0)

			return $query->row();

		else

			show_error('User name not valid' , 500 );

	}



	function delete_user_by_id($id)

	{

		$this->db->where('id', $id);
		$this->db->delete('users');
		$this->db->where('user_id',$id);
		$this->db->delete('user_meta');
		$this->db->update('posts',array('status'=>0),array('created_by'=>$id));

	}





	function confirm_user_by_id($id)

	{
		$this->load->helper('date');
		$datestring = "%Y-%m-%d %h:%i:00";
		$time = time();
		$data = array();
		$data['confirmed'] = 1;
		$data['confirmed_date'] = mdate($datestring, $time);
		$data['confirmation_key'] = '';
		$this->db->update('users',$data,array('id'=>$id));
	}


	function update_user_by_id($data,$id)

	{

		$this->db->update('users',$data,array('id'=>$id));

	}


	function update_profile($data,$id)

	{

		$this->db->update('users',$data,array('id'=>$id));

		$this->session->set_userdata('user_email',$data['user_email']);

	}



	/*

	function update_profile_by_username($data,$user_name)

	{

		$this->db->update('users',$data,array('user_name'=>$user_name));

		$this->session->set_userdata('user_email',$data['user_email']);

	}

	*/



	function banuser($id,$limit)

	{

		$this->load->helper('date');

		$datestring = "%Y-%m-%d %h:%i:%a";

		$time = time();

		$data['banned'] 		= ($limit=='forever')?2:1;

		$data['banned_date'] 	= mdate($datestring, $time);

		if($limit!='forever')

		$data['banned_till']	= date('Y-m-d h:i:a', strtotime(' +'.$limit.' day'));

		$this->db->update('users',$data,array('id'=>$id));

	}



	function update_password($password)

	{

		$this->load->library('encrypt');

		$user_email = $this->session->userdata('user_email');

		$data['password'] = $this->encrypt->sha1($password);

		$data['recovery_key'] = '';

		$this->db->update('users',$data,array('user_email'=>$user_email));

	}



	function insert_post($data)

	{

		if($data['posttype']=='video')

		{

			// <iframe width="420" height="315" src="//www.youtube.com/embed/jIL0ze6_GIY" frameborder="0" allowfullscreen></iframe>

			// <iframe src="http://player.vimeo.com/video/VIDEO_ID" width="WIDTH" height="HEIGHT" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>

		}

		else

		{

			if($data['posttype']=='url')

			{

			/*	$filePath = filePath($data['url']);			

				$this->load->library('upload');

				$this->upload->file_ext = '.'.$filePath['extension'];

				$name = $this->upload->set_filename('./uploads/',$filePath['basename']);

				$img = './uploads/'.$name;

				file_put_contents($img, file_get_contents($data['url']));*/

				$url = $data['url'];

			}

			else

			{

				$url = base_url().'uploads/'.$data['file'];

			}



			if (is_animated($url))

	        {

	            $data['file_type'] = 'animation';

	        }

	        else

	        {

	            $data['file_type'] = 'normal';

	        }			

		}



		$this->db->insert('posts',$data);

		return $this->db->insert_id();

	}



	function update_post($data,$id)

	{

		$post = $this->get_post_by_id($id);

		if($post!=FALSE && $post->status!=1)

		{

			$this->db->update('posts',$data,array('id'=>$id));

			return array('error'=>0,'msg'=>'post updated');			

		}

		else

			return array('error'=>1,'msg'=>'post can\'t be updated');



	}



	function get_post_by_id($id)

	{

		$query = $this->db->get_where('posts',array('id'=>$id));

		if($query->num_rows()>0)

		return $query->row();

		else 

		return FALSE;

	}



	function get_all_user_posts_by_range($start,$limit='',$sort_by='',$id)

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status',1); 

		$this->db->where('created_by',$id);

		if($start=='all')

		$query = $this->db->get('posts');

		else

		$query = $this->db->get('posts',$limit,$start);

		return $query;

	}

	

	function count_all_user_posts($id)

	{

		$this->db->where('status',1); 		

		$this->db->where('created_by',$id); 

		$query = $this->db->get('posts');

		return $query->num_rows();

	}



	function get_all_posts_by_range($start,$limit='',$sort_by='')

	{

		$this->db->order_by($sort_by, "asc");

		//$this->db->where('status',1); 

		if($start=='all')

		$query = $this->db->get('posts');

		else

		$query = $this->db->get('posts',$limit,$start);

		return $query;

	}

	

	function count_all_posts()

	{

		//$this->db->where('status',1); 

		$query = $this->db->get('posts');

		return $query->num_rows();

	}



	function get_all_users_by_range($start,$limit='',$sort_by='')

	{

		$this->db->order_by($sort_by, "asc");

		$this->db->where('status',1); 

		if($start==='all')

		$query = $this->db->get('users');

		else

		$query = $this->db->get('users',$limit,$start);

		return $query;

	}



	function count_all_users()

	{

		$this->db->where('status',1);

		$query = $this->db->get('users');

		return $query->num_rows();

	}

}



/* End of file install.php */
/* Location: ./application/modules/user/models/user_model_core.php */