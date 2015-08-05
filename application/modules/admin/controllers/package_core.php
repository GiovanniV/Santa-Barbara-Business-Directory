<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory memento Controller
 *
 * This class handles only memento related functionality
 *
 * @package		Admin
 * @subpackage	Memento
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */


class Package_core extends CI_Controller {
	var $per_page = 10;
		
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin() && $this->session->userdata('user_type')!=3)
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper
		$this->load->helper('text');
		$this->load->model('admin/business_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

	#get and display package informations
	public function all() 
	{
		$this->load->model('admin/package_model');
		$value['packages']	= $this->package_model->get_all_packages_by_range('all');
		$data['title'] 		= lang_key('packages');
		$data['content'] 	= load_admin_view('packages/packages_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	#load new package page
	function newpackage()
	{
        $data['title'] = lang_key('create_new_package');
        $data['content'] = load_admin_view('packages/create_package_view','',TRUE);
		load_admin_view('template/template_view',$data);
	}


	#add package information to the database
	function addpackage()
	{
		$this->form_validation->set_rules('type', lang_key('type'), 'required');
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('price', lang_key('price'), 'required|numeric');
		$this->form_validation->set_rules('expiration_time', lang_key('expiration_time'), 'required|numeric');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->newpackage();	
		}
		else
		{
			$data 						= array();			
			$data['type'] 				= $this->input->post('type');
			$data['title'] 				= $this->input->post('title');
			$data['description'] 		= $this->input->post('description');
			$data['price'] 				= $this->input->post('price');
			$data['expiration_time'] 	= $this->input->post('expiration_time');
			$data['status']				= 1;
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->load->model('package_model');
				$id = $this->package_model->insert_package($data);
				if($id>0) 
				{

					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('package_created').'</div>');
				}
				else 
				{

					$this->session->set_flashdata('msg', '<div class="alert alert-success">Error occured package could not be created</div>');	
				}
			}

			redirect(site_url('admin/package/newpackage'));		
		}

	}

	#remove a single package by its id
	public function remove_package($id) {

		if(!isset($id))
			redirect(site_url('admin/package/all'));

		$this->load->model('admin/package_model');

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$data['status'] = 0;
			$this->package_model->update_package($data,$id);
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('package_removed').'</div>');
		}

		redirect(site_url('admin/package/all'));
	}

	#delete multiple packages
	public function remove_bulk_packages()
	{
		$this->load->model('admin/package_model');

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$data['status'] = 0;
			$this->package_model->bulk_update_packages($data,$this->input->post('id'));
			$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('package_removed').'</div>');
		}		
		redirect(site_url('admin/package/all'));			
	}

	#load edit package view
	public function edit_package($id='')
	{
		if(!isset($id) || $id=='') 
		{
			redirect(site_url('admin/package/all'));
		}

		$this->load->model('admin/package_model');

		$value['post']  = $this->package_model->get_package_by_id($id);
		$data['title'] 	= lang_key('edit_package');
		$data['content'] = load_admin_view('packages/edit_package_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}

	#update a package
	public function updatepackage()
	{
		$this->form_validation->set_rules('type', lang_key('type'), 'required');
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('price', lang_key('price'), 'required|numeric');
		$this->form_validation->set_rules('expiration_time', lang_key('expiration_time'), 'required|numeric');
		
		if ($this->form_validation->run() == FALSE)
		{
			$id = $this->input->post('id');
			$this->edit_package($id);
			return;
		}
		else
		{
			$this->load->model('admin/package_model');
			$id = $this->input->post('id');

			$data 						= array();			
			$data['type'] 				= $this->input->post('type');
			$data['title'] 				= $this->input->post('title');
			$data['description'] 		= $this->input->post('description');
			$data['price'] 				= $this->input->post('price');
			$data['expiration_time'] 	= $this->input->post('expiration_time');			
			
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$this->package_model->update_package($data,$id);
				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('package_updated').'</div>');
			}	
			
			redirect(site_url('admin/package/edit_package/'.$id));		
		}
	}

	public function settings($key='package_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		$settings = $this->options_model->getvalues($key);
		$settings = json_encode($settings);		
		$value['settings'] 	= $settings;
	    $data['title'] 		= lang_key('package_settings');
        $data['content']  	= load_admin_view('packages/settings_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}

	#save site settings

	public function savesettings($key='package_settings')
	{
		if(!is_admin())
		{
			echo lang_key('dont_have_permission');
			die;
		}

		$this->load->model('admin/system_model');
		$this->load->model('options_model');

		foreach($_POST as $k=>$value)
		{
			$rules = $this->input->post($k.'_rules');
			if($rules!='')
			$this->form_validation->set_rules($k,$k,$rules);
		}

		
		if ($this->form_validation->run() == FALSE)
		{
			$this->settings($key);	
		}
		else
		{	
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$data['values'] 	= json_encode($_POST);		
				$res = $this->options_model->getvalues($key);
				if($res=='')
				{
					$data['key']	= $key;			
					$this->options_model->addvalues($data);
				}
				else
					$this->options_model->updatevalues($key,$data);

				$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
			}
			redirect(site_url('admin/package/settings/'.$key));		
		}			
	}

}

/* End of file memento_core.php */
/* Location: ./application/modules/admin/controllers/memento_core.php */