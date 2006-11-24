<?php
/**
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Exception that is thrown when an invalid input source is used.
 *
 * @package UserInput
 * @version //autogen//
 */
class ezcInputFormWrongInputSourceException extends ezcInputFormException
{
    function __construct( $inputSource )
    {
        parent::__construct( "Wrong input source '{$inputSource}'." );
    }
}
?>
