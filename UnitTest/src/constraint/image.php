<?php
/**
 * File contaning the class for image comparision
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

require_once 'PHPUnit/Util/Filter.php';

PHPUnit_Util_Filter::addFileToFilter( __FILE__ );

/**
 * Class to test if images are similar
 *
 * @package Unittest
 */
class ezcTestConstraintSimilarImage implements PHPUnit_Framework_Constraint
{

    /**
     * Contains the filename of image to compare with
     * 
     * @var string
     */
    protected $value;

    /**
     * Maximum difference between images
     * 
     * @var int
     */
    protected $delta;

    /**
     * Difference between images
     * 
     * @var int
     */
    protected $difference;

    /**
     * Constructor
     * 
     * @param string $value Filename of the image to compare with
     * @param int $delta Maximum difference between images
     * @return ezcConstraintSimilarImage
     */
    public function __construct( $value, $delta = 0 )
    {
        if ( is_file( $value )  &&
             is_readable( $value ) )
        {
            $this->value = $value;
        }
        else
        {
            throw new ezcBaseFileNotFoundException( $value );
        }

        $this->delta = (int) $delta;
    }

    /**
     * Compares an image
     *
     * Compares an image with another one and returns true if the difference
     * is lower then the defined delta.
     * 
     * @param string $other Filename of the other image
     * @return bool Wheather image is similar enough
     */
    public function evaluate( $other )
    {
        if ( !is_file( $other )  ||
             !is_readable( $other ) )
        {
            throw new ezcBaseFileNotFoundException( $other );
        }

        $return = shell_exec( 'compare -metric MAE ' . escapeshellarg( $this->value ) . ' ' . escapeshellarg( $other ) . ' null:' );
        if ( preg_match( '/([\d.,e]+)\s+dB/', $return, $match ) )
        {
            $this->difference = (int) $match[1];
            return ( $this->difference <= $this->delta );
        }

        return false;
    }

    /**
     * Throws failed exception
     * 
     * @param string $other Filename of compared image
     * @param string $description Description of failure
     * @throw PHPUnit_Framework_ExpectationFailedException
     * @return void
     */
    public function fail( $other, $description )
    {
        throw new PHPUnit_Framework_ExpectationFailedException(
            $description,
            PHPUnit_Framework_ComparisonFailure::diffEqual( $this->delta, $this->difference )
        );
    }

    /**
     * Provide test text
     * 
     * @return string Test description
     */
    public function toString()
    {
        return sprintf( 'is similar to <%s>', 
            $this->value
        );
    }
}

?>
