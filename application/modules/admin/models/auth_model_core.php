<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory auth_model_core model
 *
 * This class handles auth_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	auth_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Auth_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	function check_login($user_name,$password,$return_as='num_rows')
	{
		$this->load->library('encrypt');
		$password = $this->encrypt->sha1($password);		
		$query = $this->db->get_where('users',array('user_name'=>$user_name,'password'=>$password));

		if($query->num_rows()<=0)
		{
			
			$mail_query = $this->db->get_where('users',array('user_email'=>$user_name,'password'=>$password));
			if($mail_query->num_rows()>0)
				$query = $mail_query;
		}

		if($return_as=='num_rows')
		{
			if($query->num_rows()>0)
			{
				$row = $query->row();
				if($row->user_type==1)
					return 1;
				else
				{
					if($row->confirmed==1)
						return 1;
					else
						return -1;
				}
			}
			else 
				return 0;
		}
		else
		{
			return $query;
		}
	}
	
	function set_login_cookie($user_name)
	{
		$val = rand(1000,9000);
		$cookie = array(
                   'name'   => 'key',
                   'value'  => $val,
                   'expire' => '86500',
                   'domain' => '.localhost',
                   'path'   => '/',
                   'prefix' => 'mycookie_',
               );

		set_cookie($cookie);
		
		$cookie = array(
                   'name'   => 'user',
                   'value'  => $user_name,
                   'expire' => '86500',
                   'domain' => '.localhost',
                   'path'   => '/',
                   'prefix' => 'mycookie_',
               );

		set_cookie($cookie);
		
		$data['remember_me_key'] = $val;
		$this->db->update('users',$data,array('user_name'=>$user_name));
	}
	
	function check_cookie_val($user,$key)
	{
		$query = $this->db->get_where('users',array('user_name'=>$user,'remember_me_key'=>$key));
		if($query->num_rows()>0)
		{
			$this->session->set_userdata('user_name',$user);
		}
	}
	
	function is_email_exists($email)
	{
		$query = $this->db->get_where('users',array('user_email'=>$email));
		return $query->num_rows();
	}

    function is_username_exists($username)
    {
        $query = $this->db->get_where('users',array('user_name'=>$username));
        return $query->num_rows();
    }
	
	function set_recovery_key($user_email)
	{
		$data['recovery_key'] = uniqid();
		$this->db->update('users',$data,array('user_email'=>$user_email));
		
		$query = $this->db->get_where('users',array('user_email'=>$user_email));
		$row = $query->row();
		$data['username'] = $row->user_name;
        $data['user_email'] = $row->user_email;
		return $data;
	}
	
	function verify_recovery($user_name,$recovery_key)
	{
		if($user_name=='' || $recovery_key=='')
			return 0;
		else
		{
			$query = $this->db->get_where('users',array('user_name'=>$user_name,'recovery_key'=>$recovery_key));
			return $query->num_rows();
		}
	}
	
	function update_password($password)
	{
		$this->load->library('encrypt');
		$user_name = $this->session->userdata('user_name');
		$data['password'] = $this->encrypt->sha1($password);
		$data['recovery_key'] = '';
		$this->db->update('users',$data,array('user_name'=>$user_name));
	}

    function insert_user($data){
        $this->db->insert('users', $data);
    }

	function confirm_email($email,$code)
	{
		$query = $this->db->get_where('users',array('user_email'=>$email,'confirmation_key'=>$code));
		if($query->num_rows()>0)
		{
			$this->load->helper('date');
			$datestring = "%Y-%m-%d %h:%i:%a";
			$time = time();

			$data['confirmed'] = 1;
			$data['confirmed_date'] = mdate($datestring, $time);
			$data['confirmation_key'] = '';
			$this->db->update('users',$data,array('user_email'=>$email));
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
}

/* End of file auth_model.php */
/* Location: ./system/application/modules/admin/models/auth_model.php */