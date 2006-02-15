<?php
/**
 * File containing the ezcTemplateDirectResourceLocator class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Locates source and compiled code on file system using the locator string
 * directly.
 *
 * For instance if 'pagelayout.tpl' is requested it will look for the file
 * 'pagelayout.tpl' directly.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateDirectResourceLocator extends ezcTemplateResourceLocator
{

    /**
     * Finds the source code using the location $location and returns a source
     * code object for it.
     *
     * @note The function will not guarantee that the file actually exists,
     *       check that in the returned object.
     *
     * @param string $location The location string which is used to determine the
     *                         real location of the source file. The value is
     *                         directly as the path of the template file.
     * @return ezcTemplateSourceCode
     */
    public function findSource( $location )
    {
        return new ezcTemplateSourceCode( $location );
    }

    /**
     * @todo No code here yet
     */
    public function findCompiled( $location )
    {
    }

}
?>
