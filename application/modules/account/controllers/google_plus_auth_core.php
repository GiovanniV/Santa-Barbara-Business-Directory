<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory googleauth Controller
 *
 * This class handles user account related functionality
 *
 * @package		Account
 * @subpackage	google_plus
 * @author		sc mondal
 * @link		http://dbcinfotech.net
 */


class Google_plus_auth_core extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->library('session');
		$this->load->library('googleplus');
		if($this->session->userdata('user_name'))
		{
			echo 'name: '.$this->session->userdata('user_name');
		}
		
		else
		{
			$authUrl = $this->googleplus->client->createAuthUrl();
			redirect($authUrl);
		}

	}

	public function auth_callback()
	{
		$this->load->library('session');
		$this->load->library('googleplus');
		
		try
		{
			if (isset($_GET['code']))
			{
				$this->googleplus->client->authenticate($_GET['code']);
				$this->googleplus->client->getAccessToken();
				$user_data = $this->googleplus->plus->people->get('me');

				/******** For debuggin purpose*********/
				// echo 'email: '.$user_data['emails']['0']['value'].'<br>';
				// echo 'first_name: '.$user_data['name']['givenName'].'<br>';
				// echo 'last_name: '.$user_data['name']['familyName'].'<br>';
				// echo 'gender: '.$user_data['gender'].'<br>';
				// echo 'user_name: '.strstr($user_data['emails']['0']['value'], '@', true).'<br>';
				/*************************************/
				
				$user['first_name'] = $user_data['name']['givenName'];
				$user['last_name'] 	= $user_data['name']['familyName'];
				$user['gender'] 	= $user_data['gender'];
				$user['username'] 	= strstr($user_data['emails']['0']['value'], '@', true);
				$user['email'] 		= $user_data['emails']['0']['value'];

				$this->load->model('auth_model');

				$row = $this->auth_model->register_user_if_not_exists($user,'google');
				if(is_banned($row['user_email']))
				{
					$msg = '<div class="alert alert-danger">
					        	<button data-dismiss="alert" class="close" type="button">×</button>
					        	<strong>User banned</strong>
					    	</div>';
					$this->session->set_flashdata('msg', $msg);					
					redirect(site_url('account/trylogin'));				
				}
				else
				{					
					$this->session->set_userdata('user_id',$row['id']);
					$this->session->set_userdata('user_name',$row['user_name']);
					$this->session->set_userdata('user_type',$row['user_type']);
					$this->session->set_userdata('user_email',$row['user_email']);
					if($this->session->userdata('req_url')!='')
					{
						$req_url = $this->session->userdata('req_url');
						$this->session->set_userdata('req_url','');
						redirect($req_url);
					}
					else
						redirect(base_url());
					
				}
			}
		}
		catch(Exception $e)
		{
			$msg = '<div class="alert alert-danger">
			        	<button data-dismiss="alert" class="close" type="button">×</button>
			        	<strong>Permission denied</strong>
			    	</div>';
			$this->session->set_flashdata('msg', $msg);					
			redirect(site_url('account/trylogin'));
		}
	}

}

?>