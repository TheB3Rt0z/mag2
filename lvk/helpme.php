<?php $scriptFile = array_shift($argv); //var_dump($argv);

function includePath($path) {

    $paths = scandir($path);

    natsort($paths);//var_dump($paths);

    foreach ($paths as $file) {
        $absolutePath = $path . '/' . $file;
        if (is_dir($absolutePath) && !in_array($file, ['.', '..'])) {
            includePath($absolutePath);
        } elseif (end(explode(".", $file)) == 'php') {
            include_once $absolutePath;
        }
    }
}

includePath(realpath('.') . '/phpDocumentor');

define('COLOR_GREEN', "\033[32m"); // for analyzed files
define('COLOR_RED', "\033[31m"); // for errors
define('COLOR_YELLOW', "\033[33m"); // for warnings
define('COLOR_CYAN', "\033[36m"); // for todos
define('COLOR_MAGENTA', "\033[35m"); // for components
define('COLOR_CLOSE', "\033[0m"); // to close color statement

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

function path2class($path) {

    return str_replace('/', '\\', str_replace(
        [
            MAGENTO_PATH,
            '/app/code/',
            '/app/design/frontend',
            '/app/design/backend',
            '.php'
        ],
        '',
        $path
    ));
}

function analyzePath($item) // single path tests
{
    $docBlockFactory = phpDocumentor\Reflection\DocBlockFactory::createInstance(/*['package' => Package::class]*/);

    $data = [];//var_dump($item);

    // semantic context tests
    if (isset($item['context'])) {
        switch ($item['context']) {
            case 'FB' : { // frontend-block context tests
                $class = new \ReflectionClass($item['class']); // http://php.net/manual/en/class.reflectionclass.php
                $docBlock = $docBlockFactory->create($class->getDocComment());
                $docBlockCategory = $docBlock->getTagsByName('category')[0]->__toString();
                if ($docBlockCategory != 'Class')
                    $data['warnings'][] = "wrong category tag '" . $docBlockCategory . "' for class " . COLOR_YELLOW . $class->getName() . COLOR_CLOSE;
                if (isset($item['component'])) {
                    $docBlockPackage = $docBlock->getTagsByName('package')[0]->__toString();
                    if ($docBlockPackage != $item['component'])
                        $data['warnings'][] = "wrong package tag '" . $docBlockPackage . "' (should be '" . $item['component'] . "') for class " . COLOR_YELLOW . $class->getName() . COLOR_CLOSE;
                }
                switch ($parentClass = $class->getParentClass()->getName()) {
                    case 'Magento\Framework\View\Element\Template' : {
                        if (!file_exists($item['view_path'])) {
                            $data['errors'][] = "missing correspondant template view at location " . COLOR_RED . $item['view_path'] . COLOR_CLOSE;
                        }
                        if (isset($item['widget_path']) && !file_exists($item['widget_path'])) {
                            $data['errors'][] = "missing correspondant widget block at location " . COLOR_RED . $item['widget_path'] . COLOR_CLOSE;
                        }
                        break;
                    }
                    default : {
                        if (!class_exists($item['class'])) {
                            $data['warnings'][] = "check if this class " . COLOR_YELLOW . "is extending the right parent (" . $parentClass . ")" . COLOR_CLOSE;
                        }
                    }
                }
                break;
            }
            case 'M' : { // model context tests
                if ((strpos($item['path'], '/Model/Config/Source/') !== false)
                && (substr($item['filename'], -11) != 'Options.php')) {
                    $data['warnings'][] = "file name and class " . COLOR_YELLOW . "should follow pattern '[UCFIRST_STRING]Options.php'" . COLOR_CLOSE;
                }
                break;
            }
            case 'FT' : {
                if (!file_exists($item['source_path'])) {
                    $data['errors'][] = "missing correspondant source block at location " . COLOR_RED . $item['source_path'] . COLOR_CLOSE;
                }
                break;
            }
        }
    }

    $file = file($item['fullpath']);

    foreach ($file as $key => $value) { // single line tests
        if (preg_match('/(?:\A|[^\p{L}]+)todo([^\p{L}]+(.*)|\Z)/ui', $value, $matches) !== 0) { // searching for todo(s)
            $data['todos'][] = "found todo on line " . ($key + 1) . " '" . COLOR_CYAN . str_replace([" -->"], '', trim($matches[1])) . COLOR_CLOSE . "' in " . $item['path'];
        }
        if (preg_match("/\t/", $value)) { // checking if any tab is present
            $data['warnings'][] = "found " . COLOR_YELLOW . "tabs(s)" . COLOR_CLOSE . " on line " . ($key + 1);
            if (defined('FIX_FILESYSTEM')) {
                $file[$key] = preg_replace("/\t/", "    ", $value);
            }
        }
    }

    // file tests
    if (substr(end($file), -1) != "\n") {
        $data['warnings'][] = "no newline at the end of the file";
    }

    if (defined('FIX_FILESYSTEM')) {
        file_put_contents($item['fullpath'], implode($file));
    }

    return $data;
}

function scanPath($path)
{
    $data = [];

    foreach (scandir($path) as $file) {

        $item = [];

        if (!in_array($file, unserialize(FILES_FILTER))) {

            $item['fullpath'] = $absolutePath = $path . '/' . $file;
            $item['filename'] = $file;
            $item['path'] = str_replace(BASE_PATH, '', $absolutePath);
//var_dump($absolutePath);
            if (file_exists($absolutePath . '/registration.php')) {
                $item['flag_is_component_root'] = true;
                $_SESSION['component_path'] = $absolutePath;
                @$_SESSION['component'] = end(explode("/", $absolutePath));
            } elseif (file_exists($path . '/registration.php')) {
                @$_SESSION['component'] = end(explode("/", $path));
            }

            if ($_SESSION['component']) {
                $item['component'] = "Iways"
                                   . (preg_match("/^[A-Z]/", $_SESSION['component'])
                                     ? "_"
                                     : "/") . $_SESSION['component'];
            }

            if (is_dir($absolutePath)) {
                $item['children'] = scanPath($absolutePath);
                $item['extension'] = 'Ω';
            } else {
                @$item['extension'] = $extension = end(explode(".", $file));

                if (isset($_SESSION['component_path'])) {
                    if (strpos($absolutePath, $_SESSION['component_path'] . '/Block/Adminhtml') !== false) {
                        $item['context'] = 'BB';
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/Block') !== false) {
                        $item['context'] = 'FB';
                        $item['class'] = path2class($absolutePath);
                        $relativePath = strtolower(str_replace([$_SESSION['component_path'] . '/Block', '.php'], ['', '.phtml'], $absolutePath));
                        $item['view_path'] = $_SESSION['component_path'] . '/view/frontend/templates' . $relativePath;
                        if ($file != 'Widget.php')
                            $item['widget_path'] = str_replace('.php', '/Widget.php', $item['fullpath']);
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/Model') !== false) {
                        $item['context'] = 'M';
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/view/backend/layout') !== false) {
                        $item['context'] = 'BL';
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/view/backend/templates') !== false) {
                        $item['context'] = 'BT';
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/view/frontend/layout') !== false) {
                        $item['context'] = 'FL';
                    } elseif (strpos($absolutePath, $_SESSION['component_path'] . '/view/frontend/templates') !== false) {
                        $item['context'] = 'FT';
                        $relativePath = [];
                        foreach (explode('/', str_replace([$_SESSION['component_path'] . '/view/frontend/templates', '.phtml'], ['', '.php'], $absolutePath)) as $value) {
                            $relativePath[] = ucfirst($value);
                        }
                        $item['source_path'] = $_SESSION['component_path'] . '/Block' . implode($relativePath, '/');
                    }
                }

                if (in_array($extension, unserialize(EXTENSIONS_FILTER))) {
                    $item['analysis'] = analyzePath($item);
                }
            }

            $data[$absolutePath] = $item;
        }
    }

    uasort($data, function($first, $second) {
		return strcasecmp($first['extension'] . $first['filename'],
		                  $second['extension'] . $second['filename']);
	});

    return $data;
}

function showPath($data, $deep = 0)
{
    if ((!defined('SUPPRESS_BLACKS') || isset($data['analysis']) || isset($data['children']))
        && !(defined('SUPPRESS_GREENS') && empty($data['analysis']) && !isset($data['children']))
        && !(defined('SUPPRESS_DIRS') && isset($data['children']))) {

        $color = (isset($data['analysis'])
                 ? (isset($data['analysis']['errors'])
                   ? COLOR_RED
                   : (isset($data['analysis']['warnings'])
                     ? COLOR_YELLOW
                     : (isset($data['analysis']['todos'])
                       ? COLOR_CYAN
                       : COLOR_GREEN)))
                 : (isset($data['flag_is_component_root'])
                   ? COLOR_MAGENTA
                   : ''));

        echo str_repeat("- ", $deep) . $color . $data['filename'] . COLOR_CLOSE;

        if (!empty($data['analysis'])) {
            echo " =>";
            if (isset($data['analysis']['errors'])) {
                echo " " . count($data['analysis']['errors']) . " error(s): " . implode($data['analysis']['errors'], ", ");
            }
            if (isset($data['analysis']['warnings'])) {
                echo " " . count($data['analysis']['warnings']) . " warning(s): " . implode($data['analysis']['warnings'], ", ");
            }
            if (isset($data['analysis']['todos'])) {
                echo " " . count($data['analysis']['todos']) . " todo(s): " . implode($data['analysis']['todos'], ", ");
            }
        }

        if (defined('SHOW_MARKERS') && isset($data['context']))
            echo " (" . $data['context'] . ")";

        if (defined('SHOW_PATHS'))
            echo " [" . $data['path'] . "]";

        echo PHP_EOL;
    }

    if (isset($data['children'])) {
        foreach ($data['children'] as $file) {
            showPath($file, $deep + 1);
        }
    }
}

// starting procedural code

foreach ($argv as $_key => $_value) {
    switch ($_value) {
        case '-f' : {
            define('FIX_FILESYSTEM', true);
            break;
        }
        case '-h' : {
            echo PHP_EOL
               . "Magento 2 Lord Vollkorn Helper" . PHP_EOL
               . "------------------------------" . PHP_EOL
               . "-f)   fixes automatically filesystem" . PHP_EOL
               . "-h)   shows this help-text" . PHP_EOL
               . "-m)   Magento 2 root path (if not __DIR__)" . PHP_EOL
               . "-p)   relative path to file/directory to scan" . PHP_EOL
               . "-pp)  show context markers" . PHP_EOL
               . "-ppp) show full-paths in output" . PHP_EOL
               . "-s)   suppress not analyzed paths/files" . PHP_EOL
               . "-ss)  suppress not marked files" . PHP_EOL
               . "-sss) suppress directories lines" . PHP_EOL
               . PHP_EOL;
            break;
        }
        case '-m' : {
            $magentoPath = trim($argv[$_key + 1]);
            break;
        }
        case '-ppp' : {
            define('SHOW_PATHS', true);
        }
        case '-pp' : {
            define('SHOW_MARKERS', true);
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

define('MAGENTO_PATH', isset($magentoPath) ? realpath($magentoPath) : __DIR__);

require MAGENTO_PATH . '/app/bootstrap.php';

if (isset($relativePath)) {
    $absolutePath = realpath($relativePath);
    define('BASE_PATH', $absolutePath);
    if (file_exists(BASE_PATH)) {//var_dump(scanPath($absolutePath));DIE;
        $_SESSION['component_path'] = BASE_PATH;
        $_SESSION['component'] = false;
        foreach (scanPath(BASE_PATH) as $_path => $_data) {
            showPath($_data);
        }
    }
    else
        echo "ERROR: relative path does not exists" . PHP_EOL;
}

echo PHP_EOL;
