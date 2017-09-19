<?php

/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category File
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */

namespace Iways\DeveloperToolBox\Setup;

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
 * @package  Iways_DeveloperToolBox
 * @author   Bertozzi Matteo <bertozzi@i-ways.net>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 */
class InstallSchema implements implemented
{
    const COMPONENT_TABLE = 'iways_developertoolbox_component';

    public function install(
        SchemaSetupInterface $schemaSetupInterface,
        ModuleContextInterface $moduleContextInterface)
    {
        $this->schemaSetupInterface = $schemaSetupInterface;

        $this->schemaSetupInterface->startSetup();

        if (!$this->schemaSetupInterface->tableExists(self::COMPONENT_TABLE)) {
            $table = $this->schemaSetupInterface->getConnection()->newTable(
                $this->schemaSetupInterface->getTable(self::COMPONENT_TABLE)
            )->addColumn(
                'entity_id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true,
                ],
                'Entity ID'
            )->addColumn(
                'component_identifier',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false,
                ],
                'Component identifier'
            )->addColumn(
                'is_active',
                Table::TYPE_BOOLEAN,
                null,
                [
                    'nullable' => false,
                    'default' => '0',
                ],
                'is active'
            )->setComment('Iways_DeveloperToolBox Component');

            $this->schemaSetupInterface->getConnection()->createTable($table);
        }

        $this->schemaSetupInterface->endSetup();
    }
}

/*

            $installer->getConnection()->addIndex(
                $installer->getTable('mageplaza_helloworld_post'),
                $setup->getIdxName(
                    $installer->getTable('mageplaza_helloworld_post'),
                    ['name','url_key','post_content','tags','featured_image','sample_upload_file'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['name','url_key','post_content','tags','featured_image','sample_upload_file'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }*/
