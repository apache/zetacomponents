<?php
/**
 * File containing the ezcTemplateCompiledCode class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Represents a compiled PHP file on the filesystem which can be generated or
 * executed.
 *
 * If you want to know if a compiled file exists and can be used create a new
 * instance of this and check the isValid() flag.
 *
 * If you are unsure where the compiled file resides you can use the static
 * methods findCurrent() and findAll() to get those identifiers.
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateCompiledCode
{

    /**
     * The unique identifier for the compiled file.
     * @var string
     * @note __get property
     */
    // private $identifier;

    /**
     * The complete (but relative) path to the compiled file. Will be set even if it
     * does not exist.
     * @var string
     * @note __get property
     */
    // private $path;

    /**
     * The context used for the currently compiled file.
     * @var ezcTemplateContext
     * @note __get/__set property
     */
    // private $context;

    /**
     * The template manager which is used when executing the template code.
     *
     * @var ezcTemplateManager
     * @note __get/__set property
     */
    // private $manager;

    /**
     * An array containing the properties of this object.
     * identifier - The unique identifier for the compiled file.
     * path       - The complete (but relative) path to the compiled file. Will
     *              be set even if it does not exist.
     * context    - The context used for the currently compiled file.
     * manager    - The template manager which is used when executing the template
     *              code.
     */
    private $properties = array();

    /**
     * Property get
     */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'identifier':
            case 'path':
            case 'context':
            case 'manager':
                return $this->properties[$name];
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property set
     */
    public function __set( $name, $value )
    {
        switch( $name )
        {
            case 'context':
                if ( $value !== null and
                     !( $value instanceof ezcTemplateOutputContext ) )
                     throw new ezcBaseValueException( $name, $value, 'ezcTemplateOutputContext' );
                $this->properties[$name] = $value;
                break;
            case 'manager':
                if ( $value !== null and
                     !( $value instanceof ezcTemplateManager ) )
                     throw new ezcBaseValueException( $name, $value, 'ezcTemplateManager' );
                $this->properties[$name] = $value;
                break;
            case 'identifier':
            case 'path':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Property isset
     */
    public function __isset( $name )
    {
        switch( $name )
        {
            case 'identifier':
            case 'path':
            case 'context':
            case 'manager':
                return true;
            default:
                return false;
        }
    }

    /**
     * Initialises the object with the identifier and the full path to the PHP file.
     *
     * @param string $identifier
     * @param string $path
     */
    public function __construct( $identifier, $path,
                                 /*ezcTemplateOutputContext*/ $context = null, /*ezcTemplateManager*/ $manager = null )
    {
        $this->properties['identifier'] = $identifier;
        $this->properties['path'] = $path;
        $this->context = $context;
        $this->manager = $manager;
    }

    /**
     * Executes the current compiled file using the source object.
     *
     * The input template variables is taken from the manager.
     *
     * @throw ezcTemplateNoManagerException if there is no manager set.
     * @throw ezcTemplateNoOutputContextException if there is no output context set.
     * @throw ezcTemplateInvalidCompiledFileException if the compiled cannot be executed.
     */
    public function execute()
    {
        if ( $this->manager === null )
            throw new ezcTemplateNoManagerException( __CLASS__, 'manager' );
        if ( $this->context === null )
            throw new ezcTemplateNoOutputContextException( __CLASS__, 'context' );

        if ( !$this->isValid() )
            throw new ezcTemplateInvalidCompiledFileException( $this->identifier, $this->path );
        
        $send = clone $this->manager->send;
        $receive = $this->manager->receive;
        return include( $this->path );

        //var_dump ($status);


        // disabled for now
        /*
        if ( false )
        {
            // the included file will use the following local variables:
            // $execution - Holds the output data
            // $manager - The manager
            // $context - The current output context
            // $this - The compiled file, can be queried for info on path etc.
            $manager = $this->manager;
            $context = $this->context;
            $execution->variables = clone $manager->variables;
            $status = include( $this->path );
            if ( $status != 0 )
            {
                // failed
            }
        }
        */
    }

    /**
     * Returns a list of variable (PHP) names which are reserved when executing
     * compiled code. The compiler must make sure none of these are used when
     * generating local PHP variables.
     *
     * @return array
     */
    public static function reservedVariableNames()
    {
        return array( 'manager', 'context', 'execution', 'this' );
    }

    /**
     * Returns true if the compiled code exists and is valid for execution.
     *
     * @return bool
     */
    public function isValid()
    {
        return file_exists( $this->path ) and is_readable( $this->path );
    }

    /**
     * Returns true if the compiled code exists on the filesystem.
     *
     * @return bool
     */
    public function isAvailable()
    {
        return file_exists( $this->path );
    }

    /**
     * Finds the compiled file based on the stream path and template options.
     *
     * Returns the compiled code object which can be used for execution or queried for more info.
     *
     * @param string $location The stream path of the requested template file.
     * @param ezcTemplateOutputContext $context The current output context handler.
     * @param ezcTemplateManager $manager The manager which contains the current settings.
     * @return ezcTemplateCompiledCode
     */
    public static function findCompiled( $location, ezcTemplateOutputContext $context, ezcTemplateManager $manager )
    {
        $options = 'ezcTemplate::options(' .
                   false /*(bool)$manager->outputDebugEnabled*/ . '-' .
                   false /*(bool)$manager->compiledDebugEnabled*/ . ')';
        $identifier = md5( 'ezcTemplateCompiledCode(' . $location . ')' );
        $name = basename( $location, '.tpl' );
        $path = $manager->configuration->compilePath . '/' .
                $context->identifier() . '-' .
                $manager->generateOptionHash() . '/' .
                $name . '-' . $identifier . ".php";
        return new ezcTemplateCompiledCode( $identifier, $path, $context, $manager );
    }
}
?>
