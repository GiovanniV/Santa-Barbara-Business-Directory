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

require_once'users_core.php';

class Users extends Users_core {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
}

/* End of file users.php */
/* Location: ./application/modules/admin/controllers/users.php */