<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory Widgets Controller
 *
 * This class handles Widgets management related functionality
 *
 * @package		Admin
 * @subpackage	Widgets
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Widgets_core extends CI_Controller {
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

		$this->load->model('admin/widget_model');
		$this->load->helper('inflector');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');		
	}
	 
	public function index()
	{
		$this->all();
	}
	
	public function all()
	{
		$value['widgets'] 			= $this->widget_model->get_all_widgets_by_range('all','','');
        $data['title'] 				= lang_key('all_widgets');

        $data['content']  			= load_admin_view('widgets/allwidgets_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
	
	#load all plugins view
	public function widgetpositions($selected_pos='')
	{
		$positions					= get_option('positions');
		$value['positions'] 		= json_decode($positions->values);
		if($selected_pos=='')
		$selected_pos 				= ($this->input->post('position')=='')?$value['positions'][0]->name:$this->input->post('position');
		$value['selected_pos'] 		= $selected_pos;
		$value['active_widgets'] 	= get_widgets_by_position($selected_pos);
		$value['widgets'] 			= $this->widget_model->get_all_widgets_by_range('all','','');
        $data['title'] = 'Widget Position';
        $data['content']  			= load_admin_view('widgets/widgetpositions_view',$value,TRUE);
		load_admin_view('template/template_view',$data);
	}
	
	public function savewidgetpositions()
	{
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$positions = get_option('positions');
			$positions = json_decode($positions->values);

			foreach ($positions as $position) 
			{
				if($position->name==$this->input->post('position'))
				{
					$position->widgets = $this->input->post('widget');
				}
			}
			update_option('positions',$positions);
			$this->session->set_flashdata('msg','<div class="alert alert-info">'.lang_key('widget_position_updated').'</div>');
		}

		redirect(site_url('admin/widgets/widgetpositions/'.$this->input->post('position')));
	}

	public function edit($alias='')
	{
		$data['widget'] = $this->widget_model->get_widget_by_alias($alias);
		load_admin_view('widgets/editwidget_view',$data);
	}

	public function savewidget()
	{
		$alias = $this->input->post('alias');

		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			
			$this->load->helper('file');
			$data = $this->input->post('data');

			if ( ! write_file('./application/modules/widgets/'.$alias.'.php', $data))
			{
			     $this->session->set_flashdata('msg', '<div class="alert alert-error">'.lang_key('unable_to_write_widget').'</div>');
			}
			else
			{
			     $this->session->set_flashdata('msg', '<div class="alert alert-success">'.lang_key('widget_data_updated').'</div>');
			}			
		}
		redirect(site_url('admin/widgets/edit/'.$alias));
	}

	#change a widget status
	public function setstatus($alias='',$status=1)
	{
		if(constant("ENVIRONMENT")=='demo')
		{
			$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
		}
		else
		{
			$this->widget_model->set_widget_status($alias,$status);
			$this->session->set_flashdata('msg','<div class="alert alert-info">'.lang_key('settings_updated').'</div>');
		}
		redirect(site_url('admin/widgets/all'));
	}

	public function create()
	{
		$this->form_validation->set_rules('name',lang_key('name'),'required|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->all();	
		}
		else
		{
			if(constant("ENVIRONMENT")=='demo')
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Data updated.[NOT AVAILABLE ON DEMO]</div>');
			}
			else
			{
				$data['name'] 	= $this->input->post('name');
				$data['status'] = 0;
				$this->widget_model->create_widget($data);
				$this->session->set_flashdata('msg','<div class="alert alert-info">'.lang_key('widget_created').'</div>');
			}
			redirect(site_url('admin/widgets/all'));
		}
	}
	
}

/* End of file widgets.php */
/* Location: ./application/modules/admin/controllers/widgets.php */