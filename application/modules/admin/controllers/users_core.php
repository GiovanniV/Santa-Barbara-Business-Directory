<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory users Controller
 *
 * This class handles users management related functionality
 *
 * @package		Admin
 * @subpackage	users
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Users_core extends CI_Controller {
	
	var $per_page = 3;
	
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_loggedin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
		$this->load->model('users_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	= $this->users_model->get_all_users_by_range($start,'id');
        $data['title'] 		= lang_key('users');
        $data['content'] 	= load_admin_view('users/allusers_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}


	public function ban_user($user_id=0, $page = 1)
	{
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
	        $this->users_model->ban_user($user_id);
	        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_banned').'</div>');
		}
        redirect(site_url('admin/users/all/' . $page));
    }

    public function unban_user($user_id=0, $page = 1)
    {
    	if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
	        $this->users_model->unban_user($user_id);
	        $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_unbanned').'</div>');
		}
        redirect(site_url('admin/users/all/' . $page));
    }

	public function detail($id)
	{
		$value['profile'] 	= $this->users_model->get_user_by_id($id);
        $data['title'] 		= lang_key('user_profile');
		$data['content'] 	= load_admin_view('users/detail_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

	public function banuser($page='0',$id='',$limit='')
	{
		$this->load->model('user/user_model');
		if($limit=='forever')
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->user_model->banuser($id,$limit);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_banned').'</div>');
			}

			redirect(site_url('admin/userdetail/'.$id));			
		}

		$this->form_validation->set_rules('limit',	'Limit', 'required|numeric|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->userdetail($id);	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$limit = $this->input->post('limit');
				$this->user_model->banuser($id,$limit);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_banned').'</div>');
			}
			redirect(site_url('admin/userdetail/'.$id));
		}
	}

	function exportemails()
	{
		$query = $this->users_model->get_all_user_emails();
		$this->load->dbutil();
		$data = $this->dbutil->csv_from_result($query); 

	    # Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download('userlist.csv', $data);	

	}

	function create()
	{
		$this->load->model('admin/users_model');
		$this->load->model('admin/package_model');
        $data['title'] 		= lang_key('create_user');
        $value['usertypes'] = $this->users_model->get_all_usertypes();
        $value['packages'] 	= $this->package_model->get_all_packages_by_range('all');
		$data['content'] 	= load_admin_view('users/createuser_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

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


	function add()
	{
		$this->form_validation->set_rules('user_email',lang_key('user_email'), 'required|xss_clean|callback_useremail_check');
		$this->form_validation->set_rules('user_name',lang_key('username'), 	'required|xss_clean|callback_username_check');
		$this->form_validation->set_rules('first_name',lang_key('first_name'), 'required|xss_clean');
		$this->form_validation->set_rules('last_name',lang_key('last_name'), 	'required|xss_clean');
		$this->form_validation->set_rules('user_type',lang_key('user_type'), 	'required|xss_clean');
		$this->form_validation->set_rules('password', lang_key('password'), 'required|matches[confirm_password]|min_length[5]|xss_clean');
		$this->form_validation->set_rules('confirm_password',lang_key('confirm_password'), 'required|xss_clean');
		$this->form_validation->set_rules('gender',lang_key('gender'), 	'required|xss_clean');

		$user_type = $this->input->post('user_type');
		if($user_type==2)
			$this->form_validation->set_rules('company_name','Company name', 'required|xss_clean');

		if(get_settings('business_settings','enable_pricing','No')=='Yes')
			$this->form_validation->set_rules('package','Package', 	'required|xss_clean');


		if ($this->form_validation->run() == FALSE)

		{
			
			$this->create();	

		}

		else

		{
			$this->load->helper('date');
			$this->load->library('encrypt');
			$datestring = "%Y-%m-%d";
			$time = time();
			$request_date = mdate($datestring, $time);

			$data = array();
			$data['user_type'] 		= $this->input->post('user_type');
			$data['first_name'] 	= $this->input->post('first_name');
			$data['last_name'] 		= $this->input->post('last_name');
			$data['gender'] 		= $this->input->post('gender');
			$data['user_name'] 		= $this->input->post('user_name');
			$data['user_email'] 	= $this->input->post('user_email');
			$data['confirmed'] 		= 1;
			$data['confirmed_date'] = $request_date;
			$data['status'] 		= 1;
			$data['password'] 		= $this->encrypt->sha1($this->input->post('password'));

			$this->load->model('admin/users_model');
			$user_id = $this->users_model->insert_user($data);

			if(get_settings('business_settings','enable_pricing','No')=='Yes')
			{
				$package_id = $this->input->post('package');
				$this->load->model('admin/package_model');
			    $package 	= $this->package_model->get_package_by_id($package_id);
				$datestring = "%Y-%m-%d";
				$time = time();
				$activation_date = mdate($datestring, $time);
				$expirtion_date  = strtotime('+'.$package->expiration_time.' days',$time);
				$expirtion_date = mdate($datestring, $expirtion_date);

				$payment_data 						= array(); 
				$payment_data['unique_id'] 			= uniqid();
				$payment_data['user_id'] 			= $user_id;
				$payment_data['package_id'] 		= $package->id;
				$payment_data['amount'] 			= $package->price;
				$payment_data['request_date'] 		= $request_date;
				$payment_data['is_active'] 			= 2; #pending
				$payment_data['status'] 			= 1; #active
				$payment_data['payment_medium']		= 'admin'; 
				$payment_data['is_active'] 		 	= 1;
				$payment_data['activation_date'] 	= $activation_date;
				$payment_data['expirtion_date'] 	= $expirtion_date;
				$payment_data['response_log']		= '';

				$this->load->model('user/user_model');
				$this->user_model->insert_payment_data($payment_data);


				add_user_meta($user_id,'current_package',$package->id);
				add_user_meta($user_id,'expirtion_date',$expirtion_date);
				add_user_meta($user_id,'active_order_id',$payment_data['unique_id']);
				add_user_meta($user_id,'company_name',$this->input->post('company_name'));
				add_user_meta($user_id,'post_count',0);		

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_created').'</div>');
			}
			redirect(site_url('admin/userdetail/'.$user_id));		

		}
	}

	public function profile_photo_uploader()
	{
		load_admin_view('users/profile_photo_uploader_view');
	}



	public function upload_profile_photo()
	{
		$date_dir = 'profile_photos/';
		$config['upload_path'] = './uploads/profile_photos/';
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';

		$this->load->library('upload', $config);
		$this->upload->display_errors('', '');	

		if($this->upload->do_upload('photoimg'))
		{

			$data = $this->upload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/profile_photos/'.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

			create_square_thumb('./uploads/profile_photos/'.$data['file_name'],'./uploads/profile_photos/thumb/');

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}
		else
		{
			$errors = $this->upload->display_errors();
			$errors = str_replace('<p>','',$errors);
			$errors = str_replace('</p>','',$errors);
			$status = array('error'=>$errors,'name'=>'');
		}

		echo json_encode($status);
		die;
	}

}

/* End of file users.php */
/* Location: ./application/modules/admin/controllers/admin.php */