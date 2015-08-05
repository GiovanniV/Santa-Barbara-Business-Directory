<?php

	$error_flag = 0;

	$files = array(	'user_uploads','user_uploads/plugins','user_uploads/plugins/tmp','uploads',
					'uploads/profile_photos','uploads/profile_photos/thumb','uploads/banner','uploads/gallery','uploads/images','uploads/slider','uploads/thumbs',
					'dbc_config','application/config/database.php',
					'application/config/config.php', 'dbc_config/config.xml',
					'application/modules/widgets');

	$error = '';



	foreach ($files as $file) 

	{

		if(is_writable($file)==FALSE)

		{

			$error_flag = 1;

			$error .= '<div class="alert alert-error">SITE_ROOT/'.$file.' is not writable.Please change it\'s permission before installing Whiz[ERROR].</div>';

		}

		else

		{

			$error .= '<div class="alert alert-success">SITE_ROOT/'.$file.' is writable.[OK]</div>';			

		}

	}





	if (extension_loaded('gd') && function_exists('gd_info')) 

	{

		$error .= '<div class="alert alert-success"> GD/GD2 library is installed[OK].</div>';

	}

	else

	{

		$error_flag = 1;

		$error .= '<div class="alert alert-error">GD library is not installed[ERROR].</div>';		

	}



	if(function_exists('curl_version'))

	{

		$error .= '<div class="alert alert-success">CURL is enabled[OK].</div>';

	}

	else

	{

		$error_flag = 1;

		$error .= '<div class="alert alert-error">CURL is not enabled[ERROR].</div>';

	}



	$wrappers = stream_get_wrappers();

	if(in_array('https',$wrappers))

	{

		$error .= '<div class="alert alert-success">HTTPS wrapper is enabled[OK].</div>';

	}

	else

	{

		$error_flag = 1;

		$error .= '<div class="alert alert-error">HTTPS wrapper is not enabled[ERROR].</div>';

	}



	if ( function_exists( 'mail' ) )

	{

		$error .= '<div class="alert alert-success">MAIL() function is enabled[OK].</div>';

	}

	else

	{

		//$error_flag = 1;

		$error .= '<div class="alert alert-error">MAIL() function is not enabled[ERROR].</div>';

	}





	if(function_exists('fsockopen')) 

	{

		$error .= '<div class="alert alert-success">fsockopen() function is enabled[OK].</div>';

	}

	else

	{

		$error .= '<div class="alert alert-warning">fsockopen() function is not enabled[WARNING].</div>';

	}



	echo $error;



	if($error_flag == 0)

	{

		?>

		<p class="lead">Everything seems to be ok. Let's install Whiz with in 2 easy step :-)</p>

		<ol>

			<li>Database setup</li>

			<li>Account setup</li>

		</ol>

		<a class="btn btn-success" href="<?php echo site_url('install/dbsetup');?>">Continue</a> to the next step.</p>

		<?php

	}

?>

