<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$config['blog_post_types']	= array('blog'=>'blog_post','article'=>'article','news'=>'news');





$config['decimal_point'] = '.';

$config['thousand_separator'] = ',';





#setting this config value to non empty will override the packge price currency.

#so if you have paypal enabled then remeber to use a currency which is supported by paypal. Otherwise your paypal payment will not work

#use this settings only if you want to enable bank payment and disable paypal payment

$config['package_currency'] = '';



#example

#$config['package_currency'] = 'USD';





#active languages 

$config['active_languages'] = array('en'=>'English','es'=>'Spanish','ru'=>'Russian','ar'=>'Arabic','de'=>'German','fr'=>'French','it'=>'Italian','pt'=>'Portuguese','tr'=>'Turkish','hi'=>'Hindi','bn'=>'Bangla');





#use ssl

$config['use_ssl'] = 'no';



