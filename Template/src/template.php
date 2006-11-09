<?php
/**
 * File containing the ezcTemplate class.
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * The ezcTemplate class provides the main interface for processing templates.
 *
 * The ezcTemplate class compiles a source template (*.ezt) to PHP code,
 * executes the PHP code, and returns the output. The generated PHP code 
 * will be stored on disk as a compiled template.
 * 
 * If a compiled template already exists of the to process template, the 
 * ezcTemplate class executes directly the compiled template; thus omitting
 * the compile step.
 *
 * The location for the source templates and compiled templates among other things 
 * are specified in the ezcTemplateConfiguration configuration object. A default
 * configuration is always present and can be accessed via the $configuration
 * property.
 * 
 * Usually one configuration object will be enough, since most of the templates
 * will use the same configuration settings. If for some reason, other configuration
 * settings are needed:
 * 
 * - Another ezcTemplateConfiguration object can be assigned to the $configuration property.
 * - Another ezcTemplateConfiguration object can be given to the process method. This
 *   method will use the given configuration instead.
 *
 * The properties $send and $receive are available to set the variables that are
 * set in and retrieved from the template. 
 *
 * The next example demonstrates how a template variable is set and retrieved:
 * 
 * <code>
 * <?php
 * $t = new ezcTemplate();
 *
 * $t->send->mySentence = "Hello world";
 * echo $t->process( "calc_sentence_length.ezt" );
 *
 * $number = $t->receive->length;
 * ?>
 * </code>
 * 
 * The template code:
 * <code>
 * {use $mySentence = ""}
 * 
 * {var $length = str_len( $mySentence )}
 * {return $length}
 * </code>
 * 
 * @package Template
 * @version //autogen//
 */
class ezcTemplate
{
    /**
     * An array containing the properties of this object:
     *
     * @var array(string=>mixed)
     */
    private $properties = array( 'configuration' => null,
                                 'send' => null,
                                 'receive' => null, 
                                 'compiledTemplatePath' => null,
                                 'tstTree' => false,
                                 'astTree' =>  false,
                                 'stream'  => false,
                                 'output' => "",
                               );

    /**
     * Returns the value of the property $name.
     *
     * The properties that can be retrieved are:
     * 
     * - ezcTemplateVariableCollection send     : Contains the variables that are send to the template.
     * - ezcTemplateVariableCollection receive  : Contains the variables that are returned by the template.
     * - ezcTemplateConfiguration configuration : Contains the template configuration.
     * - string output                          : The output of the processed template.
     * - string compiledTemplatePath            : The path of the compiled template.
     * - tstTree                                : The generated tstTree (debug).
     * - astTree                                : The generated astTree (debug).
     * 
     * @throws ezcBasePropertyNotFoundException if the property does not exist.
     * @param string $name
     * @return mixed
     */
    public function __get( $name )
    {
        switch ( $name )
        {
            case 'send': 
            case 'receive':
            case 'tstTree':
            case 'astTree':
            case 'stream':
            case 'compiledTemplatePath':
            case 'output':
                return $this->properties[$name];

            case 'configuration':
                if ( $this->properties[$name] === null )
                {
                       $this->properties[$name] = ezcTemplateConfiguration::getInstance();
                        if ( get_class( $this->properties[$name] ) != 'ezcTemplateConfiguration' )
                        {
                            throw new Exception( "Static method ezcTemplateConfiguration::getInstance() did not return an object of class ezcTemplateConfiguration" );
                        }
                }
                return $this->properties[$name];
            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Returns true if the property $name is set, otherwise false.
     */
    public function __isset( $name )
    {
        switch ( $name )
        {
            case 'configuration':
            case 'compiledTemplatePath':
            case 'send':
            case 'receive':
            case 'tstTree':
            case 'astTree':
            case 'stream':
            case 'output':
                return isset( $name );
            default:
                return false;
        }
    }

    /**
     * Sets the property $name to $value.
     *
     * The properties that can be set are:
     * 
     * - ezcTemplateVariableCollection send     : Contains the variables that are send to the template.
     * - ezcTemplateConfiguration configuration : Contains the template configuration.
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
            case 'send': 
                if ( !$value instanceof ezcTemplateVariableCollection )
                {
                    throw new ezcBaseValueException( $name, $value, 'ezcTemplateVariableCollection' );
                } 
                $this->properties[$name] = $value; 
                break;

            case 'configuration':
                if ( $value !== null and !( $value instanceof ezcTemplateConfiguration ) )
                {
                     throw new ezcBaseValueException( $name, $value, 'ezcTemplateConfiguration' );
                }
                $this->properties[$name] = $value;
                break;

            case 'tstTree':
            case 'astTree':
            case 'compiledTemplatePath':
            case 'output':
            case 'stream':
            case 'receive':
                throw new ezcBasePropertyPermissionException( $name, ezcBasePropertyPermissionException::READ );

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }

    /**
     * Intializes the ezcTemplate with the default settings.
     */
    public function __construct()
    {
        $this->properties["send"] = new ezcTemplateVariableCollection();
        $this->properties["receive"] = new ezcTemplateVariableCollection();
    }

    /**
     * Processes the specified template source and returns the output string.
     *
     * @note The first time a template is accessed it needs to be compiled so the
     * execution time will be higher than subsequent calls.
     *
     * @return string
     *
     * @throws ezcTemplateParserException
     *         If the template could not be compiled.
     * @throws ezcTemplateFileNotWriteableException
     *         If the directory could not be created.
     */
    public function process( $location, ezcTemplateConfiguration $config = null )
    {
        if ( $config === null )
        {
            $config = $this->configuration;
        }

        $this->properties["tstTree"] = false;
        $this->properties["astTree"] = false;
        $this->properties["stream"] = false;
        $this->properties["stream"] = $location;

        if ( strlen( $this->properties["stream"] ) > 0 && $this->properties["stream"][0] != "/" ) // Is it a relative path?
        {
            $this->properties["stream"] = $config->templatePath . DIRECTORY_SEPARATOR . $this->properties["stream"];
        }

        // lookup compiled code here
        $compiled = ezcTemplateCompiledCode::findCompiled( $this->properties["stream"], $config->context, $this );
        $this->properties["compiledTemplatePath"] = $compiled->path;

        
        if ( !file_exists( $compiled->path ) || (
            $config->checkModifiedTemplates &&
            // Do not recompile when the modification times are the same. This messes up the caching tests. 
            file_exists( $this->properties["stream"] ) && filemtime( $this->properties["stream"] ) > filemtime( $compiled->path ) )
        )
        {
            $this->createDirectory( dirname( $compiled->path ) );

            // get the compiled path.
            // use parser here
            $source = new ezcTemplateSourceCode( $this->properties["stream"], $this->properties["stream"] );
            $source->load();
            $parser = new ezcTemplateParser( $source, $this );
            $this->properties["tstTree"] = $parser->parseIntoNodeTree();

            $tstToAst = new ezcTemplateTstToAstTransformer( $parser );
            $this->properties["tstTree"]->accept( $tstToAst );

            $this->properties["astTree"] = $tstToAst->programNode;

            $astToAst = new ezcTemplateAstToAstContextAppender( $config->context );
            $tstToAst->programNode->accept( $astToAst );

            // Extra optimization.
            $astToAst = new ezcTemplateAstToAstAssignmentOptimizer();
            $tstToAst->programNode->accept( $astToAst );

            // Run the cacher.
            $astToAst = new ezcTemplateAstToAstCache( $this );
            $tstToAst->programNode->accept( $astToAst );

            $g = new ezcTemplateAstToPhpGenerator( $compiled->path ); // Write to the file.
            $tstToAst->programNode->accept( $g );
        }

        // execute compiled code here
        $this->properties["output"] = $compiled->execute();

        return $this->properties["output"];
    }

    /**
     * Creates the directory $path if it does not exist 
     *
     * If the directory $path could be created the function returns true,
     * otherwise the ezcTemplateFileNotWriteableException exception is thrown.
     *
     * @throws ezcTemplateFileNotWriteableException
     *         If the directory could not be created
     * @param string $path
     * @return bool
     */
    private function createDirectory( $path )
    {
        if ( !is_dir( $path ) )
        {
            $created = @mkdir( $path, 0700, true );
            if ( !$created )
            {
                throw new ezcTemplateFileNotWriteableException( $path );
            }
        }

        return true;
    }

    /**
     * Generates a unique hash from the current options.
     */
    public function generateOptionHash()
    {
        return base_convert( crc32( 'ezcTemplate::options(' .
                                    false /*(bool)$this->outputDebugEnabled*/ . '-' .
                                    false /*(bool)$this->compiledDebugEnabled*/ . ')' ),
                             10, 36 );
    }

//   /**
//     * Locates the source template file named $source and returns an
//     * ezcTemplateSource object which can be queried.
//     *
//     * @param string $source The source name of the template source to find.
//     * @return ezcTemplateSource
//     */
//    public function findSource( $source )
//    {
//        $location = ezcTemplateResourceLocator::parseLocationString( $source );
//        if ( $location->locator )
//        {
//            if ( !isset( $this->resourceLocators[$location->locator] ) )
//                throw new ezcTemplateLocatorNotFound( $location );
//            $locator = $this->resourceLocators[$location->locator];
//        }
//        else
//        {
//            $locator = $this->defaultLocator;
//            // create the default if it does not exist
//            if ( $locator === null )
//                $locator = new ezcTemplateDirectResourceLocator();
//        }
//
//        return $locator->findSource( $location->stream );
//    }
}
?>
