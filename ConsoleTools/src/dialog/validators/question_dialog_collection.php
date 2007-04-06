<?php
/**
 * File containing the ezcConsoleQuestionDialogCollectionValidator class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Validator class for ezcConsoleQuestionDialog objects that validates a certain datatype.
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcConsoleQuestionDialogCollectionValidator implements ezcConsoleQuestionDialogValidator
{
    const CONVERT_NONE = 0;
    const CONVERT_LOWER = 1;
    const CONVERT_UPPER = 2;

    /**
     * Collection for verification. 
     * 
     * @var array
     */
    protected $collection;

    /**
     * Default value. 
     * 
     * @var mixed
     */
    protected $default;

    /**
     * Conversion for the result. One of ezcConsoleQuestionDialogCollectionValidator::CONVERT_*. 
     * 
     * @var int
     */
    protected $conversion;

    /**
     * Create a new question dialog collection validator. 
     * 
     * @param array $collection The collection to validate against.
     * @param int $conversion   One of ezcConsoleQuestionDialogCollectionValidator::CONVERT_*.
     * @return void
     */
    public function __construct( array $collection, $default = null, $conversion = self::CONVERT_NONE )
    {
        if ( $conversion !== self::CONVERT_NONE && $conversion !== self::CONVERT_UPPER && $conversion !== self::CONVERT_LOWER )
        {
            throw new ezcBaseValueException( "type", $type, "ezcConsoleQuestionDialogCollectionValidator::CONVERT_*" );
        }
        $this->collection = $collection;
        $this->default = $default;
        $this->conversion = $conversion;
    }

    /**
     * Returns if the result is in the collection.
     * Returns if the result is in the collection or if it is empty and a default is set.
     * 
     * @param mixed $result The result to check.
     * @return bool True if the result is valid. Otherwise false.
     */
    public function validate( $result )
    {
        return in_array( $result, $this->collection );
    }

    /**
     * Returns a fixed version of the result, if possible.
     * If the result was empty and a default is set, this one is returned. Else the
     * configured conversion (if any) is performed.
     * 
     * @param mixed $result The result received.
     * @return mixed The manipulated result.
     */
    public function fixup( $result )
    {
        if ( $result === "" && $this->default !== null )
        {
            return $this->default;
        }
        switch ( $this->conversion )
        {
            case self::CONVERT_UPPER:
                return strtoupper( $result );
            case self::CONVERT_LOWER:
                return strtolower( $result );
            default:
                return $result;
        }
    }

    /**
     * Returns a string that indicates valid results.
     * Returns the string that can will be displayed with the question to
     * indicate valid results to the user and a possibly set default, if
     * available.
     * 
     * @return string
     */
    public function getResultString()
    {
        return "(" . implode( "/", $this->collection ) . ")" . ( $this->default !== null ? " [{$this->default}]" : "" );
    }
}

?>
