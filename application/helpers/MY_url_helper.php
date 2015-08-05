<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');







if ( ! function_exists('site_url'))



{



	function site_url($uri = '',$lang='')



	{



		$CI =& get_instance();



		if($lang=='')

		$lang = get_current_lang();



		$final_url = $CI->config->site_url($lang.'/'.$uri);



		$CI->load->config('business_directory');

		if($CI->config->item('use_ssl')=='yes')

		$final_url = str_replace('http://','https://',$final_url); #uncomment this line if you want to force 



		return $final_url;



	}



}







if ( ! function_exists('base_url'))



{



	function base_url($uri = '')



	{



		$CI =& get_instance();



		$base_url = $CI->config->base_url($uri);



		$CI->load->config('business_directory');

		

		if($CI->config->item('use_ssl')=='yes')

			$base_url = str_replace('http://','https://',$base_url);



		return $base_url;



	}



}





if ( ! function_exists('post_detail_url'))



{



	function post_detail_url($post)



	{



		$CI =& get_instance();

		$url = site_url('ads/'.$post->unique_id); #never remove this line

		$url .= '/'.dbc_url_title(get_category_title_by_id($post->category));

		$url .= '/'.dbc_url_title(get_post_data_by_lang($post,'title'));



		return $url;



	}



}







