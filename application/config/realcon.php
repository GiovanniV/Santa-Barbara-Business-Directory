<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');



$config['blog_post_types']	= array('blog'=>'Blog Posts','article'=>'Articles','news'=>'News');



$config['enable_custom_fields']	= 'No';

$config['custom_fields']		= array(

										array('title'=>'Floor No','name'=>'floor_no','type'=>'text','validation'=>'','show_on_detail_page'=>'yes','others'=>array()),

										array('title'=>'Has Garage','name'=>'has_garage','type'=>'select',

											  'value'=>array('No'=>'No','Yes'=>'Yes'),'validation'=>'','show_on_detail_page'=>'yes','others'=>array())

										);



$config['property_types']		= array(

										array('title'=>'DBC_TYPE_APARTMENT'),

										array('title'=>'DBC_TYPE_HOUSE'),

										array('title'=>'DBC_TYPE_LAND'),

										array('title'=>'DBC_TYPE_COMSPACE'),

										array('title'=>'DBC_TYPE_CONDO'),

										array('title'=>'DBC_TYPE_VILLA')

									);



$config['property_status']		= array(

										array('title'=>'DBC_CONDITION_NEW'),

										array('title'=>'DBC_CONDITION_AVAILABLE'),

										array('title'=>'DBC_CONDITION_SOLD'),

										array('title'=>'DBC_CONDITION_RENTED'),

										array('title'=>'DBC_CONDITION_AUCTION')

									);





# to create a new property just add another element to the $config['property_types'] array

# be carefull that each element of the array must end with a comma (,) execpt the last one

# the last element should not have any trailing comma

# to remove any property type just delete the line of that type, again be careful about the comma