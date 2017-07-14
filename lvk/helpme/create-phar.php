<?php

$src_dir = './src';
$build_dir = './build';

$phar = new Phar($build_dir . '/helpme.phar',
	             FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
                 'helpme.phar');

$phar['index.php'] = file_get_contents($src_dir . '/index.php');
$phar['common.php'] = file_get_contents($src_dir . '/common.php');
$phar->setStub($phar->createDefaultStub('index.php'));

copy($src_dir . '/config.ini', $build_dir . '/config.ini');
