<?php
/**
 * ezcCacheMemcacheBackendTest 
 * 
 * @package Cache
 * @subpackage Tests
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Test class implementing {@link ezcBaseExportable}.
 * 
 * @package Cache
 * @subpackage Tests
 */
class ezcCacheTestExportable implements ezcBaseExportable
{
    public $string;

    protected $int;

    private $float;

    public function __construct($string, $int, $float)
    {
        $this->string = $string;
        $this->int    = $int;
        $this->float  = $float;
    }

    public static function __set_state( array $state )
    {
        return new ezcCacheTestExportable(
            $state['string'],
            $state['int'],
            $state['float']
        );
    }
}

?>
