<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Santa Barbara admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Install
 * @subpackage	Install
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Install_core extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->is_installed();
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<div class="alert alert-error input-xxlarge">', '</div>');
	}
	
	/* 
	 * Read config.xml file to see 
	 * if bookit is already installed
	 * 
	 */
	function is_installed()
	{
		$file 	= './dbc_config/config.xml';
	   	$xmlstr = file_get_contents($file);
		$xml 	= simplexml_load_string($xmlstr);
		$config	= $xml->xpath('//config');	
		if($config[0]->is_installed=='yes' && $this->uri->segment(2)!='complete')
			redirect(site_url('admin/auth'));
	}
	
	public function index()
	{
		$data['content'] = $this->load->view('check_config_view','',TRUE);	
		$this->load->view('template_view',$data);
	}
	
	public function dbsetup()
	{
		$data['content'] = $this->load->view('dbsetup_view','',TRUE);	
		$this->load->view('template_view',$data);
	}
	
	/*
	 * Save database settings
	 * Modify application/config/database.php
	 */
	public function savedbsettings()
	{
		ini_set('max_execution_time', 3600);
		$this->form_validation->set_rules('db_host', 	'Db Host', 			'required|xss_clean');
		$this->form_validation->set_rules('db_user', 	'Db User', 			'required|xss_clean');
		$this->form_validation->set_rules('db_pass', 	'Db Password', 		'xss_clean');
		$this->form_validation->set_rules('db_name', 	'Db Name', 			'required|xss_clean');
		$this->form_validation->set_rules('db_prefix', 	'Db Table Prefix', 	'required|xss_clean');
			
		if ($this->form_validation->run() == FALSE)
		{
			$this->dbsetup();	
		}
		else
		{
			if($this->check_db_connection()=="DBCONNFAIL")
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-error">Can not connect using provided settings</div>');
				redirect(site_url('install/dbsetup'));
			}
			else if($this->check_db_connection()=="DBNOTEXIST")
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-error">Can not select Database</div>');
				redirect(site_url('install/dbsetup'));
			}
			else if($this->check_db_connection()=="SUCCESS")
			{
				$this->load->helper('file');
				$data = read_file('./application/config/database-setup.php');
				#replace pre installation tag on application/config/database.php file
				$data = str_replace('db_name',	$this->input->post('db_name'),	$data);
				$data = str_replace('db_user',	$this->input->post('db_user'),	$data);
				$data = str_replace('db_pass',	$this->input->post('db_pass'),	$data);						
				$data = str_replace('db_host',	$this->input->post('db_host'),	$data);
			    $data = str_replace('db_prefix',$this->input->post('db_prefix'),$data);

				if ( ! write_file('./application/config/database.php', $data))
				{
					$this->session->set_flashdata('msg', '<div class="alert alert-error">Unable to write the file.Please check your directory permission</div>');
				}

				$this->load->database();
				#read default db sql file , parse all queries and run them
				$schema = read_file('./dbc_config/Santa Barbara.sql');
				
				$schema = str_replace('db_tabprefix',$this->input->post('db_prefix'),$schema);
				$schema = str_replace('BASE_URL',base_url(),$schema);

				$query = rtrim( trim($schema), "\n;");
				$query_list = explode(";", $query);
							
				foreach($query_list as $query)
				{
				 	$this->db->query($query);
				}

				redirect(site_url('install/accountsetup'));
			}
		}
	}
	
	/*
	 * function for checking if provided db
	 * settings are ok or not
	 */
	public function check_db_connection()
	{
		$link = @mysql_connect($this->input->post('db_host'),$this->input->post('db_user'),$this->input->post('db_pass'));
		if (!$link) {
		  @mysql_close($link);
		  return "DBCONNFAIL";
		}
		$db_selected = mysql_select_db($this->input->post('db_name'), $link);
		if (!$db_selected) {
		  @mysql_close($link);
		  return "DBNOTEXIST";
		}
		
		@mysql_close($link);
		return "SUCCESS";
	}
	
	public function accountsetup()
	{
		$data['content'] = $this->load->view('accountsetup_view','',TRUE);	
		$this->load->view('template_view',$data);
	}

	public function saveaccountsettings()
	{
		$this->form_validation->set_rules('user_name', 	'Username', 		'required|min_length[5]|xss_clean');
		$this->form_validation->set_rules('user_email',	'User email', 		'required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 	'Password', 		'required|matches[re_password]|min_length[5]|xss_clean');
		$this->form_validation->set_rules('re_password','Retype Password', 	'required|xss_clean');
		$this->form_validation->set_rules('enc_key','Encription Key', 		'required|min_length[3]|xss_clean');
		
		if ($this->form_validation->run() == FALSE)
		{
			$this->accountsetup();	
		}
		else
		{
			$this->load->helper('file');
			$data = read_file('./application/config/config-setup.php');
			$data = str_replace('enc_key',	$this->input->post('enc_key'),	$data);

			if ( ! write_file('./application/config/config.php', $data))
			{
					$this->session->set_flashdata('msg', '<div class="alert alert-error">Unable to write the file.Please check your directory permission</div>');
					redirect(site_url('install/saveaccountsettings'));
			}
			

			$this->load->database();
			$this->load->library('encrypt');
			
			$userdata['user_name'] 	= $this->input->post('user_name');
			$userdata['first_name'] 	= $this->input->post('first_name');
			$userdata['last_name'] 	= $this->input->post('last_name');
			$userdata['gender'] 	= $this->input->post('gender');
			$userdata['user_email'] = $this->input->post('user_email');
			$userdata['confirmed']  = 1;
			$userdata['user_type']  = 1;
			$userdata['status']  	= 1;
			$userdata['password'] 	= $this->encrypt->sha1($this->input->post('password'));
			$this->db->insert('users',$userdata);

			$file = './dbc_config/config.xml';
    	
    		$xmlstr = file_get_contents($file);
			$xml = simplexml_load_string($xmlstr);
			$xml->is_installed = 'yes';
			file_put_contents($file, $xml->asXML());
			
			redirect(site_url('install/complete'));
		}
	}
	
	public function complete()
	{
		$data['content'] = $this->load->view('complete_view','',TRUE);	
		$this->load->view('template_view',$data);	
	}
}

/* End of file install.php */
/* Location: ./application/modules/install/controllers/install_core.php */