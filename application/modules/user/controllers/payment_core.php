<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**

 * BusinessDirectory admin Controller

 *

 * This class handles user account related functionality

 *

 * @package		User

 * @subpackage	UserCore

 * @author		dbcinfotech

 * @link		http://dbcinfotech.net

 */



class Payment_core extends MX_Controller {

	

	var $active_theme = '';

	var $per_page = 2;

	public function __construct()

	{

		parent::__construct();

		is_installed(); #defined in auth helper

		

		// if(!is_loggedin())

		// {

		// 	if(count($_POST)<=0)

		// 	$this->session->set_userdata('req_url',current_url());

		// 	redirect(site_url('account/trylogin'));

		// }

		



		$this->per_page = get_per_page_value();



		$this->load->database();

		$this->active_theme = get_active_theme();

		$this->load->model('user/payment_model');

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger form-error">', '</div>');



	}

	

	public function choosepackage()

	{

		$value = array();

		$this->load->model('admin/package_model');

		$value['packages']		= $this->package_model->get_all_packages_by_type('post_package');

		$data['content'] 		= load_view('choose_package_view',$value,TRUE);

		load_template($data,$this->active_theme);

	}



	public function takepackage()

	{



		$this->form_validation->set_rules('package_id', 'Package', 'required');

		if ($this->form_validation->run() == FALSE)

		{

			$this->choosepackage();	

		}

		else

		{



			$package_id = $this->input->post('package_id');

			$this->session->set_userdata('selected_package',$package_id);

			redirect(site_url('list-business'));

		}

	}

	public function chooserenewpackage($post_id) 
	{
		$value = array();

		$this->load->model('admin/package_model');

		$value['packages']		= $this->package_model->get_all_packages_by_type('post_package');
		$value['renew']			= 'renew';
		$value['renew_post_id']	= $post_id;

		$data['content'] 		= load_view('choose_package_view',$value,TRUE);

		load_template($data,$this->active_theme);
	}

	public function renewpackage() 
	{
		$renew_post_id = $this->input->post('renew_post_id');
		if($renew_post_id==FALSE || $renew_post_id=='')
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">'.lang_key('no_renew_post_id').'</div>');
			redirect(site_url('admin/business/allposts'));
		}
		$this->form_validation->set_rules('package_id', 'Package', 'required');
		if ($this->form_validation->run() == FALSE)
		{
			$this->chooserenewpackage($renew_post_id);
		}
		else
		{
			$package_id = $this->input->post('package_id');
			$this->session->set_userdata('selected_renew_package',$package_id);
			$this->save_renew_payment_history($renew_post_id);
		}
	}



	public function save_payment_history($email='email_true')

	{
		if(get_settings('package_settings','enable_pricing','Yes')=='Yes' && ($this->session->userdata('selected_package')==FALSE || $this->session->userdata('selected_package')==''))
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid data!</div>');
			redirect(site_url('list-business'));
		}

		$this->load->helper('date');



		$datestring = "%Y-%m-%d";

		$time = time();

		$request_date = mdate($datestring, $time);



		$package_id = $this->session->userdata('selected_package');
		$this->session->set_userdata('selected_package','');

		$this->load->model('admin/package_model');

		$package 	= $this->package_model->get_package_by_id($package_id);



		$post_id = $this->session->userdata('post_id');



		$payment_data 					= array(); 

		$payment_data['unique_id'] 		= uniqid();

		$payment_data['post_id'] 		= $post_id;

		$payment_data['package_id'] 	= $package_id;

		$payment_data['amount'] 		= $package->price;

		$payment_data['request_date'] 	= $request_date;

		$payment_data['is_active'] 		= 2; #pending

		$payment_data['status'] 		= 1; #active
		
		$payment_data['payment_type'] 	= 'post'; #active

		$payment_data['payment_medium']	= 'paypal'; 



		$unique_id = $this->payment_model->insert_property_payment_data($payment_data);

		$value = array();
		$value['package'] = $package;
		$value['unique_id'] = $unique_id;

		if($value['package']->price<=0)

		{

			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$activation_date = mdate($datestring, $time);
			$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
			$expirtion_date = mdate($datestring, $expirtion_date);

			$data = array();
			$data['is_active'] 		 	= 1;
			$data['activation_date'] 	= $activation_date;
			$data['expiration_date'] 	= $expirtion_date;
			$data['response_log']		= 'Free package';
			$this->payment_model->update_post_payment_data_by_unique_id($data,$unique_id);

			$data = array();

			if(get_settings('business_settings','publish_directly','Yes')=='Yes') {

				$data['expirtion_date']		= $expirtion_date;
				$data['activation_date'] 	= $activation_date;
				$data['publish_time'] 		= $time;
				$data['last_update_time'] 	= $time;
				$data['status'] 			= 1;

				$this->load->model('admin/business_model');
				$this->business_model->update_post_by_id($data,$post_id);

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_and_published').'</div>');
			}


			else {

				$data['expirtion_date']		= $expirtion_date;
				$data['activation_date'] 	= $activation_date;
				$data['publish_time'] 		= $time;
				$data['last_update_time'] 	= $time;
				$data['status'] 			= 2;

				$this->load->model('admin/business_model');
				$this->business_model->update_post_by_id($data,$post_id);

				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_created_approval').'</div>');
			}




			redirect(site_url('edit-business/0/'.$post_id));

		}

		else

		{
			$email_info = array();
			$email_info['user_name'] = $this->session->userdata('user_name');
			$email_info['user_email'] = $this->session->userdata('user_email');
			$email_info['link'] = site_url('user/payment/resume_payment/'.'u_id='.$unique_id);
			send_payment_confirmation_email($email_info);

			$data['content'] 		= load_view('confirmation_view',$value,TRUE);

			load_template($data,$this->active_theme);			

		}

	}

	public function save_renew_payment_history($post_id)
	{

		if(get_settings('package_settings','enable_pricing','Yes')=='Yes' && $this->session->userdata('selected_renew_package')==FALSE || $this->session->userdata('selected_renew_package')=='')
		{
			$this->session->set_flashdata('msg','<div class="alert alert-danger">Invalid data!</div>');
			redirect(site_url('admin/business/allposts'));
		}

		$this->load->helper('date');
		$datestring = "%Y-%m-%d";
		$time = time();
		$request_date = mdate($datestring, $time);
		
		$package_id = $this->session->userdata('selected_renew_package');
		$this->session->set_userdata('selected_renew_package','');
		
		$this->load->model('admin/package_model');
		$package 	= $this->package_model->get_package_by_id($package_id);
				
		$payment_data 					= array(); 
		$payment_data['unique_id'] 		= uniqid();
		$payment_data['post_id'] 		= $post_id;
		$payment_data['package_id'] 	= $package_id;
		$payment_data['amount'] 		= $package->price;
		$payment_data['request_date'] 	= $request_date;
		$payment_data['is_active'] 		= 2; #pending
		$payment_data['status'] 		= 1; #active
		$payment_data['payment_type'] 	= 'post_renew';
		$payment_data['payment_medium']	= 'paypal';
		
		$unique_id = $this->payment_model->insert_property_payment_data($payment_data);
		
		$value = array();
		$value['package'] = $package;
		$value['unique_id'] = $unique_id;
		if($value['package']->price<=0)
		{
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			$activation_date = mdate($datestring, $time);
			$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
			$expirtion_date = mdate($datestring, $expirtion_date);

			$data = array();
			$data['is_active'] 		 	= 1;
			$data['activation_date'] 	= $activation_date;
			$data['expiration_date'] 	= $expirtion_date;
			$data['response_log']		= 'Free package';
			$this->payment_model->update_post_payment_data_by_unique_id($data,$uniqid);

			//we don't check for admin approval for renew package of a post
			$data = array();
			$data['expirtion_date']		= $expirtion_date;
			$data['activation_date'] 	= $activation_date;
			$data['last_update_time'] 	= $time;
			$data['status'] 			= 1;
			$this->load->model('admin/business_model');
			// echo "<pre>";
			// die(print_r($data));
			$this->business_model->update_post_by_id($data,$post_id);
			$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_package_renewed').'</div>');
			redirect(site_url('edit-business/0/'.$post_id));
		}
		else
		{
			$email_info = array();
			$email_info['user_name'] = $this->session->userdata('user_name');
			$email_info['user_email'] = $this->session->userdata('user_email');
			$email_info['link'] = site_url('user/payment/resume_payment/'.'u_id='.$unique_id.'+renew=renew');
			send_payment_confirmation_email($email_info);

			$value['renew']			= 'renew';
			$data['content'] 		= load_view('confirmation_view',$value,TRUE);
			load_template($data,$this->active_theme);			
		}
	}


	public function resume_payment($string) {

		$string = rawurldecode($string);
    	$data = array();
    	$values = explode("+",$string);

    	foreach ($values as $value) 
    	{
    		$get 	= explode("=",$value);
    		$s 		= (isset($get[1]))?$get[1]:'';
    		$val 	= explode(",",$s);

    		if(count($val)>1)
    		{
	    		$data[$get[0]] = $val;
    		}
    		else
	    		$data[$get[0]] = (isset($get[1]))?$get[1]:'';
    	}
    	if(is_array($data) && isset($data['u_id']) && $data['u_id']!='') {
    		$value = array();
    		$value['unique_id'] = $data['u_id'];
    		
	    	$this->load->model('user/payment_model');
	    	$payment_data = $this->payment_model->get_post_payment_data_by_unique_id($data['u_id']);
	    	if($payment_data->num_rows()>0){
	    		
		    	$this->load->model('admin/package_model');
				$package = $this->package_model->get_package_by_id($payment_data->row()->package_id);
				$value['package'] = $package;
				if(isset($data['renew']) && $data['renew']=='renew')
					$value['renew'] = 'renew';
				
				$data['content'] = load_view('confirmation_view',$value,TRUE);
				load_template($data,$this->active_theme);
	    	}
	    	else {
	    		$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Invalid URL!</div>');
	    		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
	    		load_template($data,$this->active_theme);
	    	}
    	}
    	else {
    		$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Invalid URL!</div>');
    		$data['content'] 	= load_view('msg_view','',TRUE,$this->active_theme);
    		load_template($data,$this->active_theme);
    	}

	}


	#client returns to this url from paypal return link

	public function finish_url($type='')

	{

		//$this->send_notification_mail('post payment finish');

		$data['content']  	= load_view('finish_view','',TRUE);		

		load_template($data,$this->active_theme);

	}

	

	#client returns to this url if they cancel paypal payment

	public function cancel_url()

	{		

		$data['content']  	= load_view('cancel_view','',TRUE);		

		load_template($data,$this->active_theme);

	}





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

			$str = explode("&", $_POST['custom']);



			$custom_val = array();



	    	foreach ($str as $value) 

	    	{

	    		$get 	= explode("=",$value);	

	    		$custom_val[$get[0]] = (isset($get[1]))?$get[1]:'';

	    	}

			# assign posted variables to local variables

		    $uniqid 			= $custom_val['id'];

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

		    $order = $this->payment_model->get_post_payment_data_by_unique_id($uniqid);

		    
		    if($order->num_rows()>0)

		    {

		    	$order 		= $order->row();

		    	$order_id 	= $order->id;

		    	$post_id 	= $order->post_id;

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

		    			$this->load->helper('date');

		    			$datestring = "%Y-%m-%d";

						$time = time();

						$activation_date = mdate($datestring, $time);

						$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);

		    			$expirtion_date = mdate($datestring, $expirtion_date);



		    			$data = array();

		    			$data['is_active'] 		 	= 1;

		    			$data['activation_date'] 	= $activation_date;

		    			$data['expiration_date'] 	= $expirtion_date;

		    			$data['response_log']		= $response;



		    			$this->payment_model->update_post_payment_data_by_unique_id($data,$uniqid);



		    			#update post table -- pending sc



		    			// $this->load->model('user/user_model');

		    			// $user = $this->user_model->get_user_data_array_by_id($order->user_id);



						//send_payment_confirmation_email($user);

						$data = array();

						if(isset($custom_val['renew']) && $custom_val['renew']=='renew') { // if the payment was done to renew the post package we don't check for admin approval since it was approved previously

							$data['expirtion_date']		= $expirtion_date;
							$data['activation_date'] 	= $activation_date;
							$data['last_update_time'] 	= $time;
							$data['status'] 			= 1;

							$this->load->model('admin/business_model');
							$this->business_model->update_post_by_id($data,$post_id);

						}

						else {
							if(get_settings('business_settings','publish_directly','Yes')=='Yes') {

								$data['expirtion_date']		= $expirtion_date;
								$data['activation_date'] 	= $activation_date;
								$data['last_update_time'] 	= $time;
								$data['status'] 			= 1;

								$this->load->model('admin/business_model');
								$this->business_model->update_post_by_id($data,$post_id);

							}


							else {

								$data['expirtion_date']		= $expirtion_date;
								$data['activation_date'] 	= $activation_date;
								$data['last_update_time'] 	= $time;
								$data['status'] 			= 2;

								$this->load->model('admin/business_model');
								$this->business_model->update_post_by_id($data,$post_id);

							}
						}

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

	#client returns to this url from paypal return link

	public function feature_payment_finish_url($type='')

	{

		$this->session->set_flashdata('msg','<div class="alert alert-info">'.lang_key('payment_finish').'</div>');

		redirect(site_url('admin/business/allposts'));

	}

	

	#client returns to this url if they cancel paypal payment

	public function feature_payment_cancel_url()

	{

		$this->session->set_flashdata('msg','<div class="alert alert-danger">'.lang_key('payment_cancelled').'</div>');

		redirect(site_url('admin/business/allposts'));

	}





	#paypal returns ipn to this url

	public function feature_payment_ipn_url()

	{

		//$this->send_notification_mail('Got to feature ipn');

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

			$str = explode("&", $_POST['custom']);



			$custom_val = array();



	    	foreach ($str as $value) 

	    	{

	    		$get 	= explode("=",$value);	

	    		$custom_val[$get[0]] = (isset($get[1]))?$get[1]:'';

	    	}



			# assign posted variables to local variables

		    $uniqid 			= $custom_val['id'];

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

		    //$this->send_notification_mail('verified:'.$uniqid);

		    //$this->send_notification_mail('verified post data : '.serialize($_POST));

		    $this->load->model('user/payment_model');

		    $order = $this->payment_model->get_post_payment_data_by_unique_id($uniqid);

		    

		    if($order->num_rows()>0)

		    {
		    	//$this->send_notification_mail('within valid order block:'.$order->package_id);
		    	
		    	$order 		= $order->row();

		    	$order_id 	= $order->id;

		    	$post_id 	= $order->post_id;


		    	$this->load->model('admin/package_model');

		    	
		    	$package = $this->package_model->get_package_by_id($order->package_id);

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


		    		if($txn_type=='web_accept')

		    		{
		    		

		    			$this->load->helper('date');

		    			$datestring = "%Y-%m-%d";

						$time = time();

		    			$activation_date = mdate($datestring, $time);

		    			$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);

		    			$expirtion_date = mdate($datestring, $expirtion_date);

		    			//$this->send_notification_mail('before update web accept : '.$expirtion_date);

		    			$data = array();

		    			$data['is_active'] 		 	= 1;

		    			$data['activation_date'] 	= $activation_date;

		    			$data['expiration_date'] 	= $expirtion_date;

		    			$data['response_log']		= 'Success package unique id:'.$uniqid;



		    			$this->payment_model->update_post_payment_data_by_unique_id($data,$uniqid);

		    			$this->load->model('user/post_model');

		    			if(isset($custom_val['renew']) && $custom_val['renew']=='renew') {

		    				

		    				if($this->post_model->increment_featured_date($package->expiration_time,$post_id)==TRUE)

		    					$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('feature_renewed').'</div>');

		    				else

		    					$this->session->set_flashdata('msg','<div class="alert alert-danger">Error! Feature not renewed.</div>');

		    			}

		    			else {

		    				$data = array();

		    				$data['featured_expiration_date'] 	= $expirtion_date;

		    				$data['featured']					= 1;

		    				$this->post_model->update_post($data,$post_id);



		    				$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_featured').'</div>');

		    			}



		    			$this->session->unset_userdata('feature_post_id');

		    			$this->session->unset_userdata('feature_post_type');



		    			$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('post_featured').'</div>');

		    			redirect(site_url('admin/business/allposts'));

		    			

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



	#send a payment confirmation email with confirmation link

	public function send_feature_payment_confirmation_email($data=array())

	{

		$val = get_admin_email_and_name();

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


	public function send_notification_mail($msg)
	{
		$this->load->helper('date');
		$datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
		$time = time();
		$this->load->library('email');
		$this->email->from('mmtpaypal@bookit.com', 'Paypal Test');
		$this->email->to('mekturjo@gmail.com');
		$this->email->subject('Paypal subscription('.mdate($datestring, $time).')');
		$this->email->message($msg);
		
		$this->email->send();
	}

}



/* End of file install.php */

/* Location: ./application/modules/user/controllers/user_core.php */