<?php // ATM not working, ask me why and say goodbye (to this enhancement)

namespace Iways\DeveloperToolBox\Plugin\Magento\Framework\Filesystem\Driver;

use Magento\Framework\Filesystem\Driver\File as subject;

class File
{
    public function aroundGetAbsolutePath(subject $subject, callable $proceed, $basePath, $path, $scheme)
    {
        if ((strpos($path, 'im2-module') !== false) && (substr($path, -3) == 'csv')) {

            return $subject->getScheme($scheme) . $path;
        }

        return $proceed($basePath, $path, $scheme);
    }
}
