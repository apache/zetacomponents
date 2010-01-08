<?php
/**
 * File containing the ezcReflectionExtension class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Extends the ReflectionExtension class to provide type information
 * using PHPDoc annotations.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionExtension extends ReflectionExtension {

    /**
     * @var ReflectionExtension
     *        ReflectionExtension object of the extension to be reflected
     */
    protected $reflectionSource = null;

    /**
     * Constructs a ezcReflectionExtension object from a given extension
     *
     * Throws an Exception in case the given extension does not exist
     * @param string|ReflectionExtension $extension
     *        Name or ReflectionExtension object of the extension to be
     *        reflected
     */
    public function __construct($extension) {
        if ( $extension instanceof ReflectionExtension ) {
            $this->reflectionSource = $extension;
        } else {
            parent::__construct( $extension );
        }
    }

    /**
     * Use overloading to call additional methods
     * of the ReflectionException instance given to the constructor.
     *
     * @param string $method Method to be called
     * @param array  $arguments Arguments that were passed
     * @return mixed
     */
    public function __call( $method, $arguments )
    {
        $callback = array( $this->reflectionSource, $method );  
        if ( $this->reflectionSource instanceof parent
             and is_callable( $callback ) )
        {
            // query external reflection object
            return call_user_func_array( $callback, $arguments );
        }
        else
        {
            throw new ezcReflectionCallToUndefinedMethodException( __CLASS__, $method );
        }
    }

    /**
     * Returns an array of this extension's fuctions
     * @return ezcReflectionFunction[]
     */
    public function getFunctions() {
        if ( $this->reflectionSource ) {
            $functs = $this->reflectionSource->getFunctions();
        } else {
            $functs = parent::getFunctions();
        }

        $result = array();
        foreach ($functs as $func) {
            $result[] = new ezcReflectionFunction($func);
        }
        return $result;
    }

    /**
     * Returns an array containing ezcReflectionClass objects for all
     * classes of this extension
     * @return ezcReflectionClass[]
     */
    public function getClasses() {
        if ( $this->reflectionSource ) {
            $classes = $this->reflectionSource->getClasses();
        } else {
            $classes = parent::getClasses();
        }

        $result = array();
        foreach ($classes as $class) {
            $result[] = new ezcReflectionClass($class);
        }
        return $result;
    }

    /**
     * Returns a string representation
     * @return string
     */
    public function __toString() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->__toString();
        } else {
            return parent::__toString();
        }
    }

    /**
     * Returns this extension's name
     * @return string
     */
    public function getName() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getName();
        } else {
            return parent::getName();
        }
    }

    /**
     * Returns this extension's version
     * @return string
     */
    public function getVersion() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getVersion();
        } else {
            return parent::getVersion();
        }
    }

    /**
     * Returns an associative array containing this extension's constants and
     * their values
     * @return array<string,mixed>
     */
    public function getConstants() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getConstants();
        } else {
            return parent::getConstants();
        }
    }

    /**
     * Returns an associative array containing this extension's INI entries and
     * their values
     * @return array<string,string>
     */
    public function getINIEntries() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getINIEntries();
        } else {
            return parent::getINIEntries();
        }
    }

    /**
     * Returns an array containing all names of all classes of this extension
     * @return string[]
     */
    public function getClassNames() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getClassNames();
        } else {
            return parent::getClassNames();
        }
    }

    /**
     * Returns an array containing all names of all extensions this extension
     * depends on
     * @return string[]
     */
    public function getDependencies() {
        if ( $this->reflectionSource ) {
            return $this->reflectionSource->getDependencies();
        } else {
            return parent::getDependencies();
        }
    }

    /**
     * Prints phpinfo block for the extension
     * @return void
     */
    public function info() {
        if ( $this->reflectionSource ) {
            $this->reflectionSource->info();
        } else {
            parent::info();
        }
    }

    /**
     * Exports a reflection object.
     *
     * Returns the output if TRUE is specified for return, printing it otherwise.
     * This is purely a wrapper method, which calls the corresponding method of
     * the parent class.
     * @param ReflectionExtension|string $extension
     *        ReflectionExtension object or name of the extension
     * @param boolean $return
     *        Whether to return (TRUE) or print (FALSE) the output
     * @return mixed
     */
    public static function export($extension, $return = false) {
        return parent::export($extension, $return);
    }

}
?>
