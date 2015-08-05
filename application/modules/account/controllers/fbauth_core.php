<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory fbauth Controller
 *
 * This class handles user account related functionality
 *
 * @package		Account
 * @subpackage	fbauth
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Fbauth_core extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
		$CI 	= & get_instance();
		$appId 	= get_settings('business_settings','fb_app_id','none');
		$secret = get_settings('business_settings','fb_secret_key','none');
        $config = array('appId'=>$appId,'secret'=>$secret);
        $this->load->library('Facebook', $config);
	}

	#get web admin name and email for email sending
	public function get_admin_email_and_name()
	{
		$this->load->model('admin/options_model');
		$values = $this->options_model->getvalues('webadmin_email');

		if(count($values))
		{
			$data['admin_email'] = (isset($values->webadmin_email))?$values->webadmin_email:'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = (isset($values->webadmin_name))?$values->webadmin_name:'Admin';
		}
		else
		{
			$data['admin_email'] = 'admin@'.$_SERVER['HTTP_HOST'];
			$data['admin_name']  = 'Admin';		
		}

		return $data;
	}	

	
	#send a confirmation email with confirmation link
	public function send_confirmation_email($data=array('username'=>'sc mondal','useremail'=>'shimulcsedu@gmail.com','confirmation_key'=>'1234'))
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		$link = site_url('account/confirm/'.$data['user_email'].'/'.$data['confirmation_key']); 
		
		$this->load->model('admin/system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('confirmation_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['user_name'],$subject);
		$subject = str_replace("#activationlink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);
		$subject = str_replace("#useremail",$data['user_email'],$subject);

		
		$body = $tmpl->body;
		$body = str_replace("#username",$data['user_name'],$body);
		$body = str_replace("#activationlink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		$body = str_replace("#useremail",$data['user_email'],$body);

				
		$this->load->library('email');
		$this->email->from($admin_email, $subject);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);		
		$this->email->message($body);		
		$this->email->send();
	}
	function index()
	{

		// Try to get the user's id on Facebook
		$userId = $this->facebook->getUser();

		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
			// Generate a login url
			$data['url'] = $this->facebook->getLoginUrl(array('scope'=>'email')); 
			redirect($data['url']);
		} else {
			// Get user's data and print it
			$user = $this->facebook->api('/me');
			$this->load->model('auth_model');

			$row = $this->auth_model->register_user_if_not_exists($user);			

			if(is_banned($row['user_email']))
			{
				$msg = '<div class="alert alert-danger">
				        	<button data-dismiss="alert" class="close" type="button">×</button>
				        	<strong>User banned
				    	</div>';
				$this->session->set_flashdata('msg', $msg);					
				redirect(site_url('account/trylogin'));				
			}
			else
			{
				$this->login($row);			
			}
		}
	}

	function login($row)
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

?>