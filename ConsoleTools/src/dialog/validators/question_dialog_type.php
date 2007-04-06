<?php
/**
 * File containing the ezcConsoleQuestionDialogTypeValidator class.
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
class ezcConsoleQuestionDialogTypeValidator implements ezcConsoleQuestionDialogValidator
{
    const TYPE_STRING = 0;
    const TYPE_INT    = 1;
    const TYPE_FLOAT  = 2;
    const TYPE_BOOL   = 3;

    /**
     * Type to be validated (ezcConsoleQuestionDialogValidator::TYPE_*).
     * 
     * @var int
     */
    protected $type;

    /**
     * Default value according to {@see $type}. 
     * 
     * @var mixed
     */
    protected $default;

    /**
     * Create a new question dialog type validator. 
     * 
     * @param int $type      One of ezcConsoleQuestionDialogTypeValidator::TYPE_*.
     * @param mixed $default Default value according to $type.
     * @return void
     */
    public function __construct( $type = self::TYPE_STRING, $default = null )
    {
        if ( $type !== self::TYPE_STRING && $type !== self::TYPE_INT && $type !== self::TYPE_FLOAT && $type !== self::TYPE_BOOL )
        {
            throw new ezcBaseValueException( "type", $type, "ezcConsoleQuestionDialogTypeValidator::TYPE_*" );
        }
        $this->type = $type;
        $this->default = $default;
    }

    /**
     * Returns if the result is of the given type.
     * Returns if the result is of the given type or empty and a default value is set.
     * 
     * @param mixed $result The result to check.
     * @return bool True if the result is valid. Otherwise false.
     */
    public function validate( $result )
    {
        if ( $result === "" )
        {
            return $this->default !== null;
        }
        switch ( $this->type )
        {
            case self::TYPE_INT:
                return is_int( $result );
            case self::TYPE_FLOAT:
                return is_float( $result );
            case self::TYPE_BOOL:
                return is_bool( $result );
            case self::TYPE_STRING:
            default:
                return is_string( $result );
        }
    }

    /**
     * Returns the manipulated value.
     * Returns the value casted into the correct type or the default value, if
     * it exists and the result is empty.
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
        switch ( $this->type )
        {
            case self::TYPE_INT:
                return ( preg_match( "/^[0-9\-]+$/", $result ) !== 0 ) ? (int) $result : $result;
            case self::TYPE_FLOAT:
                return ( preg_match( "/^[0-9.\-]+$/", $result ) !== 0 ) ? (float) $result : $result;
            case self::TYPE_BOOL:
                return  ( $result === "true" ? true : ( $result === "false" ? false : $result ) );
            case self::TYPE_STRING:
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
        $res = "(<%s>)" . ( $this->default !== null ? " [{$this->default}]" : "" );
        switch ( $this->type )
        {
            case self::TYPE_INT:
                return sprintf( $res, "int" );
            case self::TYPE_FLOAT:
                return sprintf( $res, "float" );
            case self::TYPE_BOOL:
                return sprintf( $res, "bool" );
            case self::TYPE_STRING:
            default:
                return sprintf( $res, "string" );
        }
    }
}

?>
