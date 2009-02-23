<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table index in.
 *
 * @package DatabaseSchema
 * @version //autogentag//
 */
class ezcDbSchemaIndex extends ezcBaseStruct
{
    /**
     * The fields that make up this index
     *
     * The array is indexed with the name of the field.
     *
     * @var array(string=>ezcDbSchemaIndexField)
     */
    public $indexFields;

    /**
     * Whether this is the primary index for a table.
     *
     * @var bool
     */
    public $primary;

    /**
     * Whether entries in this index need to be unique.
     *
     * @var bool
     */
    public $unique;

    /**
     * Constructs an ezcDbSchemaIndex object.
     *
     * @param array(string=>ezcDbSchemaIndexField) $indexFields
     * @param bool  $primary
     * @param bool  $unique
     */
    function __construct( $indexFields, $primary = false, $unique = true )
    {
        ksort( $indexFields );
        $this->indexFields = $indexFields;
        $this->primary = (bool) $primary;
        $this->unique = (bool) $unique;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaIndex(
             $array['indexFields'], $array['primary'], $array['unique']
        );
    }
}
?>
