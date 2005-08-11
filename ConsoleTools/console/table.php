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
 * <code>
 * 
 * // ... creating ezcConsoleOutput object
 *
 * $options = array(
 *  'lineColorHead' => 'red',  // Make header rows surrounded by red lines
 * );
 * 
 * $table = new ezcConsoleTable($out, array('width' => 60, 'cols' = 3));
 * // Generate a header row:
 * $table->addRowHead(array('First col', 'Second col', 'Third col'));
 * // Right column will be the largest
 * $table->addRow(array('Data', 'Data', 'Very very very very very long data'));
 * $table->output();
 *
 * </code>
 * 
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
     * @param ezcConsoleOutput $outHandler Output handler to utilize
     * @param array(string) $settings      Settings
     * @param array(string) $options       Options
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
     * @param array(int -> string) $data   Data for the table
     * @param ezcConsoleOutput $outHandler Output handler to utilize
     * @param array(string) $settings      Settings
     * @param array(string) $options       Options
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
     * The options parameter overrides the globally set options.
     * 
     * @param array(int => string) $rowData The data for the row
     * @param array(string) $options        Override {@link eczConsoleTable::$options}
     * @return int Number of the row.
     */
    public function addRow( $rowData, $options ) {

    }

    /**
     * Add a header row to the table.
     * Add a header row to the table. Format {@link ezcConsoleTable::addRow()}.
     *
     * The options parameter overrides the globally set options.
     *
     * @param array(int => string) $rowData The row data
     * @param array(string) $options        Override {@link eczConsoleTable::$options}
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
     * @param int $row         Row number.
     * @param int $column      Column number.
     * @param string $cellData Data for the cell.
     */ 
    public function setCell( $row, $column, $cellData ) {
        
    }

    /**
     * Make a row to a header row.
     * Defines the row with the specified number to be a header row.
     *
     * @param int $row Number of the row to affect.
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
     * @param int $row Number of the row to affect.
     *
     * @see eczConsoleTable::setHeadRow()
     */
    public function makeDefaultRow( $row ) {
        
    }

    /**
     * Returns the table in a string.
     * Returns the entire table as a string.
     *
     * @return string
     */
    public function getTable( ) {
        
    }

    /**
     * Output the table.
     * Prints the complete table to the console.
     *
     * @return void
     */
    public function outputTable( ) {

    }
}
