## Concept

At the moment, the i-ways Magento 2 Extensions Framework consist of following components:

1. **a basic template** (Iways/base) extending Magento's Blank Theme, which is a suitable starting extending-point for further themes;

2. **three basic extensions** (Iways_Base, Iways_Design and Iways_Mobile) which are supposed to be used in conjunction with above template, in order to achieve an optimal frontend templating substrate;

3. **additional aimed extensions** (actually Iways_CategoryTree, Iways_OpeningHours and Iways_SocialLinks) for multi-project purpouses.

N.B.: at the moment there is another extension in embrional stage, Iways_GoogleFonts, which actually could become Iways_Googlefonts (see further, modules naming conventions), in order to assist basic extensions at point 2 above on the frontend.


## Conventions

### Theme naming

Basic template identifier has 2 components, **Iways** and **base** (slash separated), further templates extending it should be identified with **Iways/[LOWERCASE_STRING]** and **Iways/[LOWERCASE_STRING]_[LOWERCASE_STRING]** if additional nesting is needed.

### Module naming

Basic extensions should follow pattern **Iways_[UPPERCASEFIRST_STRING]** whereas additional extensions have another element in the name, and are following pattern **Iways_[UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING]**.
The only extension with pattern **Iways_[UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING][UPPERCASEFIRST_STRING]** is actually Iways_DeveloperToolBox, only for internal use.

### PHP Doc Pattern

/**
 \* Ⓒ i-ways sales solutions GmbH
 \*
 \* PHP Version 5
 \*
 \* @category [File|Class]
 \* @package  [MODULE_IDENTIFIER|THEME_IDENTIFIER]
 \* @author   [AUTHOR_NAME] <[AUTHOR_EMAIL]>
 \* @license  The PHP License, Version 3.0 - PHP.net (http://php.net/license/3_0.txt)
 \* @link     https://www.i-ways.net
 */
 
In case of class methods:

/**
 \* Ⓒ i-ways sales solutions GmbH
 \*
 \* PHP Version 5
 \*
 \* @param    [boolean|integer|float|object] [PARAMETER_NAME] [PARAMETER_DESCRIPTION]
 \*
 \* @return   [boolean|integer|float|object]
 */

## Nice to have

- automatic documentation generator, based on code analysis and programmatically stored in each module/theme's readme..

