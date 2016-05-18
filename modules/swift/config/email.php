<?php defined('SYSPATH') OR die('No direct access allowed.');

$config['default']['driver'] = 'native';
$config['default']['options'] = DB::select()->from('email_config')->where('id', '=', 1)->limit(1)->execute()->current();

return $config;