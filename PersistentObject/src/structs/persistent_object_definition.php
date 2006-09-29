<?php
/**
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @package PersistentObject
 */

/**
 * Main definition of a persistent object.
 *
 * Each persistent object will have exactly one definition. The purpose of
 * the definition is to provide information about how the database table is structured
 * and how it is mapped to the data object.
 *
 * @see ezcPersistentSession for an elaborate example.
 *
 * @package PersistentObject
 * @mainclass
 */
class ezcPersistentObjectDefinition extends ezcBaseStruct
{
    /**
     * Name of the database table to use.
     *
     * @var string
     */
    public $table = null;

    /**
     * Class-name of the PersistentObject
     *
     * @var string
     */
    public $class = null;

    /**
     * Holds the identifier property.
     *
     * @var ezcPersistentObjectIdProperty
     */
    public $idProperty = null;

    /**
     * The fields of the Persistent Object as an array of ezcPersistentObjectProperty.
     * The key is the name of the persistent object field name.
     *
     * @var array(string=>ezcPersistentObjectProperty)
     */
    public $properties = array();

    /**
     * The fields of the Persistent Object as an array of ezcPersistentObjectProperty.
     * The key is the name of the original database column.
     *
     * @var array(string=>ezcPersistentObjectProperty)
     */
    public $columns = array();

    /**
     * Contains the relations of this object. An array indexed by class names
     * of the related object, assigned to a instance of a class derived from
     * ezcPersistentRelation.
     * 
     * @var array(string=>ezcPersistentRelation)
     */
    public $relations = array();

    /**
     * Constructs a new PersistentObjectDefinition.
     *
     * The parameters $key and $incrementKey are not used any more and will be removed
     * next time we can break backwards compatibility.
     *
     * @apichange Remove parameters $key and $incrementKey and add idProperty and $properties.
     */
    public function __construct( $table = '',
                                 $key = '',
                                 $class = '',
                                 $incrementKey = '',
                                 array $properties = array(),
                                 array $relations = array() )
    {
        $this->table = $table;
        $this->class = $class;
        $this->properties = $properties;
        $this->relations = $relations;
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
     * @return ezcPersistentObjectDefinition
     */
    public static function __set_state( array $array )
    {
        return new ezcPersistentObjectDefinition( $array['table'],
                                                  $array['primaryKey'],
                                                  $array['class'],
                                                  $array['incrementKey'],
                                                  $array['properties'],
                                                  $array['relations'] );
    }
}
?>
