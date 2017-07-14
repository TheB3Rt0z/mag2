<?php

$src_dir = './src';

require_once 'phar://helpme.phar/common.php';

$config = parse_ini_file($src_dir . '/config.ini');

AppManager::run($config);
