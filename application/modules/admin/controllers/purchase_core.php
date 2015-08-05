<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory Purchase Controller
 *
 * This class handles Purchase management related functionality
 *
 * @package		Admin
 * @subpackage	Purchase
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Purchase_core extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}
	 
	public function index()
	{
		$this->regdomain();
	}
	
	function regdomain()
	{
		$this->session->set_userdata('form_key',rand(1,500));
		$data = array('error'=>'<div class="alert alert-danger" style="margin-top:10px;">'.lang_key('login_failed').'</div>');
		load_admin_view('regdomain_view',$data);		
	}

	public function addkey()
	{
		if($this->input->post('form_key')==$this->session->userdata('form_key'))
		{
			//set POST variables
			$url = get_author_url().'admin/verify/checkpurchasekey';
			$fields = array(
								'purchase_key' => urlencode($this->input->post('purchase_key')),
								'item_id' => urlencode($this->input->post('item_id')),
								'domain' => urlencode($this->input->post('domain')),
								'item'		=> 'Santa Barbara'
							);

			$fields_string = '';
			//url-ify the data for the POST
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			//open connection
			$ch = curl_init();

			//set the url, number of POST vars, POST data
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 			
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

			//execute post
			$result = curl_exec($ch);
			curl_close($ch);

			if($result==='1')
			{

				$this->load->helper('file');
				$data = md5(urlencode($this->input->post('purchase_key')).'-'.urlencode($this->input->post('item_id')).'-'.urlencode($this->input->post('domain')));
				if ( ! write_file('./dbc_config/local-data.conf', $data))
				{
				     echo 'Unable to write the file';
				     $this->session->set_flashdata('msg', '<div class="alert alert-danger">Unable to write the file ROOT/dbc_config/local-data.conf</div>');
					redirect(site_url('admin/purchase/regdomain'));
				}

				add_option('purchase_key',$this->input->post('purchase_key'));
				add_option('item_id',$this->input->post('item_id'));
				$this->session->set_flashdata('msg', '<div class="alert alert-success">Purchase code verified. Please login now</div>');
				redirect(site_url('admin/auth/'));


			}
			elseif($result==='0')
			{				
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Puchase code or item id is not valid. Please try again.</div>');
				redirect(site_url('admin/purchase/regdomain'));
			}
			else
			{
				$this->session->set_flashdata('msg', '<div class="alert alert-danger">Failed to connect with DBCinfotech.</div>');
				redirect(site_url('admin/purchase/regdomain'));
			}
						
		}
	}
}

/* End of file purchase.php */
/* Location: ./application/modules/admin/controllers/purchase.php */