<?php
/**
 * File containing the ezcDocumentPcssDirective class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Pdf CSS layout directive.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
abstract class ezcDocumentPcssDirective extends ezcBaseStruct
{
    /**
     * Directive address
     *
     * @var mixed
     */
    public $address;

    /**
     * Array of formatting rules
     *
     * @var array
     */
    public $formats;

    /**
     * File, directive has been extracted from
     *
     * @var string
     */
    public $file;

    /**
     * Line of directive
     *
     * @var int
     */
    public $line;

    /**
     * Position of directive
     *
     * @var int
     */
    public $position;

    /**
     * Regular expression compiled from directive address
     *
     * @var string
     */
    protected $regularExpression = null;

    /**
     * Construct directive from address and formats
     *
     * @param string $address
     * @param array $formats
     * @return void
     */
    public function __construct( $address, array $formats, $file = null, $line = null, $position = null )
    {
        $this->address  = $address;
        $this->formats  = $formats;
        $this->file     = $file;
        $this->line     = $line;
        $this->position = $position;
    }
}
?>
