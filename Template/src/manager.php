<?php
/**
 * File containing the ezcTemplateManager class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * The main manager for templates which dispatches work to the specific classes.
 *
 * The manager is the main access point for processing source template into text
 * output. The manager keeps track of the current settings and uses other classes
 * to get the work done.
 *
 * The manager uses the ezcTemplateConfiguration class to keep track of
 * autoloaders and resource locators. Usually there is only one configuration
 * object which can be shared among multiple manager, this makes sense since you
 * want the same configuration among your code. If you wish to change this you
 * can assign a new configuration object using the $configuration member variable.
 *
 * The initial value of the configuration is null which means it will create a
 * new object for it, it will search for a function named
 * ezcTemplateInitConfiguration() if found it will call it and expects it to
 * return a configuration object. If this not found it creates a new plain
 * ezcTemplateConfiguration object.
 *
 * Using the manager is as simple as setting some variables with setVariable()
 * and then call process() with the name of the wanted source template.
 * <code>
 * $tpl = new ezcTemplateManager();
 * $tpl->setVariable( "survivor", "Kazan" );
 * echo $tpl->process( "cube.tpl" );
 * </code>
 *
 * More advanced variable management is possible with the functions:
 * setVariable(), getVariable(), removeVariable(), hasVariable() and
 * resetVariables().
 *
 * Accessing the source template or compiled file is also possible with the use
 * of the findSource() and findCompiled() functions. They will return objects
 * which can be further accessed.
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateManager
{

    /**
     * A collection containing all input variables. This collection will be
     * passed onto the executed template to be as template variables.
     *
     * @note Use setVariable(), removeVariable(), resetVariables() to modify the
     * variables and getVariable(), hasVariable() to query them.
     * 
     * var ezcTemplateVariableCollection
     */
    private $variables;

    /**
     * Controls whether debugging should be part of the processed output.
     */
    public $outputDebugEnabled = false;

    /**
     * Controls whether debugging info the compiled code should be added.
     */
    public $compiledDebugEnabled = false;

    public $tstTree;

    public $astTree;

    public $compiledTemplatePath;

    /**
     * The configuration object which handles autoloaders and resource locators.
     *
     * @var ezcTemplateConfiguration
     * @note __get/__set property
     */
    // public $configuration;

    /**
     * The default output context used when parsing and executing templates.
     *
     * @var ezcTemplateContext
     * @note __get/__set property
     */
    // public $defaultContext;

    /**
     * An array containing the properties of this object:
     * configuration - The configuration object which handles autoloaders and resource locators.
     *
     * defaultContext - The default output context used when parsing and executing templates.
     */
    private $properties = array( 'configuration' => null,
                                 'defaultContext' => null,
                                 'send' => null,
                                 'receive' => null, );

    /**
     * Property get
     */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'send': 
            case 'receive':
                return $this->properties[$name];

            case 'defaultContext':
                if ( $this->properties[$name] === null )
                    $this->properties[$name] = new ezcTemplateXhtmlContext();
                return $this->properties[$name];
            case 'configuration':
                if ( $this->properties[$name] === null )
                {
                    if ( function_exists( 'ezcTemplateInitConfiguration' ) )
                    {
                        $this->properties[$name] = ezcTemplateInitConfiguration();
                        if ( get_class( $this->properties[$name] ) != 'ezcTemplateConfiguration' )
                            throw new Exception( "function ezcTemplateInitConfiguration() did not return an object of class ezcTemplateConfiguration" );
                    }
                    else
                    {
                        $this->properties[$name] = ezcTemplateConfiguration::getInstance();
                        if ( get_class( $this->properties[$name] ) != 'ezcTemplateConfiguration' )
                        {
//                            throw new Exception( "Static method ezcTemplateConfiguration::getInstance() did not return an object of class ezcTemplateConfiguration" );
                            $this->properties[$name] = new ezcTemplateConfiguration();
                        }
                    }
                }
                return $this->properties[$name];
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
            case 'configuration':
            case 'defaultContext':
                return true;
            default:
                return false;
        }
    }

    /**
     * Property set
     */
    public function __set( $name, $value )
    {
        switch( $name )
        {
            case 'send': 
            case 'receive':
                if( !$value instanceof ezcTemplateVariableCollection )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcTemplateVariableCollection' );
                } 
                $this->properties[$name] = $value; 
                break;

            case 'configuration':
                if ( $value !== null and
                     !( $value instanceof ezcTemplateConfiguration ) )
                     throw new ezcBaseValueException( $name, $value, 'ezcTemplateConfiguration' );
                $this->properties[$name] = $value;
                break;
            case 'defaultContext':
                if ( $value !== null and
                     !( $value instanceof ezcTemplateContext ) )
                     throw new ezcBaseValueException( $name, $value, 'ezcTemplateContext' );
                $this->properties[$name] = $value;
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Intializes the manager with the default settings.
     *
     * @param ezcTemplateContext $defaultContext The default context for processing,
     * if set to null it will use ezcTemplateXhtmlContext.
     */
    public function __construct( /*ezcTemplateContext*/ $defaultContext = null )
    {
        //$this->variables = new ezcTemplateVariableCollection();
        $this->properties["send"] = new ezcTemplateVariableCollection();
        $this->properties["receive"] = new ezcTemplateVariableCollection();

        $this->defaultContext = $defaultContext;
    }

    /**
     * Processes the specified template source and returns the result as a string.
     *
     * The type of output can be adjusted by passing the output context object
     * $context.
     *
     * @note The first time a template is accessed it needs to be compiled so the
     * execution time will be higher than subsequent calls.
     *
     * @param string $location The resource location defining which template to process.
     * @param ezcTemplateContext $context The current context for the processing.
     * @return ezcTemplateExecution
     *
     * @throw ezcTemplateLocatorNotFound when the requested locator identifier
     *        is not registered in the system.
     */
    public function process( $location, /*ezcTemplateContext*/ $context = null )
    {
        $this->tstTree = false;
        $this->astTree = false;
        $this->compiledTemplatePath = false;

        $locator = false;
        $stream = false;
        if ( preg_match( "#^([a-zA-Z0-9_]+):(.*)$#", $location, $matches ) )
            list( $locator, $stream ) = array_splice( $matches, 1 );
        else
        {
            $stream = $location;
        }

        if( $stream[0] != "/" ) // Is it a relative path?
        {
            $stream = $this->configuration->templatePath ."/". $stream;
        }

        // If we have a locator defined we use that for finding the real location
        if ( $locator )
        {
            if ( !isset( $this->resourceLocators[$locator] ) )
                throw new ezcTemplateLocatorNotFoundException( new ezcTemplateLocation( $locator, $stream ) );
            $source = $this->resourceLocators[$locator]->findSource( $stream );
        }
        else
        {
            $source = new ezcTemplateSourceCode( $stream, $stream );
        }

        // lookup compiled code here
        $compiled = ezcTemplateCompiledCode::findCompiled( $source->stream, $this->defaultContext, $this );
        $this->createDirectory( dirname( $compiled->path ) );
        $this->compiledTemplatePath = $compiled->path;

        // if exists then skip the next lines...

        // get the compiled path.
        // use parser here
        $source->load();
        $parser = new ezcTemplateParser( $source, $this );
        $this->tstTree = $parser->parseIntoNodeTree();

        $tstToAst = new ezcTemplateTstToAstTransformer( $parser );
        $this->tstTree->accept( $tstToAst );

        // Extra optimization.
        //$astToAst = new ezcTemplateAstToAstAssignmentOptimizer();
        //$tstToAst->programNode->accept( $astToAst );

//        $astToAst = new ezcTemplateAstToAstContextAppender();
        //$tstToAst->programNode->accept( $astToAst );

        $this->astTree = $tstToAst->programNode;

        $g = new ezcTemplateAstToPhpGenerator( $compiled->path ); // Write to the file.
        $tstToAst->programNode->accept($g);

        // execute compiled code here
        $result = new ezcTemplateExecutionResult( false, new ezcTemplateVariableCollection());//clone $this->variables );
        $compiled->execute( $result );

        return $result;
    }

    private function createDirectory( $path )
    {
        if( !is_dir( $path ) )
        {
            return mkdir( $path, 0700, true );
        }

        return true;
    }

    /**
     * Generates a unique hash from the current options which
     */
    public function generateOptionHash()
    {
        return base_convert( crc32( 'ezcTemplate::options(' .
                                    (bool)$this->outputDebugEnabled . '-' .
                                    (bool)$this->compiledDebugEnabled . ')' ),
                             10, 36 );
    }

    /**
     * Defines an input template variable named $name with value $value.
     * If the variable exists it is overwritten.
     *
     * This variable can be accessed later on in the executed template.
     *
     * @note The variable is not set using a reference.
     *
     * @param string $name Name of the variable to set.
     * @param mixed $value The value the variable should get.
     */
//    public function defineInput( $name, $value )
//    {
//        $this->variables->defineInput( $name, $value );
//    }
//
//    /**
//     * Defines an output template variable named $name.
//     * If the variable exists it is overwritten.
//     *
//     * This variable can be accessed later on in the executed template.
//     *
//     * @note The variable is not set using a reference.
//     *
//     * @param string $name Name of the variable to set.
//     * @param mixed $value The value the variable should get.
//     */
//    public function defineOutput( $name )
//    {
//        $this->variables->defineOutput( $name );
//    }
//
//    /**
//     * Removes the registered variable $name from the global list.
//     *
//     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
//     * @see hasVariable
//     *
//     * @param string $name Name of the variable to remove.
//     */
//    public function removeVariable( $name )
//    {
//        $this->variables->removeVariable( $name );
//    }
//
//    /**
//     * Removes all registered variables from the global list.
//     *
//     * @see hasVariable
//     *
//     */
//    public function resetVariables()
//    {
//        $this->variables->resetVariables();
//    }
//
//    /**
//     * Returns the value of the registered output variable $name from the global
//     * list.
//     *
//     * @throw ezcTemplateVariableUndefinedException if the variable does not
//     * exist.
//     * @see hasVariable
//     *
//     * @param string $name Name of the variable to return.
//     * @return mixed
//     */
//    public function getOutputValue( $name )
//    {
//        $this->variables->getOutputValue( $name );
//    }
//
//    /**
//     * Checks if the variable named $name exists and returns the result.
//     *
//     * @param string $name Name of the variable to check for.
//     * @return bool
//     */
//    public function hasVariable( $name )
//    {
//        return $this->variables->hasVariable( $name );
//    }
//
    /**
     * Locates the source template file named $source and returns an
     * ezcTemplateSource object which can be queried.
     *
     * @param string $source The source name of the template source to find.
     * @return ezcTemplateSource
     */
    public function findSource( $source )
    {
        $location = ezcTemplateResourceLocator::parseLocationString( $source );
        if ( $location->locator )
        {
            if ( !isset( $this->resourceLocators[$location->locator] ) )
                throw new ezcTemplateLocatorNotFound( $location );
            $locator = $this->resourceLocators[$location->locator];
        }
        else
        {
            $locator = $this->defaultLocator;
            // create the default if it does not exist
            if ( $locator === null )
                $locator = new ezcTemplateDirectResourceLocator();
        }

        return $locator->findSource( $location->stream );
    }

    /**
     * Locates the compiled template file named $source and returns an
     * ezcTemplateCompiledCode object which can be queried.
     *
     * @param string $source The source name of the template source to find.
     * @return ezcTemplateCompiledCode
     */
    public function findCompiled( $source )
    {
    }
}
?>
