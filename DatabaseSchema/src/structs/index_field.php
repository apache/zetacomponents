<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package DatabaseSchema
 */
/**
 * A container to store a table index' field in.
 *
 * @package DatabaseSchema
 */
class ezcDbSchemaIndexField
{
    /**
     * The sorting of the index (false = descending, true = ascending)
     *
     * @var int
     */
    public $sorting;

    /**
     * Constructs an ezcDbSchemaIndexField object.
     *
     * @var int $sorting
     */
    function __construct( $sorting = null )
    {
        if ( !is_null( $sorting ) && !is_int( $sorting ) )
        {
            $sorting = (int) ( $sorting == 'ascending' ? true : false );
        }
        $this->sorting = $sorting;
    }

    static public function __set_state( array $array )
    {
        return new ezcDbSchemaIndexField(
            $array['sorting']
        );
    }
}
?>
