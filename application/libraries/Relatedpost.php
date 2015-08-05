<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class CI_Relatedpost {



	/**

	 * Constructor - Sets Email Preferences

	 *

	 * The constructor can be passed an array of config values

	 */

	public function __construct($config = array())

	{

	}



	public function get_related_posts($param = array())

	{

		$name = $param[0];

		echo 'Hello '.$name.'!!!';

	}





}

// END CI_Email class



/* End of file Email.php */

/* Location: ./system/libraries/Email.php */

