<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



if ( ! function_exists('is_installed'))

{

	function is_installed($type='redirect')

	{



		if(!defined('IS_INSTALLED'))

		{

			$CI = get_instance();

			$file 		= './dbc_config/config.xml';

		   	$xmlstr 	= file_get_contents($file);

			$xml 		= simplexml_load_string($xmlstr);

			$config		= $xml->xpath('//config');

			$is_installed = $config[0]->is_installed;

			

			if(!defined('IS_INSTALLED'))

				define('IS_INSTALLED',$is_installed);

		}



		if(constant('IS_INSTALLED')=='no')

		{			

			if($type=='redirect')

			redirect(site_url('install'),'refresh');

			else

			return 'no';

		}

		else

		{

			if($type!='redirect')

			return 'yes';



		}

	}

}





if ( ! function_exists('dbc_url_title'))

{

	function dbc_url_title($str, $separator = 'dash', $lowercase = FALSE)

	{



		if ($separator == 'dash')

		{

			$search		= '_';

			$replace	= '-';

		}

		else

		{

			$search		= '-';

			$replace	= '_';

		}



		$trans = array(

						'&\#\d+?;'				=> '',

						'&\S+?;'				=> '',

						'\s+'					=> $replace,

						$replace.'+'			=> $replace,

						$replace.'$'			=> $replace,

						'^'.$replace			=> $replace,

						'\.+$'					=> ''

					);



		$str = strip_tags($str);



		foreach ($trans as $key => $val)

		{

			$str = preg_replace("#".$key."#i", $val, $str);

		}



		if ($lowercase === TRUE)

		{

			$str = strtolower($str);

		}



        $str = str_replace('&','and',$str);

        $str = str_replace(' ','-',$str);

        $str = str_replace('/','-',$str);

        $str = str_replace('?','-',$str);



		return trim(stripslashes($str));

	}

}





if ( ! function_exists('default_lang'))

{

	function default_lang()

	{

		if(is_installed('return')!='no')

		{

			if(defined('DEFAULT_LANG'))

			{

				return constant('DEFAULT_LANG');

			}

			else

			{	

				if(is_installed('return')=='yes')

				{

					$CI = get_instance();

					$CI->load->database();

					$query 		= $CI->db->get_where('options',array('key'=>'site_settings'));		

					if($query->num_rows()>0)

					{

						$row = $query->row();

						$settings = json_decode($row->values);

						$default_lang = $settings->site_lang;			

					}

					else

						$default_lang = 'en';



					if(!defined('DEFAULT_LANG'))

						define('DEFAULT_LANG',$default_lang);

					return $default_lang;											

				}		

				else

					return 'en';

			}

		}

		else

			return 'en';

	}

}



if ( ! function_exists('get_site_logo'))

{

	function get_site_logo($return_type='link')

	{

		$logo = get_settings('site_settings','site_logo',base_url('assets/images/logo/logo-default.png'));



		if ($logo == '')

		{

			if($return_type=='link')

			$logo = base_url('assets/images/logo/logo-default.png');

			else

			$logo = 'logo-default.png';

		}

		else

		{

			if($return_type=='link')

			$logo = base_url('assets/images/logo/'.$logo);

			else

			$logo = $logo;

		}

		return $logo;

	}

}



if ( ! function_exists('get_author_url'))

{

	function get_author_url()

	{		

		return 'http://dbcinfotech.net/app/envato/index.php/';

	}

}



if ( ! function_exists('get_current_page'))

{

	function get_current_page()

	{

		$uri =  uri_string();

		$segements = explode('/',$uri);

		$i=0;

		$url = '';

		foreach ($segements as $seg) {

			if($i>0)

			{

				$url .= $seg.'/';

			}

			$i++;

		}



		$CI = get_instance();

		$CI->load->model('show/show_model');

		$query = $CI->show_model->get_page_by_url(rtrim($url,"/"));

		if($query->num_rows()>0)

			return $query->row_array();

		else

			return array('error'=>'page_not_found');

	}

}



if ( ! function_exists('get_user_title_by_id'))

{

	function get_user_title_by_id($id)

	{

		$CI = get_instance();

		$CI->load->database();

		$query = $CI->db->get_where('users',array('id'=>$id));

		if($query->num_rows()>0)

		{

			$row = $query->row();

			if($row->first_name!='')

				return $row->first_name;

			else

				return $row->user_name;

		}

		else

			return 'N/A';

	}

}





if ( ! function_exists('get_user_type_by_id'))

{

	function get_user_type_by_id($id)

	{

		if($id==1)

			return lang_key('admin');

		elseif($id==2)

			return lang_key('business');

		elseif($id==3)

			return lang_key('individual');

	}

}



if ( ! function_exists('get_user_email_by_id'))

{

    function get_user_email_by_id($id)

    {

        $CI = get_instance();

        $CI->load->database();

        $query = $CI->db->get_where('users',array('id'=>$id));

        if($query->num_rows()>0)

        {

            $row = $query->row();

            return $row->user_email;

        }

        else

            return 'N/A';

    }

}



if ( ! function_exists('get_user_fullname_by_id'))

{

    function get_user_fullname_by_id($id)

    {

        $CI = get_instance();

        $CI->load->database();

        $query = $CI->db->get_where('users',array('id'=>$id));

        if($query->num_rows()>0)

        {

            $row = $query->row();

            if($row->first_name!='')

                return $row->first_name.' '.$row->last_name;

            else

                return $row->user_name;

        }

        else

            return '';

    }

}



if ( ! function_exists('get_user_fullname_by_username'))

{

    function get_user_fullname_by_username($username)

    {

        $CI = get_instance();

        $CI->load->database();

        $query = $CI->db->get_where('users',array('user_name'=>$username));

        if($query->num_rows()>0)

        {

            $row = $query->row();

            if($row->first_name!='')

                return $row->first_name.' '.$row->last_name;

            else

                return $row->user_name;

        }

        else

            return 'N/A';

    }

}



if ( ! function_exists('is_banned'))

{

	function is_banned($user_email)

	{

		$CI = get_instance();

		$CI->load->database();

		$query = $CI->db->get_where('users',array('user_email'=>$user_email));

		if($query->num_rows()>0)

		{

			$row = $query->row();

			if($row->banned==1)

				return TRUE;

			else

				return FALSE;

		}

		else

			return TRUE;

	}

}



if ( ! function_exists('is_loggedin'))

{

	function is_loggedin()

	{

		$CI = get_instance();

		if($CI->session->userdata('user_name')=='')

			return FALSE;

		else

			return TRUE;

	}

}



if ( ! function_exists('is_admin'))

{

	function is_admin()

	{

		$CI = get_instance();

		if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==1)

			return TRUE;

		else

			return FALSE;

	}

}



if ( ! function_exists('is_agent'))

{

	function is_agent()

	{

		$CI = get_instance();

		if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==2)

			return TRUE;

		else if($CI->session->userdata('user_name')!='' && $CI->session->userdata('user_type')==3)

			return TRUE;

		else

			return FALSE;

	}

}



if ( ! function_exists('check_config'))

{

	function check_config()

	{

		$files = array('user_uploads','user_uploads/plugins','dbc_config','application/config/database.php');

		$error = '';



		foreach ($files as $file) 

		{

			if(is_writable($file)==FALSE)

			{

				$error .= '<div class="alert alert-error">SITE_ROOT/'.$file.' is not writable.Please change it\'s permission before installing bookit.</div>';

			}

		}



		return $error;

	}

}



if ( ! function_exists('get_site_title'))

{

	function get_site_title()

	{

		$CI = get_instance();

		$CI->load->database();

		$query = $CI->db->get_where('options',array('key'=>'site_settings'));		

		if($query->num_rows()>0)

		{

			$row = $query->row();

			$values = json_decode($row->values);

			if(isset($values->site_title))

				return $values->site_title;

			else

				return 'Bookit';

		}

		else

			return 'Bookit';

	}

}



if ( ! function_exists('get_per_page_value'))

{

	function get_per_page_value()

	{

		return get_settings('site_settings','per_page',20);		

	}

}



if ( ! function_exists('translate'))

{

	function translate($html='')

	{

		preg_match_all("^\[(.*?)\]^",$html,$fields, PREG_PATTERN_ORDER);

		foreach ($fields[1] as $key) 

		{

			$res = lang_key($key);

			$html = str_replace('['.$key.']',$res,$html);

		}



		return $html;



	}

}





if ( ! function_exists('lang_key'))

{

	function lang_key($key='')

	{

		if(defined('LANG_ARRAY'))

		{

			$lang = (array)json_decode(constant('LANG_ARRAY'));

			if(isset($lang[$key]))

				return $lang[$key];

			else {

				if(constant("ENVIRONMENT")=='development') {



					$myfile = fopen("missing_lang.txt", "a") or die("Unable to open file!");

					$txt = $key."\n";

					fwrite($myfile, $txt);

					fclose($myfile);

				}

				return $key;

			}				

		}

		else

		{

			$CI = get_instance();

			$curr_lang 	= get_current_lang();



			$default_lang = default_lang();

				

			if($curr_lang=='')

				$file_name = $default_lang.'.yml';

			else

			{

				if(!@file_exists(FCPATH."dbc_config/locals/".$curr_lang.'.yml'))

				{

					$file_name = $default_lang.'.yml';

				}

				else

				{					

					$file_name = $curr_lang.'.yml';

				}

			}



			$CI->load->library('yaml');

			$lang =  $CI->yaml->parse_file('./dbc_config/locals/'.$file_name);



			if(count($lang)>0)

			{

				if(!defined('LANG_ARRAY'))

					define('LANG_ARRAY',json_encode($lang));



				if(isset($lang[$key]))

					return $lang[$key];

				else {

					if(constant("ENVIRONMENT")=='development') {

						$myfile = fopen("missing_lang.txt", "a") or die("Unable to open file!");

						$txt = $key."\n";

						fwrite($myfile, $txt);

						fclose($myfile);

					}

					return $key;

				}

			}

			else {

				if(constant("ENVIRONMENT")=='development') {

					$myfile = fopen("missing_lang.txt", "a") or die("Unable to open file!");

					$txt = $key."\n";

					fwrite($myfile, $txt);

					fclose($myfile);

				}

				return $key;

			}

			

		}

	}

}



if ( ! function_exists('checksavedlogin'))

{

	function checksavedlogin()

	{

		$CI = get_instance();

		$key = get_cookie('mycookie_key');

		$user = get_cookie('mycookie_user');

	

		if($user!=FALSE && $key!=FALSE)

		{

			$CI->load->model('auth_model');

			$CI->auth_model->check_cookie_val($user,$key);

		}

	}

}



if ( ! function_exists('get_username_by_id'))

{

	function get_username_by_id($id)

	{

		$CI = get_instance();

		$query = $CI->db->get_where('users',array('id'=>$id));

		$row = $query->row();

		return $row->user_name;

	}

}



if ( ! function_exists('get_id_by_username'))

{

	function get_id_by_username($user_name)

	{

		$CI = get_instance();

		$query = $CI->db->get_where('users',array('user_name'=>$user_name));

		$row = $query->row();

		return $row->id;

	}

}



if ( ! function_exists('get_plugins'))

{

	function get_plugins()

	{

		$CI = get_instance();

		$query = $CI->db->get_where('plugins',array('status'=>1));		

		return $query;

	}

}



if ( ! function_exists('configPagination'))

{

	function configPagination($url,$total_rows,$segment,$per_page=10)

	{





		$CI = get_instance();

		$CI->load->library('pagination');

		$config['base_url'] 		= site_url($url);

		$config['total_rows'] 		= $total_rows;

		$config['per_page'] 		= $per_page;

		$config['uri_segment'] 		= $segment;

		$config['num_tag_open'] 	= '<li>';

		$config['num_tag_close'] 	= '</li>';

		$config['cur_tag_open'] 	= '<li class="active"><a href="#">';

		$config['cur_tag_close']	= '</a></li>';

		$config['num_links'] 		= 3;

		$config['next_tag_open'] 	= "<li>";

		$config['next_tag_close'] 	= "</li>";

		$config['prev_tag_open'] 	= "<li>";

		$config['prev_tag_close'] 	= "</li>";

		

		$config['first_link'] 	= FALSE;

		$config['last_link'] 	= FALSE;

		$CI->pagination->initialize($config);

		

		return $CI->pagination->create_links();

	}

}







if ( ! function_exists('render_widget'))

{

	function render_widget($alias='')

	{

		$CI 		= get_instance();

		$CI->load->helper('inflector');	

		$CI->load->helper('file');

		$query = $CI->db->get_where('widgets',array('alias'=>$alias));

		if($query->num_rows()>0)

		{

			$row = $query->row();

			if($row->status==1)

			{

				$curr_lang = get_current_lang();

				if(read_file('./application/modules/widgets/'.$curr_lang.'_'.$row->alias.'.php')!=FALSE)

					require'./application/modules/widgets/'.$curr_lang.'_'.$row->alias.'.php';

				else					

				{					

					if(read_file('./application/modules/widgets/'.$row->alias.'.php')!=FALSE)

					require'./application/modules/widgets/'.$row->alias.'.php';

				}

			}

			else if($row->status==0)

				echo '';

			else

				echo '';

		}

		else

		{

			echo '';

		}			

	}

}



if ( ! function_exists('render_widgets'))

{

	function render_widgets($position='')

	{

		$CI 		= get_instance();

		$CI->load->helper('inflector');	

		$CI->load->helper('file');

		$widgets 	= get_widgets_by_position($position);	

		if(!empty($widgets)){

			foreach($widgets as $row)

			{

				$query = $CI->db->get_where('widgets',array('alias'=>$row));

				if($query->num_rows()>0)

				{

					$row = $query->row();

					if($row->status==1)

					{

						$curr_lang = get_current_lang();

						if(read_file('./application/modules/widgets/'.$curr_lang.'_'.$row->alias.'.php')!=FALSE)

							require'./application/modules/widgets/'.$curr_lang.'_'.$row->alias.'.php';

						else					

						{					

							if(read_file('./application/modules/widgets/'.$row->alias.'.php')!=FALSE)

							require'./application/modules/widgets/'.$row->alias.'.php';

						}				

					}

					else if($row->status==0)

						echo '';

					else

						echo '';

				}

				else

				{

					echo '';

				}

					

			}

		}

	}

}



if ( ! function_exists('get_widgets_by_position'))

{

	function get_widgets_by_position($pos='')

	{

		$CI = get_instance();

		$positions = get_option('positions');

		if(is_array($positions)==TRUE && isset($positions['error'])==TRUE)

		{

			$widgets = array();

		}

		else

		{

			$positions = json_decode($positions->values);

			$widgets = array();

			foreach($positions as $position)

			{

				if($position->name==$pos)

				{

					if(isset($position->widgets))

					$widgets = $position->widgets;

				}

			}			

		}

		return $widgets;

	}

}





if ( ! function_exists('get_current_lang'))

{

	function get_current_lang()

	{

		$CI 		= get_instance();

		$lang = ($CI->uri->segment(1)!='')?$CI->uri->segment(1):default_lang();

		if(!@file_exists(FCPATH."dbc_config/locals/".$lang.'.yml'))

			$lang = default_lang();

		return $lang;	

	}

}





if ( ! function_exists('theme_url'))

{

	function theme_url($theme='')

	{

		$CI 	= get_instance();

		if($theme=='')

		$theme 	= get_active_theme();

		return base_url('application/modules/themes/views/'.$theme.'/');	

	}

}



if ( ! function_exists('load_admin_view'))

{

	function load_admin_view($view='',$data=array(),$buffer=FALSE)

	{

		$CI 	= get_instance();

		if($buffer==FALSE)

		{

			if(@file_exists(APPPATH."modules/admin/views/custom/".$view.".php"))

			$CI->load->view('custom/'.$view,$data);

			else

			$CI->load->view('default/'.$view,$data);	

		}

		else

		{

			if(@file_exists(APPPATH."modules/admin/views/custom/".$view.".php"))

			$view_data = $CI->load->view('custom/'.$view,$data,TRUE);

			else

			$view_data = $CI->load->view('default/'.$view,$data,TRUE);	

			return $view_data;

		}

	}

}





if ( ! function_exists('load_view'))

{

	function load_view($view='',$data=array(),$buffer=FALSE,$theme='')

	{

		$CI 	= get_instance();

		if($theme=='')

		$theme 	= get_active_theme();

		if($buffer==FALSE)

		{

			if(@file_exists(APPPATH."modules/themes/views/".$theme."/".$view.".php"))

			$CI->load->view('themes/'.$theme.'/'.$view,$data);

			else

			$CI->load->view('themes/default/'.$view,$data);	

		}

		else

		{

			if(@file_exists(APPPATH."modules/themes/views/".$theme."/".$view.".php"))

			$view_data = $CI->load->view('themes/'.$theme.'/'.$view,$data,TRUE);

			else

			$view_data = $CI->load->view('themes/default/'.$view,$data,TRUE);	

			return $view_data;

		}

	}

}



if ( ! function_exists('load_template'))

{

	function load_template($data=array(),$theme='',$tmpl='template_view')

	{

		$row 	= get_option('site_settings');

		if(is_array($row) && isset($row['error']))

		{

			echo 'Site settings not found.error on : epbase_helper';

			die();

		}

		else

		{

			$values 		= json_decode($row->values);

			$data['title'] 	= $values->site_title;

		}



		load_view($tmpl,$data);

	}

}





if ( ! function_exists('get_active_theme_woc'))

{

	function get_active_theme_woc()

	{

		

		$row = get_option('active_theme');

		if(is_array($row) && isset($row['error']))

		{

			$theme = 'default';

		}

		else

			$theme = $row->values;			

	

		

		return $theme;

		

	}

}



if ( ! function_exists('get_active_theme'))

{

	function get_active_theme()

	{

		if(defined('ACTIVE_THEME'))

		{



			return constant('ACTIVE_THEME');

		}

		else

		{

			

			$row = get_option('active_theme');

			if(is_array($row) && isset($row['error']))

			{

				$theme = 'default';

			}

			else

				$theme = $row->values;			

		

			if(!defined('ACTIVE_THEME'))

			{

				define('ACTIVE_THEME',$theme);

			}

			return $theme;

		}

	}

}



if ( ! function_exists('get_settings'))

{

	function get_settings($option='',$key='',$default='Yes')

	{

		$settings = get_option($option);

		if(is_array($settings)==FALSE)

		{

			$settings = (array)json_decode($settings->values);

			$val = (isset($settings[$key]))?$settings[$key]:$default;

		}

		else

			$val = $default;



		return $val;

	}

}





if ( ! function_exists('get_option'))

{

	function get_option($key='')

	{

		$defined = 0;

		if(defined('OPTIONS_ARRAY'))

		{						

			$options = (array)json_decode(constant('OPTIONS_ARRAY'));

			if(isset($options[$key]))

			{

				$defined = 1;

				return $options[$key];

			}

		}





		if($defined==0)

		{

			$CI = get_instance();

			$CI->load->database();

			$query = $CI->db->get_where('options',array('key'=>$key,'status'=>1));		

			if($query->num_rows()>0)

				$option = $query->row();

			else

				$option = array('error'=>'Key not found');



			$options[$key] = $option;

			if(!defined('OPTIONS_ARRAY'))

				define('OPTIONS_ARRAY',json_encode($options));



			return $option;

		}

	}

}







if ( ! function_exists('update_option'))

{

	function update_option($key='',$values=array())

	{

		$CI = get_instance();

		$data['values'] = json_encode($values);

		$query = $CI->db->update('options',$data,array('key'=>$key));		

	}

}



if ( ! function_exists('add_option'))

{

	function add_option($key='',$values='')

	{

		$CI = get_instance();

		$data['values'] = $values;

		$result = get_option($key);

		if(is_array($result) && isset($result['error']))

		{

			$data['key'] = $key;

			$query = $CI->db->insert('options',$data);					

		}

		else

		{

			$query = $CI->db->update('options',$data,array('key'=>$key));		

		}

	}

}



if ( ! function_exists('get_widgets'))

{

	function get_widgets()

	{

		$CI = get_instance();

		$widgets = array(

				array('lib'=>'gi_relatedpost','function'=>'get_related_posts','param'=>array('sc mondal'))

			);

		

		foreach ($widgets as $widget) 

		{

			$CI->load->library($widget['lib']);

			$CI->$widget['lib']->$widget['function']($widget['param']);

		}

	}

}





if ( ! function_exists('is_active_menu'))

{

	function is_active_menu($url)

	{

		if(is_array($url))

		{

			foreach ($url as $menu) {

				if(strpos(uri_string(),$menu))

					return 'active';

			}					

		}

		else

		{

			if(uri_string()=='' && $url=='')

				return 'active';



			if(uri_string()=='' || $url=='')

				return '';

			return (strpos(uri_string(),$url))?'active':'';			

		}

	}

}



if ( ! function_exists('get_alias_by_url'))

{

	function get_alias_by_url()

	{

		$uri =  uri_string();

		$segements = explode('/',$uri);

		$i=0;

		$url = '';

		foreach ($segements as $seg) {

			if($i>0)

			{

				$url .= $seg.'/';

			}

			$i++;

		}



		$CI = get_instance();

		$CI->load->model('show/show_model');

		$alias = $CI->show_model->get_alias_by_url($url);

		return $alias;

	}

}



if ( ! function_exists('truncate'))

{

	function truncate($s, $l, $e = '...', $isHTML = false){

		$i = 0;

		$tags = array();

		if($isHTML){

			preg_match_all('/<[^>]+>([^<]*)/', $s, $m, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

			foreach($m as $o){

				if($o[0][1] - $i >= $l)

					break;

				$t = substr(strtok($o[0][0], " \t\n\r\0\x0B>"), 1);

				if($t[0] != '/')

					$tags[] = $t;

				elseif(end($tags) == substr($t, 1))

					array_pop($tags);

				$i += $o[1][1] - $o[0][1];

			}

		}

		return substr($s, 0, $l = min(strlen($s),  $l + $i)) . (count($tags = array_reverse($tags)) ? '</' . implode('></', $tags) . '>' : '') . (strlen($s) > $l ? $e : '');

	}

}



if ( ! function_exists('encode_html'))

{

	function encode_html($html){

		$html = str_replace('<','&lt;', $html);

		$html = str_replace('>','&gt;', $html);

		return $html;

	}

}



if ( ! function_exists('get_page_layout'))

{

	function get_page_layout($alias)

	{

		$CI = get_instance();

		$CI->load->model('show/show_model');

		$query = $CI->show_model->get_page_by_alias($alias);

		if($query->num_rows>0)

		{

			$row = $query->row();

			return $row->layout;

		}

		else

			return  get_settings('site_settings','default_layout',1);

	}

}



if ( ! function_exists('create_log'))

{

	function create_log($user_name)

	{		

		$row = get_option('purchase_key');

		$purchase_key = (isset($row->values))?$row->values:'1';



		$row = get_option('item_id');

		$item_id = (isset($row->values))?$row->values:'2';



		$domain = base_url();

		if (!strpos('-'.$domain, "http://localhost/"))

		{

			//set POST variables

			$url = get_author_url().'admin/verify/checkproductkey';

			$fields = array(

								'purchase_key' => urlencode($purchase_key),

								'item_id' => urlencode($item_id),

								'domain' => urlencode($domain),

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

			

			

			$CI = get_instance();

			if($result==='0')		

			{

				$CI->session->set_flashdata('msg', '<div class="alert alert-danger">Please verify your purchase.</div>');

				redirect(site_url('admin/purchase/regdomain'));

			}

			elseif($result==='1')

			{

				

			}

			else 

			{

				$CI->load->helper('file');

				$data = read_file('./dbc_config/local-data.conf');

				if($data=='')

				{

					$CI->session->set_flashdata('msg', '<div class="alert alert-danger">Please verify your purchase.</div>');

					redirect(site_url('admin/purchase/regdomain'));

				}

				else

				{

					$string = md5(urlencode($purchase_key).'-'.urlencode($item_id).'-'.urlencode($domain));

					if($string==$data)

					{



					}

					else

					{

						$CI->session->set_flashdata('msg', '<div class="alert alert-danger">Please verify your purchase.</div>');

						redirect(site_url('admin/purchase/regdomain'));						

					}

				}				

			}					

		}

	}

}





if ( ! function_exists('load_page_local_data'))

{

	function load_page_local_data($alias='',$lang='')

	{

		$CI 	= get_instance();

		$CI->load->helper('file');

		$file_path = './dbc_config/locals-pages/'.$alias.'_'.$lang.'.html';



		$status = 0;

		$main_content = '';

		if(@file_exists($file_path))

		{

			$main_content = read_file('./dbc_config/locals-pages/'.$alias.'_'.$lang.'.html');			

			$status = 1;

		}



		$sidebar = '';

		if(@file_exists($file_path))

		{

			$sidebar = read_file('./dbc_config/locals-pages/'.$alias.'_'.$lang.'_sidebar.html');

			$status = 1;			

		}



		$data = array();

		$data['sidebar'] = $sidebar;

		$data['content'] = $main_content;

		$data['status']  = $status;

		return $data;



	}

}





if ( ! function_exists('m'))

{

	function m($val='')

	{

		return strtoupper($val[1]);

	}

}



if ( ! function_exists('convert_widget_text'))

{

	function convert_widget_text($val='')

	{

		$val = preg_replace_callback('/(?:^|_)([a-z])/','m', $val);

		return $val;

	}

}



if ( ! function_exists('get_admin_email_and_name'))

{

	function get_admin_email_and_name()

	{

		$CI 	= get_instance();

		$CI->load->model('admin/options_model');

		$values = $CI->options_model->getvalues('webadmin_email');



		if(count($values))

		{

			$data['admin_email'] = (isset($values->webadmin_email))?$values->webadmin_email:'admin@'.$_SERVER['HTTP_HOST'];

			$data['admin_name']  = (isset($values->webadmin_name))?$values->webadmin_name:'Admin';

		}

		else

		{

			$data['admin_email'] = 'admin@'.$_SERVER['HTTP_HOST'];

			$data['admin_name']  = 'Admin';		

		}

		return $data;

	}

}



if ( ! function_exists('send_payment_confirmation_email'))

{

	function send_payment_confirmation_email($data=array())

	{

		$CI 	= get_instance();



		$val = get_admin_email_and_name();

		$admin_email = $val['admin_email'];

		$admin_name  = $val['admin_name'];



		$CI->load->model('admin/system_model');

		$tmpl = $CI->system_model->get_email_tmpl_by_email_name('payment_confirmation_email');

		$subject = $tmpl->subject;

		$subject = str_replace("#username",$data['user_name'],$subject);

		$subject = str_replace("#resumelink",$data['link'],$subject);

		$subject = str_replace("#webadmin",$admin_name,$subject);

		$subject = str_replace("#useremail",$data['user_email'],$subject);



		$body = $tmpl->body;

		$body = str_replace("#username",$data['user_name'],$body);

		$body = str_replace("#resumelink",$data['link'],$body);

		$body = str_replace("#webadmin",$admin_name,$body);

		$body = str_replace("#useremail",$data['user_email'],$body);



		$CI->load->library('email');

		$CI->email->from($admin_email, $subject);

		$CI->email->to($data['user_email']);

		$CI->email->subject($subject);		

		$CI->email->message($body);		

		$CI->email->send();



	}

}







/* End of file array_helper.php */

/* Location: ./system/helpers/array_helper.php */