## Concept

- Theme and modules provide german translation csv files of used english coded strings, independently of local Magento's available dictionaries, in order to assure an aimed translation of interface (tested on system with locale se en_US/de_DE) on german systems.

At the moment, the i-ways Magento 2 Extensions Framework consist of following components:

1. **a basic theme** (Iways/base) extending Magento's blank theme, which is a suitable starting extending-point for further themes;

2. **three basic extensions** (Iways_Base, Iways_Design and Iways_Mobile) which are supposed to be used in conjunction with above template, in order to achieve an optimal frontend templating substrate;

3. **additional aimed extensions** (actually Iways_CategoryTree, Iways_OpeningHours and Iways_SocialLinks) for multi-project purpouses.

N.B.: at present date there is another extension in embrional stage, Iways_GoogleFonts, which actually could become Iways_Googlefonts (see further, modules naming conventions), in order to assist basic extensions at point 2 above on the frontend.

## Conventions

### Theme naming

Basic template identifier has 2 components, **Iways** and **base** (slash separated), further templates extending it should be identified with **Iways/[LOWERCASE_STRING]** and **Iways/[LOWERCASE_STRING]_[LOWERCASE_STRING]** if additional nesting is needed.

### Module naming

Basic extensions should follow pattern **Iways_[UPPERCASEFIRST_STRING]** whereas additional extensions have another element in the name, and are following pattern **Iways_[UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING]**.
The only extension with pattern **Iways_[UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING]** is actually Iways_DeveloperToolBox, only for internal use.

### XML Attributes

The following are functioning pattern and examples given are actually used in i-ways framework in different xml files:

**Theme declaration**
```
<!-- app/design/frontend/Iways/[LOWERCASE_THEME]/theme.xml --> e.g.: "base"

<?xml version="1.0" ?>
<theme xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
       xsi:noNamespaceSchemaLocation="urn:magento:framework:Config/etc/theme.xsd">
    <title>[THEME_NAME]</title> e.g.: "i-ways Base Theme"
    <parent>[PARENT_IDENTIFIER]</parent> e.g.: "Magento/blank"
    <media>
        <preview_image>media/preview.jpg</preview_image>
    </media>
</theme>
```

**General layout**
```
<!-- */layout/[LOWERCASE_LAYOUT].xml --> e.g.: "default", "default_head_blocks"

<?xml version="1.0" ?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <head>
        <link rel="apple-touch-icon"
              sizes="[IMAGE_SIZE]" e.g.: "32x32"
              src="[IMAGE_PATH] /> e.g.: "images/icon_32x32.png" />
        <link rel="icon"
              type="[MIME_TYPE]" [image/x-icon|image/png|image/gif]
              sizes="[IMAGE_SIZE]" e.g.: "32x32"
              src="[IMAGE_PATH] /> e.g.: "images/icon_32x32.png" />
        <link rel="shortcut icon"
              type="[MIME_TYPE]" [image/x-icon|image/png|image/gif]
              href="[IMAGE_PATH] /> e.g.: "images/icon_32x32.png" />
        <css src="[MODULE_IDENTIFIER]::css/[LOWERCASE_IDENTIFIER].css" /> e.g.: "Iways_Base", "iways_base"
        <meta name="viewport"
              content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
        <meta name="format-detection"
              content="telephone=no" />
    </head>
    <body>
        <referenceBlock name="[BLOCK_NAME]"> e.g.: "logo"
            <arguments>
                <argument name="[LOWERCASE_NAME]" e.g.: "logo_file"
                          xsi:type="[ARGUMENT_TYPE]">[ARGUMENT_VALUE]</argument> [string|number], e.g.: "images/logo.png"
            </arguments>
        </referenceBlock>
        <referenceContainer name="[CONTAINER_NAME]"> e.g.: "content"
            <block class="[CLASS_NAME]" e.g.: "Iways\Base\Block\Adminhtml\Documentation"
                   name="[LOWERCASE_IDENTIFIER]" e.g.: "iways_base_block_adminhtml_documentation"
                   as="[LOWERCASE_IDENTIFIER]" e.g.: "iways_base_block_adminhtml_documentation"
                   template="[MODULE_IDENTIFIER]::[TEMPLATE_PATH]" e.g.: "Iways_Base", "documentation.phtml"
                   before="-" />
        </referenceContainer>
    </body>
</page>
```

**Module resource ACL**
```
<!-- etc/acl.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="../../../../../lib/internal/Magento/Framework/Acl/etc/acl.xsd">
    <acl>
        <resources>
            <resource id="Magento_Backend::admin">
                <resource id="[MODULE_IDENTIFIER]::menu" e.g.: "Iways_Base"
                          title="[MANU_TITLE]" e.g.: "i-ways"
                          sortOrder="[SORTING_WEIGHT]" /> e.g.: "000"
                <resource id="Magento_Backend::stores">
                    <resource id="Magento_Backend::stores_settings">
                        <resource id="Magento_Config::config">
                            <resource id="[MODULE_IDENTIFIER]::config" e.g.: "Iways_Base"
                                      title="[TAB_TITLE]" e.g.: "i-ways Config Section"
                                      sortOrder="[SORTING_WEIGHT]" /> e.g.: "000"
                        </resource>
                    </resource>
                </resource>
            </resource>
        </resources>
    </acl>
</config>
```

**Module default settings**
```
<!-- etc/config.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <default>
        <[LOWERCASE_IDENTIFIER]> e.g.: "general"
            <[LOWERCASE_IDENTIFIER]> e.g.: "frontend"
                <[LOWERCASE_IDENTIFIER]>[CONFIG_VALUE]</[LOWERCASE_IDENTIFIER]> e.g.: "show", 1, "show"
            </[LOWERCASE_IDENTIFIER]> e.g.: "frontend"
        </[LOWERCASE_IDENTIFIER]> "general"
    </default>
</config>
```

**Module declaration**
```
<!-- etc/module.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="Iways_[CAMELCASE_NAME]" e.g.: "DeveloperToolBox"
            setup_version="[MODULE_VERSION]"> e.g.: "0.0.1"
        <sequence>
            <module name="[MODULE_IDENTIFIER]" /> e.g.: "Iways_Base"
        </sequence>
    </module>
</config>
```

**Module widgets configuration**
```
<!-- etc/widgets.xml -->

<?xml version="1.0" ?>
<widgets xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Widget:etc/widget.xsd">
	<widget id="[LOWERCASE_IDENTIFIER]" e.g.: "iways_widget"
            class="[BLOCK_CLASS]" e.g.: "Iways\Widget\Block\Frontend\Widget"
            placeholder_image="[IMAGE_PATH]"> e.g.: "Iways_Base::images/icon_32x32.png"
        <label>i-ways [WIDGET_NAME] Widget</label> e.g.: "Example"
        <description>i-ways [WIDGET_NAME] Widget</description> e.g.: "Example"
        <parameters>
            <parameter name="[LOWERCASE_NAME]" e.g.: "show_block"
                       xsi:type="[PARAMETER_TYPE]" [text|select]
                       required="[BOOLEAN_LITERAL]"> [true|false]
                <label translate="[BOOLEAN_LITERAL]">[PARAMETER_NAME]</label> [true|false], e.g.: "Show block"
            </parameter>
        </parameters>
    </widget>
</widgets>
```

**Module backend events**
```
<!-- etc/adminhtml/events.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:Event/etc/events.xsd">
    <event name="[LOWERCASE_IDENTIFIER]"> e.g.: "backend_auth_user_login_success"
        <observer name="[LOWERCASE_NAME]" e.g.: "iways_base_observer_backend_auth_user_login_success"
                  instance="[OBSERVER_CLASS]" /> e.g.: "Iways\Base\Observer\Backend\Auth\User\Login\Success"
    </event>
</config>
```

**Module backend menu**
```
<!-- etc/adminhtml/menu.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Backend:etc/menu.xsd">
    <menu>
    	<add id="[MODULE_IDENTIFIER]::menu" e.g.: "Iways_Base"
    	     resource="[MODULE_IDENTIFIER]::menu" e.g.: "Iways_Base"
    	     title="[MENU_NAME]" e.g.: "i-ways"
    	     sortOrder="[SORTING_WEIGHT]" e.g.: "000"
    	     dependsOnModule="[MODULE_IDENTIFIER]" e.g.: "Iways_Base"
    	     module="[MODULE_IDENTIFIER]" /> e.g.: "Iways_Base"
    	<add id="[MODULE_IDENTIFIER]::menu_system" e.g.: "Iways_Base"
    	     resource="[MODULE_IDENTIFIER]::menu_system" e.g.: "Iways_Base"
    	     title="[SUBSECTION_NAME]" e.g.: "System"
    	     parent="[MODULE_IDENTIFIER]::menu" e.g.: "Iways_Base"
             sortOrder="[SORTING_WEIGHT]" e.g.: "900"
    	     module="[MODULE_IDENTIFIER]" /> e.g.: "Iways_Base"
    	<add id="[MODULE_IDENTIFIER]::menu_system_configuration" e.g.: "Iways_Base"
    	     resource="[MODULE_IDENTIFIER]::menu_system_configuration" e.g.: "Iways_Base"
    	     title="[ACTION_NAME]" e.g.: "Configuration"
    	     parent="[MODULE_IDENTIFIER]::menu_system" e.g.: "Iways_Base"
             sortOrder="[SORTING_WEIGHT]" e.g.: "911"
    	     module="[MODULE_IDENTIFIER]" e.g.: "Iways_Base"
    	     action="adminhtml/system_config/edit/section/[LOWERCASE_IDENTIFIER]" /> e.g.: "iways_base"
    </menu>
</config>
```

**Module backend router**
```
<!-- etc/adminhtml/routes.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="admin">
        <route id="[LOWERCASE_IDENTIFIER]" e.g.: "iways_base"
               frontName="[LOWERCASE_IDENTIFIER]"> e.g.: "iways_base"
            <module name="[MODULE_IDENTIFIER]" e.g.: "Iways_Base"
                    before="Magento_Backend" />
        </route>
    </router>
</config>
```

**Module backend configuration**
```
<!-- etc/adminhtml/system.xml -->

<?xml version="1.0" ?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:noNamespaceSchemaLocation="urn:magento:module:Magento_Config:etc/system_file.xsd">
    <system>
        <tab id="[LOWERCASE_IDENTIFIER]" e.g.: "iways"
             class="[LOWERCASE_IDENTIFIER]" e.g.: "iways"
             translate="label"
             sortOrder="[SORTING_WEIGHT]"> e.g.: "000"
            <label>[MENU_NAME]</label> e.g.: "i-ways"
        </tab>
        <section id="[LOWERCASE_IDENTIFIER]" e.g.: "iways_base"
                 translate="label" 
                 type="text"
                 sortOrder="[SORTING_WEIGHT]" e.g.: "000"
                 showInDefault="1"
                 showInWebsite="1"
                 showInStore="1">
            <label>[SECTION_NAME]</label> e.g.: "General"
            <tab>[LOWERCASE_IDENTIFIER]</tab> e.g.: "iways"
            <resource>[MODULE_IDENTIFIER]::config</resource> e.g.: "Iways_Base"
            <group id="[LOWERCASE_IDENTIFIER]" e.g.: "information"
                   translate="label"
                   type="text"
                   sortOrder="[SORTING_WEIGHT]" e.g.: "000"
                   showInDefault="1"
                   showInWebsite="1"
                   showInStore="1">
                <label>[GROUP_NAME]</label> e.g.: "Information"
                <field id="[LOWERCASE_IDENTIFIER]" e.g.: "check"
                       type="hidden"
                       sortOrder="[SORTING_WEIGHT]" e.g.: "000"
                       showInDefault="1"
                       showInWebsite="1"
                       showInStore="1">
                    <frontend_model>[BLOCK_CLASS]</frontend_model> e.g.: "Iways\Base\Block\Adminhtml\System\Config\Form\Field\Check"
                </field>
                <field id="[LOWERCASE_IDENTIFIER]" e.g.: "warning"
                       translate="label comment"
                       type="note"
                       sortOrder="[SORTING_WEIGHT]" e.g.: "111"
                       showInDefault="1"
                       showInWebsite="1"
                       showInStore="1">
                    <label>[FIELD_NAME]</label> e.g.: "Warning"
                    <depends>
                        <field id="[FIELD_PATH]">1</field> e.g.: "iways_base/information/check"
                    </depends>
                    <comment>[COMMENT_STRING]</comment> e.g.: "Please install an i-ways Certified Frontend Theme in order to assure full compatibility with our extensions!"
                </field>
                <field id="[LOWERCASE_IDENTIFIER]" e.g.: "credits"
                       type="note"
                       sortOrder="[SORTING_WEIGHT]" e.g.: "999"
                       showInDefault="1"
                       showInWebsite="1"
                       showInStore="1">
                    <label>[CDATA_STRING]</label> e.g.: "<![CDATA[Copyright &copy; 2011-2017<br /><br /><a href="http://www.i-ways.net" target="_blank">i-ways sales solutions GmbH<br />Kurfürstendamm 125A<br />D-10711 Berlin</a><br /><br />]]>"
                </field>
            </group>
        </section>
    </system>
</config>
```

### PHP Doc Pattern

```
/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @category [File|Class]
 * @package  [MODULE_IDENTIFIER|THEME_IDENTIFIER]
 * @author   [AUTHOR_NAME] <[AUTHOR_EMAIL]>
 * @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 * @link     https://www.i-ways.net
 *
 * @todo [TODO_STRING]
 */
```

In case of class methods:

```
/**
 * Ⓒ i-ways sales solutions GmbH
 *
 * PHP Version 5
 *
 * @param [string|integer|float|boolean|array|object|null|resource|mixed] [PARAMETER_NAME] [PARAMETER_DESCRIPTION]
 *
 * @return [string|integer|float|boolean|array|object|null|resource|mixed]
 *
 * @todo [TODO_STRING]
 */
```

## Nice to have

- automatic documentation generator, based on code analysis and programmatically stored in each module/theme's readme;
- a (semi-)professional check of all used translations and usability of graphical interface, user-guide README.md files.

