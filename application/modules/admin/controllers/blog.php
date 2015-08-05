<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BusinessDirectory blog Controller
 *
 * This class handles blog management related functionality
 *
 * @package		Admin
 * @subpackage	blog
 * @author		dbcinfotech
 * @link		http://dbcinfotech.net
 */

require_once'blog_core.php';

class Blog extends Blog_core {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	
}

/* End of file blog.php */
/* Location: ./application/modules/admin/controllers/blog.php */