<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Debug
 * @subpackage Tests
 */

class DebugTestDumpObject
{
    private $private;

    protected $protected;

    public $public;

    public function __construct( $private, $protected, $public )
    {
        $this->private   = $private;
        $this->protected = $protected;
        $this->public    = $public;
    }
}

?>
