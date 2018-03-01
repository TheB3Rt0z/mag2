<?php
namespace Iways\Slider\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;


class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()->newTable(
            $installer->getTable('iways_slider_slider')
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Slider ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Slider title'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Slider status'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Slider image'
        )->addIndex(
            $installer->getIdxName('iways_slider_slider', ['status']),
            ['status']
        );
        $installer->getConnection()->createTable($table);


        $table = $installer->getConnection()->newTable(
            $installer->getTable('iways_slider_banner')
        )->addColumn(
            'banner_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Banner ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Banner title'
        )->addColumn(
            'content',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Banner content'
        )->addColumn(
            'cta_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Cta title'
        )->addColumn(
            'cta_link',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Cta Link'
        )->addColumn(
            'sort_order',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true, 'default' => 0],
            'Banner sort order'
        )->addColumn(
            'slider_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => true],
            'Slider Id'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Banner status'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner image'
        )->addColumn(
            'image_alt',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Banner image alt'
        )->addIndex(
            $installer->getIdxName('iways_slider_banner', ['slider_id']),
            ['slider_id']
        )->addIndex(
            $installer->getIdxName('iways_slider_banner', ['status']),
            ['status']
        );
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}