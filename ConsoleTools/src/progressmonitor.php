<?php
/**
 * File containing the ezcConsoleProgressMonitor class.
 *
 * @package ConsoleTools
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @filesource
 */

/**
 * Printing structured status information on the console. 
 *
 * <code>
 * // Construction
 * $status = new ezcConsoleProgressMonitor( new ezcConsoleOutput(), 42 );
 *
 * // Run statusbar
 * foreach ( $files as $file )
 * {
 *      $res = $file->upload();
 *      // Add a status-entry to be printed.
 *      $status->addEntry( 'UPLOAD', $file->path );
 *      // Result like "    2.5% UPLOAD /var/upload/test.png"
 * }
 * </code>
 *  
 * 
 * @package ConsoleTools
 * @version //autogen//
 */
class ezcConsoleProgressMonitor
{
    /**
     * Options
     *
     * <code>
     * array(
     *   'formatstring' => '%8.1f %s %s', // Defines the format for each entry
     * );
     * </code>
     *
     * @var array(string=>string)
     */
    protected $options = array(
        'formatString' => '%8.1f%% %s %s', // Defines the format for each entry
    );

    /**
     * The ezcConsoleOutput object to use.
     *
     * @var ezcConsoleOutput
     */
    protected $outputHandler;

    /**
     * Counter for the items already printed. 
     * 
     * @var int
     */
    protected $counter = 0;

    /**
     * The number of entries to expect. 
     * 
     * @var int
     */
    protected $max;

    /**
     * Creates a new progress monitor.
     *
     * @param ezcConsoleOutput $outHandler Handler to utilize for output
     * @param int $max                     Number of items to expect
     * @param array(string=>string)        Options.
     *
     * @see ezcConsoleProgressMonitor::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, $max, array $options = array() )
    {
        $this->outputHandler = $outHandler;
        $this->max = $max;
        $this->setOptions( $options );
    }

    /**
     * Property read access.
     * 
     * @param string $key Name of the property.
     * @return mixed Value of the property or null.
     *
     * @throws ezcBasePropertyNotFoundException
     *         If the the desired property is not found.
     */
    public function __get( $key )
    {
        switch ( $key )
        {
            case 'options':
                return $this->options;
                break;
        }
        throw new ezcBasePropertyNotFoundException( $key );
    }

    /**
     * Set options.
     * Set the options of the status-bar.
     * 
     * @see ezcConsoleProgressMonitor::$options
     * 
     * @param array(string=>string) $options The optiosn to set.
     * @return void
     */
    public function setOptions( array $options )
    {
        foreach ( $options as $name => $value )
        {
            switch ( $name )
            {
                case 'formatString':
                    if ( !is_string( $value ) || strlen( $value ) < 1 )
                    {
                        throw new ezcBaseSettingValueException( $name, $value, 'string, not empty' );
                    }
                    break;
                default:
                    throw new ezcBaseSettingNotFoundException( $name );
                    break;
            }
            $this->options[$name] = $value;
        }
    }

    /**
     * Returns the currently set options.
     * Returns the currently set option array.
     * 
     * @return array(string=>string) The options.
     */
    public function getOptions()
    {
        return $this->options;
    }
 
    /**
     * Print a status entry.
     * Prints a new status entry to the console and updates the internal counter.
     *
     * @param string $tag  The tag to print (second argument in the 
     *                     formatString).
     * @param string $data The data to be printed in the status entry (third 
     *                     argument in the format string).
     * @return void
     */
    public function addEntry( $tag, $data )
    {
        $this->counter++;
        $percentage = $this->counter / $this->max * 100;

        $this->outputHandler->outputLine(
            sprintf(
                $this->options['formatString'],
                $percentage,
                $tag,
                $data
            )
        );
    }
}
?>
