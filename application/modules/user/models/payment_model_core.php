<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		User
 * @subpackage	UserModelCore
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */



class Payment_model_core extends CI_Model 

{

	function __construct()
	{

		parent::__construct();
		$this->load->database();
	}

	function insert_property_payment_data($data)
	{
		$this->db->insert('post_package',$data);
		return $data['unique_id'];
	}

	function get_post_payment_data_by_unique_id($unique_id)
	{
		$query = $this->db->get_where('post_package',array('unique_id'=>$unique_id));
		return $query;
	}

	function update_post_payment_data_by_unique_id($data,$unique_id)
	{
		$this->db->update('post_package',$data,array('unique_id'=>$unique_id));
	}

	function update_property_payment_data($invoice_id)
	{
		$query = $this->db->get_where('post_package',array('unique_id'=>$invoice_id));
		if($query->num_rows()>0)
		{
			$invoice = $query->row();
			$package_id = $invoice->package_id;

			$this->load->model('admin/package_model');
			$package = $this->package_model->get_package_by_id($package_id);

			$datestring = "%Y-%m-%d";
			$time = time();
			$activation_date = mdate($datestring, $time);
			$expiration_date  = strtotime('+'.$package->expiration_time.' days',$time);
			$expiration_date  = mdate($datestring, $expiration_date);

			$data = array();
			$data['activation_date'] = $activation_date;
			$data['expirtion_date'] = $expiration_date;
			$data['is_active'] = 1;

			$this->db->update('post_package',$data,array('unique_id'=>$invoice_id));


			$data = array();
			$data['estate_condition'] = 'DBC_CONDITION_NEW';
			$data['status'] = 1;
			$data['package_id'] = $package->id;
			$data['price'] = $package->price;
			$data['activation_date'] = $activation_date;
			$data['expiration_date'] = $expiration_date;
			$data['invoice_id'] = $invoice_id;

			$this->db->update('posts',$data,array('id'=>$invoice->post_id));

		}
	}
}



/* End of file install.php */
/* Location: ./application/modules/user/models/user_model_core.php */