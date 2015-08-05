<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory themes_model_core model
 *
 * This class handles themes_model_core management related functionality
 *
 * @package		Admin
 * @subpackage	themes_model_core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Themes_model_core extends CI_Model 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function activate()
	{
		$theme = $this->input->post('theme');
		add_option('active_theme',$theme);
	}

}

/* End of file themes_model_core.php */
/* Location: ./system/application/models/themes_model_core.php */