<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory page Controller
 *
 * This class handles page management related functionality
 *
 * @package		Admin
 * @subpackage	Page
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Slider_core extends CI_Controller {
	
	var $per_page = 10;
	
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper
		checksavedlogin(); #defined in auth helper
		
		if(!is_admin())
		{
			if(count($_POST)<=0)
			$this->session->set_userdata('req_url',current_url());
			redirect(site_url('admin/auth'));
		}

		$this->per_page = get_per_page_value();#defined in auth helper

		$this->load->model('slider_model');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	}
	
	public function index()
	{
		$this->all();
	}

		#load all services view with paging
	public function all($start='0')
	{
		$value['posts']  	= $this->slider_model->get_all_posts_by_range('all',$this->per_page,'slide_order','asc');
		$total 				= $this->slider_model->count_all_posts();
		$value['pages']		= configPagination('admin/slider/all',$total,5,$total);
        $data['title'] 		= lang_key('all_slides');
        $data['content'] 	= load_admin_view('slider/allposts_view',$value,TRUE);
		load_admin_view('template/template_view',$data);		
	}


	public function manage($id='')
	{
		$values 		= array();
		$values['title'] = lang_key('new_slide');
		if($id!='')
		{
			$values['title']  		= lang_key('update_slide');
			$values['action_type']  = 'update';
			$values['page'] 		= $this->slider_model->get_post_by_id($id);
		}

        $data['content'] = load_admin_view('slider/post_view',$values,TRUE);
		load_admin_view('template/template_view',$data);			
	}


	public function add()
	{
		$this->form_validation->set_rules('title', lang_key('title'), 'required');
		$this->form_validation->set_rules('description', lang_key('description'), 'xss_clean');
		$this->form_validation->set_rules('featured_img', lang_key('featured_img'), 'required');
		
		if ($this->form_validation->run() == FALSE)
		{
			if($this->input->post('action_type')=='update')
				$this->manage($this->input->post('id'));
			else
				$this->manage();	
		}
		else
		{
			$data['featured_img'] 	= $this->input->post('featured_img');
			$data['slide_order'] 	= $this->input->post('slide_order');
			$data['title'] 			= $this->input->post('title');
			$data['description'] 	= $this->input->post('description');
			$data['created_by']		= $this->session->userdata('user_id');
			$data['create_time']	= time();
			$data['status']			= $this->input->post('action');
			

			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				if($this->input->post('action_type')=='update')
				{
					$id = $this->input->post('id');
					$this->slider_model->update_post($data,$id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_updated').'</div>');
				}
				else
				{
					$id = $this->slider_model->insert_post($data);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_created').'</div>');
				}				
			}	

			redirect(site_url('admin/slider'));		
		}

	}
	

	public function delete($page='0',$id='',$confirmation='')
	{
		if($confirmation=='')
		{
			$data['content'] = load_admin_view('confirmation_view',array('id'=>$id,'url'=>site_url('admin/slider/delete/'.$page)),TRUE);
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
					$this->slider_model->delete_post_by_id($id);
					$this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('data_deleted').'</div>');
				}
			}
			redirect(site_url('admin/slider/all/'.$page));		
			
		}		
	}

	public function saveorder()
	{
		if(isset($_POST['id']) && is_array($_POST['id']))
		{
			$i = 1;
			foreach ($_POST['id'] as $id) {
				$data['slide_order'] = $i;
				$this->slider_model->update_post($data,$id);
				$i++;
			}
		}
		$this->session->set_flashdata('msg','<div class="alert alert-success">'.lang_key('data_updated').'</div>');
		redirect(site_url('admin/slider'));
	}


	public function featuredimguploader()
	{
		 load_admin_view('slider/featured_img_uploader_view');
	}

	public function uploadfeaturedfile()
	{
		$date_dir = 'slider/';
		$config['upload_path'] = './uploads/'.$date_dir;
		$config['allowed_types'] = 'gif|jpg|JPG|png';
		$config['max_size'] = '5120';
		// $config['min_width'] = '256';
		// $config['min_height'] = '256';

		$this->load->library('dbcupload', $config);
		$this->dbcupload->display_errors('', '');	

		if($this->dbcupload->do_upload('photoimg'))
		{

			$data = $this->dbcupload->data();
			$this->load->helper('date');
			$format = 'DATE_RFC822';
			$time = time();
			//create_square_thumb('./uploads/'.$date_dir.$data['file_name'],'./uploads/thumbs/');

			$media['media_name'] 		= $data['file_name'];
			$media['media_url']  		= base_url().'uploads/'.$date_dir.$data['file_name'];
			$media['create_time'] 		= standard_date($format, $time);
			$media['status']			= 1;

			$status['error'] 	= 0;
			$status['name']	= $data['file_name'];
		}
		else
		{

			$errors = $this->dbcupload->display_errors();
			$errors = str_replace('<p>','',$errors);
			$errors = str_replace('</p>','',$errors);
			$status = array('error'=>$errors,'name'=>'');
		}

		echo json_encode($status);
		die;
	}
}

/* End of file page_core.php */
/* Location: ./application/modules/admin/controllers/page_core.php */