<?php // ATM not working, ask me why and say goodbye (to this enhancement)

namespace Iways\DeveloperToolBox\Magento\Framework\Filesystem\Driver;

use Magento\Framework\Filesystem\Driver\File as extended;

class File extends extended
{
    public function getAbsolutePath($basePath, $path, $scheme = null)
    {
        if ((strpos($path, 'im2-module') !== false) && (substr($path, -3) == 'csv')) { // @todo: this should be settable

            return $this->getScheme($scheme) . $path;
        }

        if (0 === strpos($path, $basePath)) {

            return $this->getScheme($scheme) . $path;
        }

        return $this->getScheme($scheme) . $basePath . ltrim($this->fixSeparator($path), '/');
    }
}
