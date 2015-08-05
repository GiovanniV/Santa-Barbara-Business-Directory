<?php

$config['googleplus']['application_name'] = 'mementolab';

$config['googleplus']['client_id'] = get_settings('memento_settings','gplus_app_id','');

$config['googleplus']['client_secret'] = get_settings('memento_settings','gplus_secret_key','');

$config['googleplus']['redirect_uri'] = site_url('account/google_plus_auth/auth_callback');

$config['googleplus']['api_key'] = '';

?>