<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory admin Controller
 *
 * This class handles user account related functionality
 *
 * @package		Memento404
 * @subpackage	Memento404Core
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

class Show404_core extends CI_controller {

	var $active_theme = '';
	public function __construct()
	{
		parent::__construct();
		is_installed(); #defined in auth helper		
		$this->active_theme = get_active_theme();
	}

	public function index()
	{
		$this->output->set_status_header('404');
		$data['content'] 	= load_view('404_view','',TRUE);
        load_template($data,$this->active_theme,'template_view');
	}
	

}

/* End of file install.php */
/* Location: ./application/modules/show/controllers/memento404core.php */