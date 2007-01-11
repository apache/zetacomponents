<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Defines a persistent object id generator.
 *
 * @see ezcPersisentObjectIdProperty for more information on how to use this class.
 *
 * @package PersistentObject
 */
class ezcPersistentGeneratorDefinition extends ezcBaseStruct
{
    /**
     * The name of the class implementing the generator.
     *
     * @var string
     */
    public $class;

    /**
     * Any parameters required by the generator.
     *
     * Parameters should be in the format array('parameterName' => parameterValue )
     *
     * @var array(string=>string)
     */
    public $params;

    /**
     * Constructs a new PersistentGeneratorDefinition
     */
    public function __construct( $class, array $params = array() )
    {
        $this->class = $class;
        $this->params = $params;
    }

    /**
     * Returns a new instance of this class with the data specified by $array.
     *
     * $array contains all the data members of this class in the form:
     * array('member_name'=>value).
     *
     * __set_state makes this class exportable with var_export.
     * var_export() generates code, that calls this method when it
     * is parsed with PHP.
     *
     * @param array(string=>mixed)
     * @return ezcPersistentGeneratorDefinition
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentGeneratorDefinition( $array['class'],
                                                     $array['params'] );
    }
}
?>
