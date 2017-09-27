<?php

$php_archive = new Phar(__DIR__ . '/helpme.phar',
	                    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
                        'helpme.phar');

$php_archive['helpme'] = file_get_contents(__DIR__ . '/helpme.php');

$php_archive->setStub($php_archive->createDefaultStub('helpme'));
