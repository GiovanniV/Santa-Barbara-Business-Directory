<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory account Controller
 *
 * This class handles user account related functionality
 *
 * @package		Account
 * @subpackage	Account
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */





class Account_core extends CI_Controller {



	var $active_theme = '';

	var $per_page = 2;

	public function __construct()

	{

		parent::__construct();

		$this->load->database();

		$this->active_theme = get_active_theme();

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger" style="margin-bottom:0;">', '</div>');

		$this->load->helper('date');

		$this->load->model('auth_model');

	}

	function index()
	{
		$this->trylogin();
	}
	
	#loads login view(without modal)
	public function trylogin()

	{

		$data['content'] 	= load_view('login_view','',TRUE);
        $data['alias']	    = 'signup';
        load_template($data,$this->active_theme);

	}


	#check login using ajax form modals
	public function check_login_ajax(){

		$dest = $this->input->post('dest');

		if($dest!='')

			$this->session->set_userdata('req_url',$dest);

		

		echo ($this->session->userdata('user_name')=='')?'no':'yes';

	}


	#check login from login form
	public function login()

	{

		$this->form_validation->set_rules('useremail','Email','required|valid_email|xss_clean');

		$this->form_validation->set_rules('password','Password','required|xss_clean');

		

		if ($this->form_validation->run() == FALSE)

		{

			$this->trylogin();	

		}

		else

		{

			$this->load->model('auth_model');

			$query = $this->auth_model->check_login($this->input->post('useremail'),$this->input->post('password'),'result');



			if($query->num_rows()>0)

			{				

				$row = $query->row();

				if($row->banned==1)

				{

					$msg = '<div class="alert alert-danger">'.

					        	'<button data-dismiss="alert" class="close" type="button">×</button>'.

					        	'<strong>'.lang_key('user_banned').'</strong>'.

					    	'</div>';

					$this->session->set_flashdata('msg', $msg);							

					redirect(site_url('account/trylogin'));

				}
				else if($row->confirmed!=1)

				{

					$msg = '<div class="alert alert-danger">'.

					        	'<button data-dismiss="alert" class="close" type="button">×</button>'.

					        	'<strong>'.lang_key('account_not_confirmed').'</strong>'.

					    	'</div>';

					$this->session->set_flashdata('msg', $msg);							

					redirect(site_url('account/trylogin'));

				}

				else

				{

					if(is_admin())
						create_log($row->user_name);
					
					$this->session->set_userdata('user_id',$row->id);

					$this->session->set_userdata('user_name',$row->user_name);

					$this->session->set_userdata('user_type',$row->user_type);

					$this->session->set_userdata('user_email',$this->input->post('useremail'));

					

					if($this->session->userdata('req_url')!='')

					{

						$req_url = $this->session->userdata('req_url');

						$this->session->set_userdata('req_url','');

						redirect($req_url);

					}

					redirect(site_url());					

				}

			}

			else

			{				

				$msg = '<div class="alert alert-danger">'.

					        '<button data-dismiss="alert" class="close" type="button">×</button>'.

					        '<strong>'.lang_key('email_or_password_not_mathed').'</strong>'.

					    '</div>';

				$this->session->set_flashdata('msg', $msg);							

				redirect(site_url('account/trylogin'));

			}

		}



	}


	#logout a user
	public function logout()

	{

		$this->session->sess_destroy();

		redirect(site_url());

	}

	#loads signup view
	public function signup()
	{
		$data['content'] 	= load_view('register_view','',TRUE);
        $data['alias']	    = 'signup';
        load_template($data,$this->active_theme);
	}

    public function takepackage()
    {
		$this->form_validation->set_rules('package_id', 'Package id', 'required');		
		if ($this->form_validation->run() == FALSE)
		{
			$this->signup();	
		}
		else
		{
			$package_id = $this->input->post('package_id');
			$this->session->set_userdata('package_id',$package_id);
			if($this->session->userdata('from')=='facebook')
			{
				$this->session->set_userdata('from','signup');
				redirect(site_url('account/fbauth'));
			}
			else
				redirect(site_url('account/signupform'));
		}
    }

    public function signupform()
    {
    	if($this->session->userdata('package_id')=='')
    	{
    		if(get_settings('business_settings','enable_pricing','Yes')=='Yes')
    			redirect(site_url('account/signup'));
    		else
    			$value = array();
    	}
    	else
    	{
    		$this->load->model('admin/package_model');
			$value['package']  = $this->package_model->get_package_by_id($this->session->userdata('package_id'));
    	}


        $data['content'] 	= load_view('register_view',$value,TRUE);
        $data['alias']	    = 'signup';
        load_template($data,$this->active_theme);
    }

	#controls different signup method routing
	function newaccount($type='',$user_type='individual')
	{
		if($user_type=='business')
		$this->session->set_userdata('signup_user_type',2);
		else
		$this->session->set_userdata('signup_user_type',3);

		if($type=='fb')
			redirect(site_url('account/fbauth'));

		else if($type=='google_plus')
		{
			redirect(site_url('account/google_plus_auth'));
		}
	}


	#signup form submits to this function
	function register()
	{
		$user_type = $this->input->post('user_type');

		$this->form_validation->set_rules('first_name',	lang_key('first_name'), 		'required|xss_clean');
		$this->form_validation->set_rules('last_name',	lang_key('last_name'), 		'required|xss_clean');
		$this->form_validation->set_rules('gender',		lang_key('gender'), 			'required|xss_clean');
		$this->form_validation->set_rules('username', 	lang_key('username'), 		'required|callback_username_check|xss_clean');


        $this->form_validation->set_rules('company_name',lang_key('company_name'), 	'xss_clean');
        $this->form_validation->set_rules('phone',lang_key('phone'), 	'xss_clean');
        $this->form_validation->set_rules('useremail',	lang_key('user_email'), 		'required|valid_email|xss_clean|callback_useremail_check');
		$this->form_validation->set_rules('password', 	lang_key('password'), 		'required|matches[repassword]|min_length[5]|xss_clean');
		$this->form_validation->set_rules('repassword',	lang_key('confirm_password'), 			'required|xss_clean');
		$this->form_validation->set_rules('terms_conditon',lang_key('terms_and_condition'),'xss_clean|callback_terms_check');
		$enable_pricing = get_settings('business_settings','enable_pricing','Yes');
		

		if ($this->form_validation->run() == FALSE)
		{
			$this->signup();	
		}
		else
		{

			$this->load->library('encrypt');

			$userdata['user_type']	= 2;//2 = users

			$userdata['first_name'] = $this->input->post('first_name');
			$userdata['last_name'] 	= $this->input->post('last_name');
			$userdata['gender'] 	= $this->input->post('gender');			
			$userdata['user_name'] 	= $this->input->post('username');
			$userdata['user_email'] = $this->input->post('useremail');
			$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
			$userdata['confirmation_key'] 	= uniqid();
			$userdata['confirmed'] 	= 0;
			$userdata['status']		= 1;

			$this->load->model('user/user_model');
			$user_id = $this->user_model->insert_user_data($userdata);
			
			add_user_meta($user_id,'company_name',$this->input->post('company_name'));
            add_user_meta($user_id,'phone',$this->input->post('phone'));
			
			$this->send_confirmation_email($userdata);				
			redirect(site_url('account/success'));				
		}
	}

	#load confirmation view
	public function success()
	{
		$data['content'] 	= load_view('success_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}

	#load confirmation view
	public function confirmation()
	{
		$data['content'] 	= load_view('confirmation_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}

	#************** paypal payment *************#
	
	#paypal returns ipn to this url
	public function ipn_url()
	{		
		# STEP 1: Read POST data
 
		# reading posted data from directly from $_POST causes serialization 
		# issues with array data in POST
		# reading raw POST data from input stream instead. 
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) 
		{
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
		     $myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		# read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) 
		{
		   $get_magic_quotes_exists = true;
		} 
		foreach ($myPost as $key => $value) 
		{        
		   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
		   { 
		        $value = urlencode(stripslashes($value)); 
		   } 
		   else 
		   {
		        $value = urlencode($value);
		   }
		   $req .= "&$key=$value";
		}
		 
		 
		# STEP 2: Post IPN data back to paypal to validate

		$action = (get_settings('paypal_settings','enable_sandbox_mode','No')=='Yes')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
		 
		$ch = curl_init($action);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		 
		# In wamp like environments that do not come bundled with root authority certificates,
		# please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
		# of the certificate as shown below.
		# curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		if( !($res = curl_exec($ch)) ) {
		    # $this->write_log("Got " . curl_error($ch) . " when processing IPN data");
		    curl_close($ch);
		    //$this->send_notification_mail('Curl error');
		    //$this->write_log('curl error');
		    exit;
		}
		curl_close($ch);
		 
		//$this->send_notification_mail('After curl');
		
		# STEP 3: Inspect IPN validation result and act accordingly
		 
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			# assign posted variables to local variables
		    $uniqid 			= $_POST['custom'];
		    $item_name 			= $_POST['item_name'];
		    $item_number 		= $_POST['item_number'];
		    $payment_status 	= $_POST['payment_status'];
		    $payment_amount 	= $_POST['mc_gross'];
		    $payment_currency 	= $_POST['mc_currency'];
		    $txn_id 			= $_POST['txn_id'];
		    $txn_type 			= $_POST['txn_type'];
		    $receiver_email 	= $_POST['receiver_email'];
		    $payer_email 		= $_POST['payer_email'];
			# check whether the payment_status is Completed
		    # check that txn_id has not been previously processed
		    # check that receiver_email is your Primary PayPal email
		    # check that payment_amount/payment_currency are correct
		    //$this->send_notification_mail('verified');
		    //$this->send_notification_mail('verified post data : '.serialize($_POST));
		    $this->load->model('user/user_model');
		    $order = $this->user_model->get_user_payment_data_by_unique_id($uniqid);
		    
		    if($order->num_rows()>0)
		    {
		    	$order 		= $order->row();
		    	$order_id 	= $order->id;
		    	//$this->send_notification_mail('within valid order block');

			    $my_receiver_email = get_settings('paypal_settings','email','none');
			    
			    $msg =  'Status : '.$payment_status.'|'.
			    		'emails :'.$my_receiver_email.' = '.$receiver_email.
			    		'amount : '.$order->amount.' = '.$payment_amount.
			    		'curr :'.$payment_currency.' = '.get_settings('paypal_settings','currency','USD');

			    //$this->send_notification_mail($msg);
		    	if($payment_status=='Completed' /*&& $this->register_model->check_txn_id($txn_id)==TRUE*/ && 
		    	   $my_receiver_email==$receiver_email && $order->amount==$payment_amount && $payment_currency==get_settings('paypal_settings','currency','USD'))
		    	{
		    		# process payment
		    		$response = serialize($_POST);
		    		#$this->send_notification_mail('before update');
		    		if($txn_type=='web_accept')
		    		{
		    			#$this->send_notification_mail('within update');
		    			$this->load->model('admin/package_model');
		    			$package 	= $this->package_model->get_package_by_id($order->package_id);
		    			$datestring = "%Y-%m-%d";
						$time = time();
						$activation_date = mdate($datestring, $time);
						$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
		    			$expirtion_date = mdate($datestring, $expirtion_date);

		    			$data = array();
		    			$data['is_active'] 		 	= 1;
		    			$data['activation_date'] 	= $activation_date;
		    			$data['expirtion_date'] 	= $expirtion_date;
		    			$data['response_log']		= $response;

		    			$this->user_model->update_user_payment_data_by_unique_id($data,$uniqid);
		    			add_user_meta($order->user_id,'current_package',$package->id);
		    			add_user_meta($order->user_id,'expirtion_date',$expirtion_date);
		    			add_user_meta($order->user_id,'active_order_id',$uniqid);
		    			add_user_meta($order->user_id,'post_count',0);

		    			$user = $this->user_model->get_user_data_array_by_id($order->user_id);
						
						$this->auth_model->confirm_email($user['user_email'],$user['confirmation_key']);
						$this->send_payment_confirmation_email($user);
		    		}
		    		
		    		//$this->write_log($txn_type.' from '.$username);
		    	}
		    	
		    	if($txn_type=='subscr_cancel') 
		    	{
		    		//$this->send_notification_mail('subscriber cancel');
		    	}
		    	else if($txn_type=='subscr_eot' || $txn_type=='subscr_failed')
		    	{
		    		//$this->send_notification_mail('subscriber failed');
		    	}
		    }
		    
		}
		else if (strcmp ($res, "INVALID") == 0) 
		{
		    //$this->write_log('invalid payment');
		}
	}


	#paypal returns ipn to this url
	public function featured_ipn_url()
	{		
		# STEP 1: Read POST data
 
		# reading posted data from directly from $_POST causes serialization 
		# issues with array data in POST
		# reading raw POST data from input stream instead. 
		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval) 
		{
		  $keyval = explode ('=', $keyval);
		  if (count($keyval) == 2)
		     $myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		# read the post from PayPal system and add 'cmd'
		$req = 'cmd=_notify-validate';
		if(function_exists('get_magic_quotes_gpc')) 
		{
		   $get_magic_quotes_exists = true;
		} 
		foreach ($myPost as $key => $value) 
		{        
		   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) 
		   { 
		        $value = urlencode(stripslashes($value)); 
		   } 
		   else 
		   {
		        $value = urlencode($value);
		   }
		   $req .= "&$key=$value";
		}
		 
		 
		# STEP 2: Post IPN data back to paypal to validate

		$action = (get_settings('paypal_settings','enable_sandbox_mode','No')=='Yes')?'https://www.sandbox.paypal.com/cgi-bin/webscr':'https://www.paypal.com/cgi-bin/webscr';
		 
		$ch = curl_init($action);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
		 
		# In wamp like environments that do not come bundled with root authority certificates,
		# please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set the directory path 
		# of the certificate as shown below.
		# curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
		if( !($res = curl_exec($ch)) ) {
		    # $this->write_log("Got " . curl_error($ch) . " when processing IPN data");
		    curl_close($ch);
		    //$this->send_notification_mail('Curl error');
		    //$this->write_log('curl error');
		    exit;
		}
		curl_close($ch);
		 
		#$this->send_notification_mail('After curl');
		
		# STEP 3: Inspect IPN validation result and act accordingly
		 
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			# assign posted variables to local variables
		    $uniqid 			= $_POST['custom'];
		    $item_name 			= $_POST['item_name'];
		    $item_number 		= $_POST['item_number'];
		    $payment_status 	= $_POST['payment_status'];
		    $payment_amount 	= $_POST['mc_gross'];
		    $payment_currency 	= $_POST['mc_currency'];
		    $txn_id 			= $_POST['txn_id'];
		    $txn_type 			= $_POST['txn_type'];
		    $receiver_email 	= $_POST['receiver_email'];
		    $payer_email 		= $_POST['payer_email'];
			# check whether the payment_status is Completed
		    # check that txn_id has not been previously processed
		    # check that receiver_email is your Primary PayPal email
		    # check that payment_amount/payment_currency are correct
		    //$this->send_notification_mail('verified');
		    #$this->send_notification_mail('verified post data : '.serialize($_POST));
		    $this->load->model('admin/realestate_model');
		    $order = $this->realestate_model->get_feature_payment_data_by_unique_id($uniqid);
		    
		    if($order->num_rows()>0)
		    {
		    	$post_meta 		= $order->row();
		    	$post_id 	= $post_meta->post_id;
		    	$order = json_decode($post_meta->value);
		    	#$order_id 	= $order->id;
		    	#$this->send_notification_mail('within valid order block');

			    $my_receiver_email = get_settings('paypal_settings','email','none');
			    
			    $msg =  'Status : '.$payment_status.'|'.
			    		'emails :'.$my_receiver_email.' = '.$receiver_email.
			    		'amount : '.$order->amount.' = '.$payment_amount.
			    		'curr :'.$payment_currency.' = '.get_settings('paypal_settings','currency','USD');

			    #$this->send_notification_mail($msg);
		    	if($payment_status=='Completed' /*&& $this->register_model->check_txn_id($txn_id)==TRUE*/ && 
		    	   $my_receiver_email==$receiver_email && $order->amount==$payment_amount && $payment_currency==get_settings('paypal_settings','currency','USD'))
		    	{
		    		# process payment
		    		$response = serialize($_POST);
		    		#$this->send_notification_mail('before update');
		    		if($txn_type=='web_accept')
		    		{
		    			#$this->send_notification_mail('within update');
		    			$datestring = "%Y-%m-%d";
						$time = time();
						$activation_date = mdate($datestring, $time);
						$expirtion_date  = strtotime('+'.$order->daylimit.' days',$time);
		    			$expirtion_date  = mdate($datestring, $expirtion_date);

						add_post_meta($post_id,'feature_expirtion_date',$expirtion_date);
						add_post_meta($post_id,'last_feature_payment',$uniqid);

						$this->realestate_model->update_post_by_id(array('featured'=>1),$post_id);
						#$this->send_notification_mail('after db update');
		    		}
		    		
		    		//$this->write_log($txn_type.' from '.$username);
		    	}
		    	
		    	if($txn_type=='subscr_cancel') 
		    	{
		    		//$this->send_notification_mail('subscriber cancel');
		    	}
		    	else if($txn_type=='subscr_eot' || $txn_type=='subscr_failed')
		    	{
		    		//$this->send_notification_mail('subscriber failed');
		    	}
		    }
		    
		}
		else if (strcmp ($res, "INVALID") == 0) 
		{
		    //$this->write_log('invalid payment');
		}
	}

	#for test purpose
	public function send_notification_mail($msg)
	{
		$this->load->helper('date');
		$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
		$time = time();
		$this->load->library('email');
		$this->email->from('mmtpaypal@bookit.com', 'Paypal Test');
		$this->email->to('shimulcsedu@gmail.com');
		$this->email->subject('Paypal subscription('.mdate($datestring, $time).')');
		$this->email->message($msg);
		
		$this->email->send();
	}

	#load any msg on front end
	public function showmsg()
	{
		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
		load_template($data,$this->active_theme);
	}

	#terms validation function
	public function terms_check($str)
	{
		$this->load->model('auth_model');		
		if ($_POST['terms_conditon']=='')
		{
			$this->form_validation->set_message('terms_check', lang_key('must_accept_terms'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}


	#recovery email validation function
	public function useremail_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);
		if ($res>0)
		{
			$this->form_validation->set_message('useremail_check', lang_key('email_allready_in_use'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}



	#username validation function

	public function username_check($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_username_exists($str);

		if ($res>0)
		{
			$this->form_validation->set_message('username_check', lang_key('username_allready_in_use'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
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


	#send a payment confirmation email with confirmation link
	public function send_payment_confirmation_email($data=array())
	{
		$val = $this->get_admin_email_and_name();
		$admin_email = $val['admin_email'];
		$admin_name  = $val['admin_name'];
		$link = site_url('account/login/'); 
		
		$this->load->model('admin/system_model');
		$tmpl = $this->system_model->get_email_tmpl_by_email_name('payment_confirmation_email');
		$subject = $tmpl->subject;
		$subject = str_replace("#username",$data['user_name'],$subject);
		$subject = str_replace("#loginlink",$link,$subject);
		$subject = str_replace("#webadmin",$admin_name,$subject);
		$subject = str_replace("#useremail",$data['user_email'],$subject);

		
		$body = $tmpl->body;
		$body = str_replace("#username",$data['user_name'],$body);
		$body = str_replace("#loginlink",$link,$body);
		$body = str_replace("#webadmin",$admin_name,$body);
		$body = str_replace("#useremail",$data['user_email'],$body);

				
		$this->load->library('email');
		$this->email->from($admin_email, $subject);
		$this->email->to($data['user_email']);
		$this->email->subject($subject);		
		$this->email->message($body);		
		$this->email->send();
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

	#show confirmation msg
	public function showrequestconfirmation()
	{
		$data['content'] = load_view('account/requestconfirmation_view','',TRUE);
		load_template($data,$this->active_theme,'onecolumn_template_view');		
	}

	#recovery email validation function
	public function check_email_validation($str)
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->is_email_exists($str);

		if ($res<=0)
		{
			$this->form_validation->set_message('check_email_validation', lang_key('email_not_found'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#confirmation email request form submits here
	public function requestconfirmation()
	{
		$this->form_validation->set_rules('useremail',	'Email', 'required|valid_email|xss_clean|callback_check_email_validation');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->showrequestconfirmation();	
		}
		else
		{
			$userdata = $this->auth_model->get_userdata_by_email($this->input->post('useremail'));
			$this->send_confirmation_email($userdata);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('confirm_email_send').'</div>');
			redirect(site_url('account'));		
		}
	}


	#confirmation email link points here
	public function confirm($email='',$code='')
	{
		$this->load->model('auth_model');
		$res = $this->auth_model->confirm_email($email,$code);

		if($res==TRUE)
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_confirmed').'</div>');
			redirect(site_url('account/showmsg'));		
		}
		else
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-danger">'.lang_key('email_confirmed_failed').'</div>');
			redirect(site_url('account/showmsg'));
		}
	}


	#current password validation function for password changing
	function currentpass_check($str)
	{

		$user_name = $this->session->userdata('user_name');
		$res = $this->auth_model->check_login($user_name,$str);

		if ($res<=0)
		{
			$this->form_validation->set_message('currentpass_check', lang_key('current_password_not_matched'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	#update password function
	function update_password()
	{
		if($this->session->userdata('recovery')!='yes')
		$this->form_validation->set_rules('current_password', lang_key('current_password'), 'required|callback_currentpass_check');
		$this->form_validation->set_rules('new_password', lang_key('new_password'), 'required|matches[re_password]');
		$this->form_validation->set_rules('re_password', lang_key('confirm_password'), 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->changepass();	
		}
		else
		{
			$password = $this->input->post('new_password');
			$this->auth_model->update_password($password);
			$this->session->set_userdata('recovery',"no");
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('password_change_success').'</div>');
			redirect(site_url('admin/auth/changepass'));		
		}
	}

	#load forgot password view
	function forgotpass()
	{
		$data['content'] 	= load_view('recover_view','',TRUE);
        $data['alias']	    = 'recover';
        load_template($data,$this->active_theme);
	}

	#forgot password function
	#check if given email is valid or not
	#if valid then send a recovery email
	function recoverpassword()
	{
		$this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|xss_clean|callback_useremail_match_check');

		if ($this->form_validation->run() == FALSE)
		{
			$this->forgotpass();	
		}
		else
		{
			$user_email = $this->input->post('user_email');
			$val = $this->auth_model->set_recovery_key($user_email);
			$this->_send_recovery_email($val);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('email_sent_inbox').'</div>');
			redirect(site_url('account/showmsg'));		
		}
	}

	

	#recovery email validation function

	function useremail_match_check($str)
	{

		$this->load->model('account/auth_model');

		$res = $this->auth_model->is_email_exists($str);

		if ($res<=0)

		{

			$this->form_validation->set_message('useremail_match_check', lang_key('email_not_matched'));

			return FALSE;

		}

		else if(is_banned($str))

		{

			$this->form_validation->set_message('useremail_match_check', lang_key('user_banned'));

			return FALSE;			

		}

		else

		{

			return TRUE;

		}

	}



	#recovery email validation function

	function useremail_user_ban_check($str)

	{

		if (is_banned($str))

		{

			$this->form_validation->set_message('useremail_user_ban_check', lang_key('user_banned'));

			return FALSE;

		}

		else

		{

			return TRUE;

		}

	}

	
	#send recovery email
	function _send_recovery_email($data)

	{



		$val = $this->get_admin_email_and_name();

		$admin_email = $val['admin_email'];

		$admin_name  = $val['admin_name'];

		$link = site_url('account/resetpassword').'/'.$data['user_email'].'/'.$data['recovery_key'];

		

		$this->load->model('admin/system_model');

		$tmpl = $this->system_model->get_email_tmpl_by_email_name('recovery_email');

		$subject = $tmpl->subject;

		$subject = str_replace("#username",$data['user_name'],$subject);

		$subject = str_replace("#recoverylink",$link,$subject);

		$subject = str_replace("#webadmin",$admin_name,$subject);



		

		$body = $tmpl->body;

		$body = str_replace("#username",$data['user_name'],$body);

		$body = str_replace("#recoverylink",$link,$body);

		$body = str_replace("#webadmin",$admin_name,$body);

				

		$this->load->library('email');

		$this->email->from($admin_email, $subject);

		$this->email->to($data['user_email']);

		$this->email->subject($subject);		

		$this->email->message($body);		

		$this->email->send();

	}

	
	#reset password email link points here
	function resetpassword($user_email='',$recovery_key='')
	{

		$query = $this->auth_model->verify_recovery($user_email,$recovery_key);	

		if($query->num_rows()>0)

		{
			$row = $query->row();

			$this->session->set_userdata('user_id',$row->id);

			$this->session->set_userdata('user_email',$row->user_email);
			
			$this->session->set_userdata('user_name',$row->user_name);

			$this->session->set_userdata('user_type',$row->user_type);

			$this->session->set_userdata('recovery',"yes");

			redirect(site_url('admin/auth/changepass'));

		}

		else

		{

			$this->session->set_flashdata('msg', '<div class="alert alert-block">'.lang_key('password_recovery_link_invalid').'</div>');

			redirect(site_url('account/forgotpass'));

		}

	}

	#client returns to this url from paypal return link
	public function finish_url($type='')
	{
		$data['content']  	= load_view('finish_view','',TRUE);		
		load_template($data,$this->active_theme);
	}
	
	#client returns to this url if they cancel paypal payment
	public function cancel_url()
	{		
		$data['content']  	= load_view('cancel_view','',TRUE);		
		load_template($data,$this->active_theme);
	}

	public function recoverpayment($unique_id)
	{
		$this->load->model('user/user_model');	
		$order = $this->user_model->get_user_payment_data_by_unique_id($unique_id);		    
	    if($order->num_rows()>0)
	    {
	    	$order = $order->row();
			$this->session->set_userdata('unique_id',$unique_id);
			$this->session->set_userdata('amount',$order->amount);
			redirect(site_url('account/confirmation'));
	    }
	    else
	    {
	    	echo 'payment request id invalid';die;
	    }
	}
}