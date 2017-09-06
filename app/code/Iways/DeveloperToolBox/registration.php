<?php

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'Iways_DeveloperToolBox',
    __DIR__
);

function dump() {

    echo '<pre>';

    foreach (func_get_args() as $arg)
        var_dump($arg);

    echo '</pre>';
}
