<?php
/**
 * File containing the ezcDebugMessage class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Holds a debug message and provides functionality to manipulate it.
 *
 * @package Debug
 * @version //autogentag//
 * @access private
 */
class ezcDebugMessage extends ezcLogMessage
{
    /**
     * Sets the property $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'verbosity': 
                $this->properties['verbosity'] = $value;
                return;
        }

        return parent::__set( $name, $value );
    }

    /**
     * Returns the property $name.
     *
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'verbosity':
                return $this->properties['verbosity'];
                break;
        }

        return parent::__get( $name );
    }

    /**
     * Constructs the ezcDebugMessage from the message $message and $severity, $defaultSource and $defaultCategory.     *
     * $message is parsed by parseMessage() and must be in the format it accepts.
     *
     * @param string $message
     * @param int $severity
     * @param string $defaultSource Use this source when not given in the message itself.
     * @param string $defaultCategory Use this category when not give in the message itself.
     */
    public function __construct( $message, $severity, $defaultSource, $defaultCategory )
    {
        $this->parseMessage( $message, $severity, $defaultSource, $defaultCategory );
    }

    /**
     * Parses the message $message and $severity, $defaultSource and $defaultCategory and sets the properties of this object accordingly.
     *
     * Parses a message usually given to the trigger_error method. Properties will
     * be set according to the message.
     *
     * @param string $message
     * @param int $severity
     * @param string $defaultSource Use this source when not given in the
     *                               message itself.
     * @param string $defaultCategory  Use this category when not give in the
     *                                 message itself.
     * @return void
     */
    public function parseMessage( $message, $severity, $defaultSource, $defaultCategory )
    {
        preg_match( "/^\s*(?:\[([^,\]]*)(?:,\s(.*))?\])?\s*(?:(\d+):)?\s*(.*)$/", $message, $matches );

        $this->message = ( strcmp( $matches[4], "" ) == 0 ? false : $matches[4] );
        $this->verbosity = ( strcmp( $matches[3], "" ) == 0 ? false : $matches[3] );

        if ( strlen( $matches[2] ) == 0 )
        {
            $this->category = ( strcmp( $matches[1], "" ) == 0 ? $defaultCategory : $matches[1] );
            $this->source = $defaultSource;
        }
        else
        {
            $this->category = $matches[2];
            $this->source = $matches[1];
        }

        switch ( $severity )
        {
            case E_USER_NOTICE:  $this->severity = ezcLog::NOTICE; break;
            case E_USER_WARNING: $this->severity = ezcLog::WARNING; break;
            case E_USER_ERROR:  $this->severity = ezcLog::ERROR; break;
            default: $this->severity = false;
        }

    }
}
?>
