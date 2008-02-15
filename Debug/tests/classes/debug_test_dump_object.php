<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
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
