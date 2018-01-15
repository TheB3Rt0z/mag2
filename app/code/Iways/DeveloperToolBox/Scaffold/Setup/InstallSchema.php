<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_Scaffold
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\Scaffold\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface as implemented;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category Class
 * @package  Iways_Scaffold
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class InstallSchema implements implemented
{
    const SCAFFOLD_TABLE = 'iways_scaffold_scaffold';

    /**
     * Ⓒ i-ways sales solutions GmbH
     *
     * PHP Version 5
     *
     * @param object $schemaSetupInterface   Magento\Framework\Setup\SchemaSetupInterface
     * @param object $moduleContextInterface Magento\Framework\Setup\ModuleContextInterface
     *
     * @return void
     */
    public function install(
        SchemaSetupInterface $schemaSetupInterface,
        ModuleContextInterface $moduleContextInterface
    ) {
        $this->schemaSetupInterface = $schemaSetupInterface;

        $this->schemaSetupInterface->startSetup();

        $moduleContextInterface;

        $this->schemaSetupInterface->endSetup();
    }
}
