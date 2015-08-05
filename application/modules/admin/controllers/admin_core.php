<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Admin
 * @subpackage	Admin
 * @author		sc mondal
 * @link		http://dbcinfotech.net
 *
 */





class Admin_core extends CI_Controller {

	var $per_page = 10;

	

	public function __construct()
	{
		parent::__construct();

		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper

		if(!is_admin() && !is_agent())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
		$this->load->model('admin_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}

	public function index()
	{
		if(!is_admin())
		{
			redirect(site_url('admin/business'));
		}

		$this->home();	
	}

	

	public function home($start=0,$sort_by='add_time')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

        $data['title'] 		= lang_key('dashboard');
		$data['content'] 	= load_admin_view('template/dashboard_view','',TRUE);
		load_admin_view('template/template_view',$data);

	}

	# load profile edit view
	public function editprofile()
	{
		$value['profile']	= $this->admin_model->get_user_profile($this->session->userdata('user_name'));

		$data['title']		= lang_key('edit_profile');
		$data['content'] 	= load_admin_view('profile/editprofile_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	public function edituser($user_id='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$value['action']	= 'edituser';

		$value['profile']	= $this->admin_model->get_user_profile_by_id($user_id);
		$data['title']		= lang_key('edit_user');
		$data['content'] 	= load_admin_view('profile/editprofile_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	
	#recovery email validation function
	public function useremail_check($str)
	{
		$this->load->model('account/auth_model');
		$id = $this->input->post('id');
		$res = $this->auth_model->is_email_exists_for_edit($str,$id);
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
		$this->load->model('account/auth_model');
		$id 	= $this->input->post('id');
		$res 	= $this->auth_model->is_username_exists_for_edit($str,$id);

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


	#update profile 
	public function updateprofile()
	{

        $this->form_validation->set_rules('first_name',	'First Name', 		'required|xss_clean');
        $this->form_validation->set_rules('last_name',	'last Name', 		'required|xss_clean');
        $this->form_validation->set_rules('gender',		'Gender', 			'required|xss_clean');


		$this->form_validation->set_rules('user_name', 	'Username', 		'required|callback_username_check|xss_clean');
        $this->form_validation->set_rules('user_email', 	'Email', 		'required|valid_email|callback_useremail_check|xss_clean');

        if($this->input->post('password')!='' || $this->input->post('confirm_password')!='')
        	$this->form_validation->set_rules('password', 'Password', 'required|matches[confirm_password]|min_length[5]|xss_clean');



		if ($this->form_validation->run() == FALSE)
		{
			$action = $this->input->post('action');
			$id = $this->input->post('id');

			if($action=='editprofile')
			$this->editprofile($id);	
			else
			$this->edituser($id);	
		}
		else
		{
			$id = $this->input->post('id');
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				redirect(site_url('admin/editprofile/'.$id));	
			}
			else
			{
				$userdata['profile_photo'] 	= $this->input->post('profile_photo');
	            $userdata['first_name'] 	= $this->input->post('first_name');
	            $userdata['last_name'] 		= $this->input->post('last_name');
	            $userdata['gender'] 		= $this->input->post('gender');
	            $userdata['user_name'] 		= $this->input->post('user_name');
                $userdata['user_email'] 	= $this->input->post('user_email');

                if($this->input->post('password')!='') 
                {
                	$this->load->library('encrypt');
                	$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
                }


	            add_user_meta($id,'company_name',$this->input->post('company_name'));
	            add_user_meta($id,'phone',$this->input->post('phone'));
	            add_user_meta($id,'about_me',$this->input->post('about_me'));
	            add_user_meta($id,'fb_profile',$this->input->post('fb_profile'));
	            add_user_meta($id,'twitter_profile',$this->input->post('twitter_profile'));
	            add_user_meta($id,'li_profile',$this->input->post('li_profile'));
	            add_user_meta($id,'gp_profile',$this->input->post('gp_profile'));
	            add_user_meta($id,'hide_email',$this->input->post('hide_email'));
	            add_user_meta($id,'hide_phone',$this->input->post('hide_phone'));

				$this->admin_model->update_profile($userdata,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');

				$action = $this->input->post('action');

				if($action=='editprofile')
					redirect(site_url('admin/editprofile/'.$id));		
				else
					redirect(site_url('admin/edituser/'.$id));		
			}
		}

	}



	#users functions
	public function allusers($start=0)
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('user/user_model');
		$value['users']  	= $this->user_model->get_all_users_by_range($start,$this->per_page,'id');
		$total 				= $this->user_model->count_all_users();
		$value['pages']		= configPagination('admin/allusers',$total,3,$this->per_page);	
		$data['content'] 	= load_admin_view('users/allusers_view',$value,TRUE);		
		load_admin_view('template/template_view',$data);

	}



	public function userdetail($id='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('user/user_model');
		$value['total_posts'] 	= $this->user_model->count_all_user_posts($id);
		$value['profile']		= $this->user_model->get_user_profile_by_id($id);  
		$data['content'] 		= load_admin_view('users/detail_view',$value,TRUE);
		load_admin_view('template/template_view',$data);

	}

	#delete a user
	public function deleteuser($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/deleteuser/'.$page)),TRUE);
			load_admin_view('template/template_view',$data);
		}
		else
		{
			if($confirmation=='yes')
			{
				if(constant("ENVIRONMENT")=='demo')
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
				}
				else
				{
					$this->load->model('user/user_model');
					$this->user_model->delete_user_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_deleted').'</div>');
				}
			}
			redirect(site_url('admin/users/all/'.$page));		
		}		

	}



	#make moderator a user

	public function makemoderator($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');

			$this->user_model->update_user_by_id(array('user_type'=>3),$id);

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');
		}				

		redirect(site_url('admin/users/all/'.$page));				

	}



	#make moderator a user

	public function removemoderator($page='0',$id='',$confirmation='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');

			$this->user_model->update_user_by_id(array('user_type'=>2),$id);

			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_updated').'</div>');
		}		

		redirect(site_url('admin/users/all/'.$page));				

	}



	#confirm a user

	public function confirmuser($page='0',$id='',$confirmation='')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->load->model('user/user_model');
			$this->user_model->confirm_user_by_id($id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('user_confirmed').'</div>');
		}		
		redirect(site_url('admin/users/all/'.$page));				
	}


	public function banuser($id='',$limit='')
	{

		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}
		
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

}



/* End of file admin_core.php */
/* Location: ./application/modules/admin/controllers/admin_aore.php */