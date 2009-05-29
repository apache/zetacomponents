<?php
/**
 * File containing the ezcConsoleInput class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * The ezcConsoleInput class handles the given options and arguments on the console.
 * 
 * This class allows the complete handling of options and arguments submitted
 * to a console based application.
 *
 * The next example demonstrate how to capture the console options: 
 * 
 * <code>
 * $optionHandler = new ezcConsoleInput();
 * 
 * // Register simple parameter -h/--help
 * $optionHandler->registerOption( new ezcConsoleOption( 'h', 'help' ) );
 * 
 * // Register complex parameter -f/--file
 * $file = new ezcConsoleOption(
 *  'f',
 *  'file',
 *  ezcConsoleInput::TYPE_STRING,
 *  null,
 *  false,
 *  'Process a file.',
 *  'Processes a single file.'
 * );
 * $optionHandler->registerOption( $file );
 * 
 * // Manipulate parameter -f/--file after registration
 * $file->multiple = true;
 * 
 * // Register another complex parameter that depends on -f and excludes -h
 * $dir = new ezcConsoleOption(
 *  'd',
 *  'dir',
 *  ezcConsoleInput::TYPE_STRING,
 *  null,
 *  true,
 *  'Process a directory.',
 *  'Processes a complete directory.',
 *  array( new ezcConsoleOptionRule( $optionHandler->getOption( 'f' ) ) ),
 *  array( new ezcConsoleOptionRule( $optionHandler->getOption( 'h' ) ) )
 * );
 * $optionHandler->registerOption( $dir );
 * 
 * // Register an alias for this parameter
 * $optionHandler->registerAlias( 'e', 'extended-dir', $dir );
 * 
 * // Process registered parameters and handle errors
 * try
 * {
 *      $optionHandler->process( array( 'example_input.php', '-h' ) );
 * }
 * catch ( ezcConsoleOptionException $e )
 * {
 *      echo $e->getMessage();
 *      exit( 1 );
 * }
 * 
 * // Process a single parameter
 * $file = $optionHandler->getOption( 'f' );
 * if ( $file->value === false )
 * {
 *      echo "Parameter -{$file->short}/--{$file->long} was not submitted.\n";
 * }
 * elseif ( $file->value === true )
 * {
 *      echo "Parameter -{$file->short}/--{$file->long} was submitted without value.\n";
 * }
 * else
 * {
 *      echo "Parameter -{$file->short}/--{$file->long} was submitted with value '".var_export($file->value, true)."'.\n";
 * }
 * 
 * // Process all parameters at once:
 * foreach ( $optionHandler->getOptionValues() as $paramShort => $val )
 * {
 *      switch ( true )
 *      {
 *          case $val === false:
 *              echo "Parameter $paramShort was not submitted.\n";
 *              break;
 *          case $val === true:
 *              echo "Parameter $paramShort was submitted without a value.\n";
 *              break;
 *          case is_array( $val ):
 *              echo "Parameter $paramShort was submitted multiple times with value: '".implode(', ', $val)."'.\n";
 *              break;
 *          default:
 *              echo "Parameter $paramShort was submitted with value: '$val'.\n";
 *              break;
 *      }
 * }
 * </code>
 * 
 * @package ConsoleTools
 * @version //autogen//
 * @mainclass
 *
 * @property ezcConsoleArguments $argumentDefinition Optional argument definition.
 */
class ezcConsoleInput
{
    /**
     * Option does not carry a value.
     */
    const TYPE_NONE     = 1;

    /**
     * Option takes an integer value.
     */
    const TYPE_INT      = 2;

    /**
     * Option takes a string value. 
     */
    const TYPE_STRING   = 3;

    /**
     * Array of option definitions, indexed by number.
     *
     * This array stores the ezcConsoleOption objects representing
     * the options.
     *
     * For lookup of an option after its short or long values the attributes
     * {@link ezcConsoleInput::$optionShort}
     * {@link ezcConsoleInput::$optionLong}
     * are used.
     * 
     * @var array(int=>array)
     */
    private $options = array();

    /**
     * Short option names. 
     *
     * Each references a key in {@link ezcConsoleInput::$options}.
     * 
     * @var array(string=>int)
     */
    private $optionShort = array();

    /**
     * Long option names. 
     * 
     * Each references a key in {@link ezcConsoleInput::$options}.
     * 
     * @var array(string=>int)
     */
    private $optionLong = array();

    /**
     * Arguments, if submitted, are stored here. 
     * 
     * @var array(string)
     */
    private $arguments = array();

    /**
     * Wether the process() method has already been called.
     * 
     * @var bool
     */
    private $processed = false;

    /**
     * Indicates if an option was submitted, that has the isHelpOption flag set.
     * 
     * @var bool
     */
    private $helpOptionSet = false;

    /**
     * Collection of arguments. 
     * 
     * @var mixed
     */
    protected $properties = array();

    /**
     * Creates an input handler.
     */
    public function __construct()
    {
        $this->argumentDefinition = null;
    }

    /**
     * Registers the new option $option.
     *
     * This method adds the new option $option to your option collection. If
     * already an option with the assigned short or long value exists, an
     * exception will be thrown.
     *
     * @see ezcConsoleInput::unregisterOption()
     *
     * @param ezcConsoleOption $option
     *
     * @return ezcConsoleOption The recently registered option.
     */
    public function registerOption( ezcConsoleOption $option )
    {
        foreach ( $this->optionShort as $short => $ref )
        {
            if ( $short === $option->short ) 
            {
                throw new ezcConsoleOptionAlreadyRegisteredException( $short );
            }
        }
        foreach ( $this->optionLong as $long => $ref )
        {
            if ( $long === $option->long ) 
            {
                throw new ezcConsoleOptionAlreadyRegisteredException( $long );
            }
        }
        $this->options[] = $option;
        $this->optionLong[$option->long] = $option;
        if ( $option->short !== "" )
        {
            $this->optionShort[$option->short] = $option;
        }
        return $option;
    }

    /**
     * Registers an alias for an option.
     *
     * Registers a new alias for an existing option. Aliases can
     * be used as if they were a normal option.
     *
     * The alias is registered with the short option name $short and the
     * long option name $long. The alias references to the existing 
     * option $option.
     *
     * @see ezcConsoleInput::unregisterAlias()
     *
     * @param string $short
     * @param string $long
     * @param ezcConsoleOption $option
     *
     *
     * @throws ezcConsoleOptionNotExistsException
     *         If the referenced option is not registered.
     * @throws ezcConsoleOptionAlreadyRegisteredException
     *         If another option/alias has taken the provided short or long name.
     * @return void
     */
    public function registerAlias( $short, $long, ezcConsoleOption $option )
    {
        if ( !isset( $this->optionShort[$option->short] ) || !isset( $this->optionLong[$option->long] ) )
        {
            throw new ezcConsoleOptionNotExistsException( $option->long );
        }
        if ( isset( $this->optionShort[$short] ) || isset( $this->optionLong[$long] ) )
        {
            throw new ezcConsoleOptionAlreadyRegisteredException( isset( $this->optionShort[$short] ) ? "-$short" : "--$long" );
        }
        $this->optionShort[$short] = $option;
        $this->optionLong[$long]   = $option;
    }

    /**
     * Registers options according to a string specification.
     *
     * Accepts a string to define parameters and registers all parameters as
     * options accordingly. String definition, specified in $optionDef, looks
     * like this:
     *
     * <code>
     * [s:|size:][u:|user:][a:|all:]
     * </code>
     *
     * This string registers 3 parameters:
     * -s / --size
     * -u / --user
     * -a / --all
     *
     * @param string $optionDef
     * @return void
     * 
     * @throws ezcConsoleOptionStringNotWellformedException 
     *         If provided string does not have the correct format.
     */
    public function registerOptionString( $optionDef ) 
    {
        $regex = '\[([a-z0-9-]+)([:?*+])?([^|]*)\|([a-z0-9-]+)([:?*+])?\]';
        // Check string for wellformedness
        if ( preg_match( "/^($regex)+$/", $optionDef ) == 0 )
        {
            throw new ezcConsoleOptionStringNotWellformedException( "Option definition not wellformed: \"$optionDef\"" );
        }
        if ( preg_match_all( "/$regex/", $optionDef, $matches ) )
        {
            foreach ( $matches[1] as $id => $short )
            {
                $option = null;
                $option = new ezcConsoleOption( $short, $matches[4][$id] );
                if ( !empty( $matches[2][$id] ) || !empty( $matches[5][$id] ) )
                {
                    switch ( !empty( $matches[2][$id] ) ? $matches[2][$id] : $matches[5][$id] )
                    {
                        case '*':
                            // Allows 0 or more occurances
                            $option->multiple = true;
                            break;
                        case '+':
                            // Allows 1 or more occurances
                            $option->multiple = true;
                            $option->type = self::TYPE_STRING;
                            break;
                        case '?':
                            $option->type = self::TYPE_STRING;
                            $option->default = '';
                            break;
                        default:
                            break;
                    }
                }
                if ( !empty( $matches[3][$id] ) )
                {
                    $option->default = $matches[3][$id];
                }
                $this->registerOption( $option );
            }
        }
    }

    /**
     * Removes an option.
     *
     * This function removes an option. All dependencies to that 
     * specific option are removed completely from every other registered 
     * option.
     *
     * @see ezcConsoleInput::registerOption()
     *
     * @param ezcConsoleOption $option The option object to unregister.
     *
     * @throws ezcConsoleOptionNotExistsException
     *         If requesting a not registered option.
     * @return void
     */
    public function unregisterOption( ezcConsoleOption $option )
    {
        $found = false;
        foreach ( $this->options as $id => $existParam )
        {
            if ( $existParam === $option )
            {
                $found = true;
                unset( $this->options[$id] );
                continue;
            }
            $existParam->removeAllExclusions( $option );
            $existParam->removeAllDependencies( $option );
        }
        if ( $found === false )
        {
            throw new ezcConsoleOptionNotExistsException( $option->long );
        }
        foreach ( $this->optionLong as $name => $existParam )
        {
            if ( $existParam === $option )
            {
                unset( $this->optionLong[$name] );
            }
        }
        foreach ( $this->optionShort as $name => $existParam )
        {
            if ( $existParam === $option )
            {
                unset( $this->optionShort[$name] );
            }
        }
    }
    
    /**
     * Removes an alias to an option.
     *
     * This function removes an alias with the short name $short and long
     * name $long.
     *
     * @see ezcConsoleInput::registerAlias()
     * 
     * @throws ezcConsoleOptionNoAliasException
     *      If the requested short/long name belongs to a real parameter instead.
     *
     * @param string $short
     * @param string $long
     * @return void
     *
     * @todo Check if $short and $long refer to the same option!
     */
    public function unregisterAlias( $short, $long )
    {
        foreach ( $this->options as $id => $option )
        {
            if ( $option->short === $short )
            {
                throw new ezcConsoleOptionNoAliasException( $short );
            }
            if ( $option->long === $long )
            {
                throw new ezcConsoleOptionNoAliasException( $long );
            }
        }
        if ( isset( $this->optionShort[$short] ) )
        {
            unset( $this->optionShort[$short] );
        }
        if ( isset( $this->optionLong[$long] ) )
        {
            unset( $this->optionLong[$long] );
        }
    }

    /**
     * Returns the definition object for the option with the name $name.
     *
     * This method receives the long or short name of an option and
     * returns the ezcConsoleOption object.
     * 
     * @param string $name  Short or long name of the option (without - or --).
     * @return ezcConsoleOption
     *
     * @throws ezcConsoleOptionNotExistsException 
     *         If requesting a not registered parameter.
     */
    public function getOption( $name )
    {
        $name = $name;
        if ( isset( $this->optionShort[$name] ) )
        {
            return $this->optionShort[$name];
        }
        if ( isset( $this->optionLong[$name] ) )
        {
            return $this->optionLong[$name];
        }
        throw new ezcConsoleOptionNotExistsException( $name );
    }

    /**
     * Process the input parameters.
     *
     * Actually process the input options and arguments according to the actual 
     * settings.
     * 
     * Per default this method uses $argc and $argv for processing. You can 
     * override this setting with your own input, if necessary, using the
     * parameters of this method. (Attention, first argument is always the pro
     * gram name itself!)
     *
     * All exceptions thrown by this method contain an additional attribute "option"
     * which specifies the parameter on which the error occurred.
     * 
     * @param array(int=>string) $args The arguments
     * @return void
     *
     * @throws ezcConsoleOptionNotExistsException 
     *         If an option that was submitted does not exist.
     * @throws ezcConsoleOptionDependencyViolationException
     *         If a dependency rule was violated. 
     * @throws ezcConsoleOptionExclusionViolationException 
     *         If an exclusion rule was violated.
     * @throws ezcConsoleOptionTypeViolationException 
     *         If the type of a submitted value violates the options type rule.
     * @throws ezcConsoleOptionArgumentsViolationException 
     *         If arguments are passed although a parameter disallowed them.
     *
     * @see ezcConsoleOptionException
     */ 
    public function process( array $args = null )
    {
        if ( $this->processed )
        {
            $this->reset();
        }
        $this->processed = true;

        if ( !isset( $args ) )
        {
            $args = isset( $argv ) ? $argv : isset( $_SERVER['argv'] ) ? $_SERVER['argv'] : array();
        }
        $i = 1;
        while ( $i < count( $args ) )
        {
            // Equalize parameter handling (long params with =)
            if ( substr( $args[$i], 0, 2 ) == '--' )
            {
                $this->preprocessLongOption( $args, $i );
            }
            // Check for parameter
            if ( substr( $args[$i], 0, 1 ) === '-' && $this->hasOption( preg_replace( '/^-*/', '', $args[$i] ) ) !== false )
            {
                $this->processOptions( $args, $i );
            }
            // Looks like parameter, but is not available??
            elseif ( substr( $args[$i], 0, 1 ) === '-' && trim( $args[$i] ) !== '--' )
            {
                throw new ezcConsoleOptionNotExistsException( $args[$i] );
            }
            // Must be the arguments
            else
            {
                break;
            }
        }
        // Move pointer
        isset( $args[$i] ) && $args[$i] == '--' ? ++$i : $i;

        if ( $this->helpOptionSet() )
        {
            // No need to parse arguments
            return;
        }
        $this->processArguments( $args, $i );
        $this->checkRules();
    }

    /**
     * Resets all option and argument values.
     *
     * This method is called automatically by {@link process()}, if this method
     * is called twice or more, and may also be used to manually reset the
     * values of all registered {@ezcConsoleOption} and {@link
     * ezcConsoleArgument} objects.
     */
    public function reset()
    {
        foreach ( $this->options as $option )
        {
            $option->value = false;
        }
        if ( $this->argumentDefinition !== null )
        {
            foreach ( $this->argumentDefinition as $argument )
            {
                $argument->value = null;
            }
        }
        $this->arguments = array();
    }

    /**
     * Returns true if an option with the given name exists, otherwise false.
     *
     * Checks if an option with the given name is registered.
     * 
     * @param string $name Short or long name of the option.
     * @return bool True if option exists, otherwise false.
     */
    public function hasOption( $name )
    {
        try
        {
            $param = $this->getOption( $name );
        }
        catch ( ezcConsoleOptionNotExistsException $e )
        {
            return false;
        }
        return true;
    }

    /**
     * Returns an array of all registered options.
     *
     * Returns an array of all registered options in the following format:
     * <code>
     * array( 
     *      0 => ezcConsoleOption,
     *      1 => ezcConsoleOption,
     *      2 => ezcConsoleOption,
     *      ...
     * );
     * </code>
     *
     * @return array(string=>ezcConsoleOption) Registered options.
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Returns the values of all submitted options.
     *
     * Returns an array of all values submitted to the options. The array is 
     * indexed by the parameters short name (excluding the '-' prefix). The array
     * does not contain any parameter, which value is 'false' (meaning: the
     * parameter was not submitted).
     * 
     * @param bool $longnames Wheather to use longnames for indexing.
     * @return array(string=>mixed)
     */
    public function getOptionValues( $longnames = false )
    {
        $res = array();
        foreach ( $this->options as $param )
        {
            if ( $param->value !== false ) 
            {
                $res[( $longnames === true ) ? $param->long : $param->short] = $param->value;
            }
        }
        return $res;
    }

    /**
     * Returns arguments provided to the program.
     *
     * This method returns all arguments provided to a program in an
     * int indexed array. Arguments are sorted in the way
     * they are submitted to the program. You can disable arguments
     * through the 'arguments' flag of a parameter, if you want
     * to disallow arguments.
     *
     * Arguments are either the last part of the program call (if the
     * last parameter is not a 'multiple' one) or divided via the '--'
     * method which is commonly used on Unix (if the last parameter
     * accepts multiple values this is required).
     *
     * @return array(int=>string) Arguments.
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Get help information for your options.
     *
     * This method returns an array of help information for your options,
     * indexed by int. Each help info has 2 fields:
     *
     * 0 => The options names ("<short> / <long>")
     * 1 => The help text (depending on the $long parameter)
     *
     * The $long options determines if you want to get the short or long help
     * texts. The array returned can be used by {@link ezcConsoleTable}.
     *
     * If using the second options, you can filter the options shown in the
     * help output (e.g. to show short help for related options). Provide
     * as simple number indexed array of short and/or long values to set a filter.
     *
     * The $paramGrouping option can be used to group options in the help
     * output. The structure of this array parameter is as follows:
     *
     * <code>
     *  array(
     *      'First section' => array(
     *          'input',
     *          'output'
     *          'overwrite',
     *      ),
     *      'Second section' => array(
     *          'v',
     *          'h',
     *      ),
     *  )
     * </code>
     *
     * As can be seen, short option names are possible as well as long ones.
     * The key of the first array level is the name of the section, which is
     * assigned to an array of options to group under this section. The $params
     * parameter still influences if an option as displayed at all.
     * 
     * @param bool $long
     * @param array(int=>string) $params
     * @param array(string=>array(string)) $paramGrouping
     * @return array(int=>array(int=>string)) Table structure as explained.
     */
    public function getHelp( $long = false, array $params = array(), array $paramGrouping = null )
    {
        $help = array();

        if ( $paramGrouping === null )
        {
            // Original handling
            $help = $this->getOptionHelpWithoutGrouping( $long, $params );
        }
        else
        {
            $help = $this->getOptionHelpWithGrouping( $long, $params, $paramGrouping );
        }

        if ( $this->argumentDefinition !== null )
        {
            $help[] = array( "Arguments:", "" );
            if ( count( $this->argumentDefinition ) === 0 )
            {
                $help[] = array( "", "No arguments available." );
            }
            foreach ( $this->argumentDefinition as $arg )
            {
                $argSynopsis = "<%s:%s>";
                switch ( $arg->type )
                {
                    case self::TYPE_INT:
                        $type = "int";
                        break;
                    case self::TYPE_STRING:
                        $type = "string";
                        break;
                }
                $argSynopsis = sprintf( $argSynopsis, $type, $arg->name );
                $help[] = ( $long === true )
                        ? array( 
                            $argSynopsis,
                            $arg->longhelp . ( $arg->mandatory === false 
                                               ? ' (optional' . ( $arg->default !== null 
                                                                  ? ', default = ' . ( is_array( $arg->default ) 
                                                                                       ? "'" . implode( "' '", $arg->default ) . "'" 
                                                                                       : "'$arg->default'" 
                                                                                     )
                                                                  : '' 
                                                                ) . ')'
                                               : ''
                                             )
                          )
                        : array( $argSynopsis, $arg->shorthelp );
            }
        }
        return $help;
    }

    /**
     * Creates the option help array in the original, ungrouped way.
     *
     * Creates the original help array generated by {@link getHelp()}. The
     * $long and $params options are the same as they are for this method.
     * 
     * @param bool $long 
     * @param array $params 
     * @return array
     */
    private function getOptionHelpWithoutGrouping( $long, $params )
    {
        $help = array();
        foreach ( $this->options as $id => $param )
        {
            if ( count( $params ) === 0 || in_array( $param->short, $params ) || in_array( $param->long, $params ) )
            {
                $help[] = $this->getOptionHelpRow( $long, $param );
            }
        }
        return $help;
    }

    /**
     * Generates options helo array with ordering and grouping.
     * 
     * @param mixed $long 
     * @param mixed $params 
     * @param mixed $paramGrouping 
     * @return array()
     */
    private function getOptionHelpWithGrouping( $long, $params, $paramGrouping )
    {
        $help = array();
        $first = true;
        foreach ( $paramGrouping as $group => $paramsInGroup )
        {
            // Separator line?
            ( $first === false ) ? $help[] = array( '', '' ) : $first = false;

            $help[] = array( $group, '' );
            foreach ( $paramsInGroup as $param )
            {
                // Throws exception if option does not exist
                $option = $this->getOption( $param );
                if ( count( $params ) === 0 || in_array( $option->short, $params ) || in_array( $option->long, $params ) )
                {
                    $help[] = $this->getOptionHelpRow( $long, $option );
                }
            }
        }
        return $help;
    }

    /**
     * Creates 1 text row for displaying options help. 
     *
     * Returns a single array entry for the {@link getOptionHelpRow()} method.
     *
     * @param bool $long 
     * @param array $params 
     * @return string
     */
    private function getOptionHelpRow( $long, ezcConsoleOption $param )
    {
        return array( 
            ( $param->short !== "" ? '-' . $param->short . ' / ' : "" ) . '--' . $param->long,
            $long == false ? $param->shorthelp : $param->longhelp,
        );
    }
    
    /**
     * Get help information for your options as a table.
     *
     * This method provides the information returned by 
     * {@link ezcConsoleInput::getHelp()} in a table.
     *
     * The $paramGrouping option can be used to group options in the help
     * output. The structure of this array parameter is as follows:
     *
     * <code>
     *  array(
     *      'First section' => array(
     *          'input',
     *          'output'
     *          'overwrite',
     *      ),
     *      'Second section' => array(
     *          'v',
     *          'h',
     *      ),
     *  )
     * </code>
     *
     * As can be seen, short option names are possible as well as long ones.
     * The key of the first array level is the name of the section, which is
     * assigned to an array of options to group under this section. The $params
     * parameter still influences if an option as displayed at all.
     * 
     * @param ezcConsoleTable $table     The table object to fill.
     * @param bool $long                 Set this to true for getting the 
     *                                   long help version.
     * @param array(int=>string) $params Set of option names to generate help 
     *                                   for, default is all.
     * @param array(string=>array(string)) $paramGrouping
     * @return ezcConsoleTable           The filled table.
     */
    public function getHelpTable( ezcConsoleTable $table, $long = false, array $params = array(), $paramGrouping = null )
    {
        $help = $this->getHelp( $long, $params, $paramGrouping );
        $i = 0;
        foreach ( $help as $row )
        {
            $table[$i][0]->content = $row[0];
            $table[$i++][1]->content = $row[1];
        }
        return $table;
    }

    /**
     * Returns a standard help output for your program.
     *
     * This method generates a help text as it's commonly known from Unix
     * command line programs. The output will contain the synopsis, your 
     * provided program description and the selected parameter help
     * as also provided by {@link ezcConsoleInput::getHelp()}. The returned
     * string can directly be printed to the console.
     *
     * The $paramGrouping option can be used to group options in the help
     * output. The structure of this array parameter is as follows:
     *
     * <code>
     *  array(
     *      'First section' => array(
     *          'input',
     *          'output'
     *          'overwrite',
     *      ),
     *      'Second section' => array(
     *          'v',
     *          'h',
     *      ),
     *  )
     * </code>
     *
     * As can be seen, short option names are possible as well as long ones.
     * The key of the first array level is the name of the section, which is
     * assigned to an array of options to group under this section. The $params
     * parameter still influences if an option as displayed at all.
     * 
     * @param string $programDesc        The description of your program.
     * @param int $width                 The width to adjust the output text to.
     * @param bool $long                 Set this to true for getting the long 
     *                                   help version.
     * @param array(int=>string) $params Set of option names to generate help 
     *                                   for, default is all.
     * @param array(string=>array(string)) $paramGrouping
     * @return string The generated help text.
     */
    public function getHelpText( $programDesc, $width = 80, $long = false, array $params = null, $paramGrouping = null )
    {
        $help = $this->getHelp( $long, ( $params == null ? array() : $params ), $paramGrouping );
        // Determine max length of first column text.
        $maxLength = 0;
        foreach ( $help as $row )
        {
            $maxLength = max( $maxLength, strlen( $row[0] ) );
        }
        // Width of left column
        $leftColWidth = $maxLength + 2;
        // Width of righ column
        $rightColWidth = $width - $leftColWidth;

        $res = 'Usage: ' . $this->getSynopsis( $params ) . PHP_EOL;
        $res .= wordwrap( $programDesc, $width, PHP_EOL );
        $res .= PHP_EOL . PHP_EOL;
        foreach ( $help as $row )
        {
            $rowParts = explode( "\n", wordwrap( $row[1], $rightColWidth ) );
            $res .= sprintf( "%-{$leftColWidth}s", $row[0] );
            $res .= $rowParts[0] . PHP_EOL;
            for ( $i = 1; $i < sizeof( $rowParts ); $i++ )
            {
                $res .= str_repeat( ' ', $leftColWidth ) . $rowParts[$i] . PHP_EOL;
            }
        }
        return $res;
    }

    /**
     * Returns the synopsis string for the program.
     *
     * This gives you a synopsis definition for the options and arguments 
     * defined with this instance of ezcConsoleInput. You can filter the 
     * options named in the synopsis by submitting their short names in an
     * array as the parameter of this method. If the parameter $optionNames
     * is set, only those options are listed in the synopsis. 
     * 
     * @param array(int=>string) $optionNames
     * @return string
     */
    public function getSynopsis( array $optionNames = null )
    {
        $usedOptions = array( 'short' => array(), 'long' => array() );
        $allowsArgs = true;
        $synopsis = '$ ' . ( isset( $argv ) && sizeof( $argv ) > 0 ? $argv[0] : $_SERVER['argv'][0] ) . ' ';
        foreach ( $this->getOptions() as $option )
        {
            if ( $optionNames === null || is_array( $optionNames ) && ( in_array( $option->short, $optionNames ) ||  in_array( $option->long, $optionNames ) ) )
            {
                $synopsis .= $this->createOptionSynopsis( $option, $usedOptions, $allowsArgs );
            }
        }
        if ( $this->argumentDefinition === null )
        {
            // Old handling
            $synopsis .= " [[--] <args>]";
        }
        else
        {
            $synopsis .= "[--] " . $this->createArgumentsSynopsis();
        }
        return $synopsis;
    }

    /**
     * Returns if a help option was set.
     * This method returns if an option was submitted, which was defined to be
     * a help option, using the isHelpOption flag.
     * 
     * @return bool If a help option was set.
     */
    public function helpOptionSet()
    {
        return $this->helpOptionSet;
    }

    /**
     * Property read access.
     *
     * @throws ezcBasePropertyNotFoundException 
     *         If the the desired property is not found.
     * 
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
     * @ignore
     */
    public function __get( $propertyName )
    {
        if ( !isset( $this->$propertyName ) )
        {
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        return $this->properties[$propertyName];
    }

    /**
     * Property set access.
     * 
     * @param string $propertyName 
     * @param string $propertyValue 
     * @ignore
     * @return void
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case "argumentDefinition":
                if ( ( $propertyValue instanceof ezcConsoleArguments ) === false && $propertyValue !== null )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, "ezcConsoleArguments" );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
    
    /**
     * Property isset access.
     * 
     * @param string $propertyName Name of the property.
     * @return bool True if the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }

    /**
     * Returns the synopsis string for a single option and its dependencies.
     *
     * This method returns a part of the program synopsis, specifically for a
     * certain parameter. The method recursively adds depending parameters up
     * to the 2nd depth level to the synopsis. The second parameter is used
     * to store the short names of all options that have already been used in 
     * the synopsis (to avoid adding an option twice). The 3rd parameter 
     * determines the actual deps in the option dependency recursion to 
     * terminate that after 2 recursions.
     * 
     * @param ezcConsoleOption $option        The option to include.
     * @param array(int=>string) $usedOptions Array of used option short names.
     * @param int $depth                      Current recursion depth.
     * @return string The synopsis for this parameter.
     */
    protected function createOptionSynopsis( ezcConsoleOption $option, &$usedOptions, $depth = 0 )
    {
        $synopsis = '';

        // Break after a nesting level of 2
        if ( $depth++ > 2 || ( in_array( $option->short, $usedOptions['short'] ) && in_array( $option->long, $usedOptions['long'] ) ) ) return $synopsis;
        
        $usedOptions['short'][] = $option->short;
        $usedOptions['long'][]  = $option->long;
        
        $synopsis .= $option->short !== "" ? "-{$option->short}" : "--{$option->long}";

        if ( isset( $option->default ) )
        {
            $synopsis .= " " . ( $option->type === ezcConsoleInput::TYPE_STRING ? '"' : '' ) . $option->default . ( $option->type === ezcConsoleInput::TYPE_STRING ? '"' : '' );
        }
        else if ( $option->type !== ezcConsoleInput::TYPE_NONE )
        {
            $synopsis .= " ";
            switch ( $option->type )
            {
                case ezcConsoleInput::TYPE_STRING:
                    $synopsis .= "<string>";
                    break;
                case ezcConsoleInput::TYPE_INT:
                    $synopsis .= "<int>";
                    break;
            }
        }

        foreach ( $option->getDependencies() as $rule )
        {
            $deeperSynopsis = $this->createOptionSynopsis( $rule->option, $usedOptions, $depth );
            $synopsis .= strlen( trim( $deeperSynopsis ) ) > 0 ? ' ' . $deeperSynopsis : '';
        }
        
        if ( $option->arguments === false )
        {
            $allowsArgs = false;
        }
        
        // Make the whole thing optional?
        if ( $option->mandatory === false )
        {
            $synopsis = "[$synopsis]";
        }

        return $synopsis . ' ';
    }

    /**
     * Generate synopsis for arguments. 
     * 
     * @return string The synopsis string.
     */
    private function createArgumentsSynopsis()
    {
        $mandatory = true;
        $synopsises = array();
        foreach ( $this->argumentDefinition as $arg )
        {
            $argSynopsis = "";
            if ( $arg->mandatory === false )
            {
                $mandatory = false;
            }
            $argSynopsis .= "<%s:%s>";
            switch ( $arg->type )
            {
                case self::TYPE_INT:
                    $type = "int";
                    break;
                case self::TYPE_STRING:
                    $type = "string";
                    break;
            }
            $argSynopsis = sprintf( $argSynopsis, $type, $arg->name );
            $synopsises[] = $mandatory === false ? "[$argSynopsis]" : $argSynopsis;
            if ( $arg->multiple === true )
            {
                $synopsises[] = "[$argSynopsis ...]";
                break;
            }
        }
        return implode( " ", $synopsises );
    }

    /**
     * Process an option.
     *
     * This method does the processing of a single option. 
     * 
     * @param array(int=>string) $args The arguments array.
     * @param int $i                   The current position in the arguments array.
     * @return void
     *
     * @throws ezcConsoleOptionTooManyValuesException
     *         If an option that expects only a single value was submitted 
     *         with multiple values.
     * @throws ezcConsoleOptionTypeViolationException
     *         If an option was submitted with a value of the wrong type.
     * @throws ezcConsoleOptionMissingValueException
     *         If an option thats expects a value was submitted without.
     */
    private function processOptions( array $args, &$i )
    {
        $option = $this->getOption( preg_replace( '/^-+/', '', $args[$i++] ) );
        // Is the actual option a help option?
        if ( $option->isHelpOption === true )
        {
            $this->helpOptionSet = true;
        }
        // No value expected
        if ( $option->type === ezcConsoleInput::TYPE_NONE )
        {
            // No value expected
            if ( isset( $args[$i] ) && substr( $args[$i], 0, 1 ) !== '-' && sizeof( $args ) > ( $i + 1 ) )
            {
                // But one found
                throw new ezcConsoleOptionTypeViolationException( $option, $args[$i] );
            }
            // Multiple occurance possible
            if ( $option->multiple === true )
            {
                $option->value[] = true;
            }
            else
            {
                $option->value = true;
            }
            // Everything fine, nothing to do
            return $i;
        }
        // Value expected, check for it
        if ( isset( $args[$i] ) && substr( $args[$i], 0, 1 ) !== '-' )
        {
            // Type check
            if ( $this->isCorrectType( $option->type, $args[$i] ) === false )
            {
                throw new ezcConsoleOptionTypeViolationException( $option, $args[$i] );
            }
            // Multiple values possible
            if ( $option->multiple === true )
            {
                $option->value[] = $args[$i];
            }
            // Only single value expected, check for multiple
            elseif ( isset( $option->value ) && $option->value !== false )
            {
                throw new ezcConsoleOptionTooManyValuesException( $option );
            }
            else
            {
                $option->value = $args[$i];
            }
            $i++;
        }
        // Value found? If not, use default, if available
        if ( !isset( $option->value ) || $option->value === false || ( is_array( $option->value ) && count( $option->value ) === 0) ) 
        {
            throw new ezcConsoleOptionMissingValueException( $option );
        }
        return $i;
    }

    /**
     * Process arguments given to the program. 
     * 
     * @param array(int=>string) $args The arguments array.
     * @param int $i                   Current index in arguments array.
     * @return void
     */
    private function processArguments( array $args, &$i )
    {
        if ( $this->argumentDefinition === null || $this->argumentsAllowed() === false )
        {
            // Old argument handling, also used of a set option sets disallowing arguments
            while ( $i < count( $args ) )
            {
                $this->arguments[] = $args[$i++];
            }
        }
        else
        {
            $mandatory = true;
            foreach ( $this->argumentDefinition as $arg )
            {
                // Check if all followinga arguments are optional
                if ( $arg->mandatory === false )
                {
                    $mandatory = false;
                }

                // Check if the current argument is present and mandatory
                if ( $mandatory === true )
                {
                    if ( !isset( $args[$i] ) )
                    {
                        throw new ezcConsoleArgumentMandatoryViolationException( $arg );
                    }
                }
                else
                {
                    // Arguments are optional, if no more left: return.
                    if ( !isset( $args[$i] ) )
                    {
                        // Optional and no more arguments left, assign default
                        $arg->value = $arg->default;
                        continue;
                    }
                }

                if ( $arg->multiple === true )
                {
                    $arg->value = array();
                    for ( $i = $i; $i < count( $args ); ++$i )
                    {
                        if ( $this->isCorrectType( $arg->type, $args[$i] ) === false )
                        {
                            throw new ezcConsoleArgumentTypeViolationException( $arg, $args[$i] );
                        }
                        $arg->value = array_merge( $arg->value, array( $args[$i] ) );
                        // Keep old handling, too
                        $this->arguments[] = $args[$i];
                    }
                    return;
                }
                else
                {
                    if ( $this->isCorrectType( $arg->type, $args[$i] ) === false )
                    {
                        throw new ezcConsoleArgumentTypeViolationException( $arg, $args[$i] );
                    }
                    $arg->value = $args[$i];
                    // Keep old handling, too
                    $this->arguments[] = $args[$i];
                }
                ++$i;
            }

            if ( $i < count( $args ) )
            {
                throw new ezcConsoleTooManyArgumentsException( $args, $i );
            }
        }
    }

    /**
     * Returns if arguments are allowed with the current option submition.
     * 
     * @return bool If arguments allowed.
     */
    protected function argumentsAllowed()
    {
        foreach ( $this->options as $id => $option )
        {
            if ( $option->value !== false && $option->arguments === false )
            {
                return false;
            }
        }
        return true;
    }

    /**
     * Check the rules that may be associated with an option.
     *
     * Options are allowed to have rules associated for dependencies to other
     * options and exclusion of other options or arguments. This method
     * processes the checks.
     *
     * @throws ezcConsoleOptionDependencyViolationException
     *         If a dependency was violated. 
     * @throws ezcConsoleOptionExclusionViolationException 
     *         If an exclusion rule was violated.
     * @throws ezcConsoleOptionArgumentsViolationException 
     *         If arguments are passed although a parameter dissallowed them.
     * @throws ezcConsoleOptionMandatoryViolationException
     *         If an option that was marked mandatory was not submitted.
     * @throws ezcConsoleOptionMissingValueException
     *         If an option that expects a value was submitted without one.
     * @return void
     */
    private function checkRules()
    {
        // If a help option is set, skip rule checking
        if ( $this->helpOptionSet === true )
        {
            return true;
        }
        $values = $this->getAllSubmittedOptions();
        foreach ( $this->options as $id => $option )
        {
            // Mandatory
            if ( $option->mandatory === true && $option->value === false )
            {
                throw new ezcConsoleOptionMandatoryViolationException( $option );
            }
            // Not set and not mandatory? No checking.
            if ( $option->value === false || is_array( $option->value ) && count( $option->value ) === 0 )
            {
                // Default value to set?
                if ( $option->default !== null )
                {
                    $option->value = $option->default;
                }
                // Parameter was not set so ignore it's rules.
                continue;
            }

            // Option was set, so check further on

            // Dependencies
            foreach ( $option->getDependencies() as $dep )
            {
                if ( !isset( $values[$dep->option->short] ) && !isset( $values[$dep->option->long] ) )
                {
                    throw new ezcConsoleOptionDependencyViolationException( $option, $dep->option );
                }
                $depOptVal = ( isset( $values[$dep->option->short] ) ? $values[$dep->option->short] : $values[$dep->option->long] );
                $depVals   = $dep->values;
                if ( $depVals !== array() )
                {
                    $depOptVals       = is_array( $depOptVal ) ? $depOptVal : array( $depOptVal );
                    $unrecognizedVals = array_diff( $depOptVals, $depVals );
                    if ( $unrecognizedVals !== array() )
                    {
                        throw new ezcConsoleOptionDependencyViolationException(
                            $option,
                            $dep->option,
                            implode( ', ', $depVals )
                        );
                    }
                }
            }
            // Exclusions
            foreach ( $option->getExclusions() as $exc )
            {
                if ( isset( $values[$exc->option->short] ) || isset( $values[$exc->option->long] ) )
                {
                    if ( $exc->values === array() )
                    {
                        throw new ezcConsoleOptionExclusionViolationException( $option, $exc->option );
                    }
                }
                else
                {
                    // Excluded option not set at all, no checks needed
                    continue;
                }
                $excOptVal = ( isset( $values[$exc->option->short] ) ? $values[$exc->option->short] : $values[$exc->option->long] );
                $excVals   = $exc->values;
                if ( $excVals !== array() )
                {
                    $excOptVals     = is_array( $excOptVal ) ? $excOptVal : array( $excOptVal );
                    $disallowedVals = array_intersect( $excOptVals, $excVals );
                    if ( $disallowedVals !== array() )
                    {
                        throw new ezcConsoleOptionExclusionViolationException(
                            $option,
                            $exc->option,
                            implode( ', ', $excVals )
                        );
                    }
                }
            }
            // Arguments
            if ( $option->arguments === false && is_array( $this->arguments ) && count( $this->arguments ) > 0 )
            {
                throw new ezcConsoleOptionArgumentsViolationException( $option );
            }
        }
    }

    /**
     * Checks if a value is of a given type. Converts the value to the
     * correct PHP type on success.
     *  
     * @param int $type   The type to check for. One of self::TYPE_*.
     * @param string $val The value to check. Will possibly altered!
     * @return bool True on succesful check, otherwise false.
     */
    private function isCorrectType( $type, &$val )
    {
        $res = false;
        switch ( $type )
        {
            case ezcConsoleInput::TYPE_STRING:
                $res = true;
                $val = preg_replace( '/^(["\'])(.*)\1$/', '\2', $val );
                break;
            case ezcConsoleInput::TYPE_INT:
                $res = preg_match( '/^[0-9]+$/', $val ) ? true : false;
                if ( $res )
                {
                    $val = ( int ) $val;
                }
                break;
        }
        return $res;
    }

    /**
     * Split parameter and value for long option names. 
     * 
     * This method checks for long options, if the value is passed using =. If
     * this is the case parameter and value get split and replaced in the
     * arguments array.
     * 
     * @param array(int=>string) $args The arguments array
     * @param int $i                   Current arguments array position
     * @return void
     */
    private function preprocessLongOption( array &$args, $i )
    {
        // Value given?
        if ( preg_match( '/^--\w+\=[^ ]/i', $args[$i] ) )
        {
            // Split param and value and replace current param
            $parts = explode( '=', $args[$i], 2 );
            array_splice( $args, $i, 1, $parts );
        }
    }

    /**
     * Returns an array of all submitted options.
     *
     * Returns an array which has the short and long names of all submitted
     * options as its keys, assigned to the submitted values.
     * 
     * @return array(string=>mixed)
     */
    private function getAllSubmittedOptions()
    {
        $res = array();
        foreach ( $this->options as $option )
        {
            if ( $option->value !== false ) 
            {
                if ( !empty( $option->short ) )
                {
                    $res[$option->short] = $option->value;
                }
                if ( !empty( $option->long ) )
                {
                    $res[$option->long] = $option->value;
                }
            }
        }
        return $res;
    }
}
?>
