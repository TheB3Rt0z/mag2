<?php $scriptFile = array_shift($argv); //var_dump($argv);

define('FILES_FILTER', serialize([
    '.',
    '..',
    '.git',
    '.DS_Store',
    '.project',
]));

define('EXTENSIONS_FILTER', serialize([
    'css',
    'csv',
    'gitignore',
    'html',
    'js',
    'json',
    'md',
    'php',
    'phtml',
    'xml',
]));

function analyzePath($path) {

    $data = [];

    $file = file($path);

    foreach ($file as $key => $value) {
        if (preg_match('/(?:\A|[^\p{L}]+)todo([^\p{L}]+(.*)|\Z)/ui', $value, $matches) !== 0) {
            $data['todos'][] = "found todo on line " . $key . ": " . trim($matches[1]);
        }
    }

    if (substr(end($file), -1) != "\n") {
        $data['warnings'][] = "no newline at the end of the file";
    }

    return $data;
}

function scanPath($path) {

    $data = [];

    foreach (scandir($path) as $file) {

        if (!in_array($file, unserialize(FILES_FILTER))) {

            $absolutePath = $path . '/' . $file;

            $data[$absolutePath]['filename'] = $file;

            if (is_dir($absolutePath)) {
                $data[$absolutePath]['children'] = scanPath($absolutePath);
            } else {
                $extension = end(explode(".", $file));
                $data[$absolutePath]['extension'] = $extension;
                if (in_array($extension, unserialize(EXTENSIONS_FILTER))) {
                    $data[$absolutePath]['analysis'] = analyzePath($absolutePath);
                }
            }
        }
    }

    uasort($data, function($first, $second) {
		return strcasecmp($first['filename'], $second['filename']);
	});

    return $data;
}

function showPath($data, $deep = 0) {

    if ((!defined('SUPPRESS_BLACKS') || isset($data['analysis']) || isset($data['children']))
        && !(defined('SUPPRESS_GREENS') && empty($data['analysis']) && !isset($data['children']))
        && !(defined('SUPPRESS_DIRS') && isset($data['children']))) {

        $color = (isset($data['analysis'])
                 ? (isset($data['analysis']['errors'])
                   ? "\033[31m"
                   : (isset($data['analysis']['warnings'])
                     ? "\033[33m"
                     : (isset($data['analysis']['todos'])
                       ? "\033[36m"
                       : "\033[32m")))
                 : '');

        echo str_repeat("- ", $deep) . $color . $data['filename'] . "\033[0m";

        if (!empty($data['analysis'])) {
            echo " => (";
            if (isset($data['analysis']['errors'])) {
                echo count($data['analysis']['errors']) . " error(s): " . implode($data['analysis']['errors'], ", ");
            }
            if (isset($data['analysis']['warnings'])) {
                echo count($data['analysis']['warnings']) . " warning(s): " . implode($data['analysis']['warnings'], ", ");
            }
            if (isset($data['analysis']['todos'])) {
                echo count($data['analysis']['todos']) . " todo(s): " . implode($data['analysis']['todos'], ", ");
            }
            echo ")";
        }

        echo PHP_EOL;
    }

    if (isset($data['children'])) {
        foreach ($data['children'] as $file) {
            showPath($file, $deep + 1);
        }
    }
}

foreach ($argv as $_key => $_value) {
    switch ($_value) {
        case '-h' : {
            echo PHP_EOL
               . "Magento 2 Lord Vollkorn Helper" . PHP_EOL
               . "------------------------------" . PHP_EOL
               . "-h)  shows this help-text" . PHP_EOL
               . "-p)  relative path to file/directory to scan". PHP_EOL
               . "-s)  suppress not analyzed paths/files". PHP_EOL
               . "-ss) suppress not marked files". PHP_EOL
               . PHP_EOL;
            break;
        }
        case '-p' : {
            $relativePath = trim($argv[$_key + 1]);
            break;
        }
        case '-sss' : {
            define('SUPPRESS_DIRS', true);
        }
        case '-ss' : {
            define('SUPPRESS_GREENS', true);
        }
        case '-s' : {
            define('SUPPRESS_BLACKS', true);
            break;
        }
    }
}

if (isset($relativePath)) {
    $absolutePath = realpath($relativePath);
    if (file_exists($absolutePath)) {
        foreach (scanPath($absolutePath) as $_path => $_data) {
            showPath($_data);
        }
    }
    else
        echo "ERROR: relative path does not exists" . PHP_EOL;
}

echo PHP_EOL;
