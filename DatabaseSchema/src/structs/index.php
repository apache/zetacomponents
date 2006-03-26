<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table index in.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaIndex
{
    /**
     * The fields that make up this index
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
     * @var array(string=>ezcDbSchemaIndexField) $indexFields
     * @var bool  $primary
     * @var bool  $unique
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
