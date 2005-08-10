<?php
/**
 * File containing the ezcConsoleTable class.
 *
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Creating tables to be printed to the console. 
 *
 * @see ezcConsoleOutput
 * @package ConsoleTools
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcConsoleTable
{
    /**
     * Automatically wrap text to fit into a column.
     * @see ezcConsoleTable::$options
     */
    const WRAP_AUTO = 10;
    /**
     * Do not wrap text. Columns will be extended to fit the largest text.
     * ATTENTION: This is riscy!
     * @see ezcConsoleTable::$options
     */
    const WRAP_NONE = 11;
    /**
     * Text will be cut to fit into a column.
     * @see ezcConsoleTable::$options
     */
    const WRAP_CUT  = 12;
    
    /**
     * Settings for the table.
     *
     * <code>
     * array(
     *  'width' => <int>,       // Width of the table
     *  'cols'  => <int>,       // Number of columns
     * );
     * </code>
     *
     * @var array(string)
     */
    protected $settings;

    /**
     * Options for the table.
     *
     * @var array(string)
     */
    protected $options = array(
        'colWidth'  => 'auto',      // Automatically define column width. Else array of width
                                    // per column like array( 0 => 10, 1 => 15, 2 => 5,...);
        'colWrap'   => WRAP_AUTO,
        
        'lineTop'       => '-',
        'lineBottom'    => '-',
        'lineLeft'      => '|',
        'lineRight'     => '|',

        'cornerTopLeft'     => '+',
        'cornerBottomLeft'  => '+',
        'cornerTopRight'    => '+',
        'cornerBottomRight' => '+',

        'lineColor'     => 'default',
        'lineColorHead' => 'default',
    );

    /**
     * Creates a new table.
     *
     * @param ezcConsoleOutput
     * @param array(string)
     * @param array(string)
     *
     * @see ezcConsoleTable::$settings
     * @see ezcConsoleTable::$options
     */
    public function __construct( ezcConsoleOutput $outHandler, $settings, $options = array() ) {
        
    }

    /**
     * Create an entire table.
     * Creates an entire table from an array of data.
     *
     * <code>
     * array(
     *  0 => array( 0 => <string>, 1 => <string>, 2 => <string>,... ),
     *  1 => array( 0 => <string>, 1 => <string>, 2 => <string>,... ),
     *  2 => array( 0 => <string>, 1 => <string>, 2 => <string>,... ),
     *  ...
     * );
     * </code>
     *
     * @see ezcConsoleTable::__construct()
     * @see ezcConsoleTable::$settings
     * @see ezcConsoleTable::$options
     * 
     * @param ezcConsoleOutput
     * @param array(string)
     * @param array(string)
     */
    public static function create( $data, ezcConsoleOutput $outHandler, $settings, $options = array() ) {
        
    }

    /**
     * Add a row of data to the table.
     * Add a row of data to the table. A row looks like this:
     * 
     * <code>
     * array(
     *  0 => <string>, 1 => <string>,...
     * );
     * </code>
     *
     * 
     * @param array(int => string)
     * @param array(string) {@see eczConsoleTable::$options}
     * @return int Number of the row.
     */
    public function addRow( $rowData, $options ) {

    }

    /**
     * Add a header row to the table.
     * Add a header row to the table. Format {@see ezcConsoleTable::addRow()}.
     *
     * @param array(int => string)
     * @param array(string) {@see eczConsoleTable::$options}
     * @return int Number of the row.
     */
    public function addHeadRow( $rowData, $options ) {

    }

    /**
     * Set data for specific cell.
     * Sets the data for a specific cell. If the row referenced
     * does not exist yet, it's created with empty values. If
     * previous rows do not exist, they are created with empty 
     * values. Existing cell data is overwriten.
     *
     * @param int Row number.
     * @param int Column number.
     * @param string Data for the cell.
     */ 
    public function setCell( $row, $column, $cellData ) {
        
    }

    /**
     * Make a row to a header row.
     * Defines the row with the specified number to be a header row.
     *
     * @param int
     * 
     * @see eczConsoleTable::setDefaultRow()
     */
    public function makeHeadRow( $row ) {
        
    }

    /**
     * Make a row to a default row.
     * Defines the row with the specified number to be a default row.
     * (Used to bring header rows back to normal.)
     *
     * @param int
     *
     * @see eczConsoleTable::setHeadRow()
     */
    public function makeDefaultRow( $row ) {
        
    }

    /**
     * Receive the table in a string.
     * Returns the entire table as a string.
     *
     * @return string
     */
    public function getTable( ) {
        
    }

    /**
     * Output the table.
     * Prints the complete table.
     *
     * @return void
     */
    public function outputTable( ) {

    }
}
