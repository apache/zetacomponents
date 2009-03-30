<?php
/**
 * File containing the ezcDocumentPdfTcpdfDriver class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

// Include TCPDF library.
// @TODO: Fix this to point to a generic location, but TCPDF seems not to be
// installable using PEAR; so that the user might be required to include this
// himself.
require dirname( __FILE__ ) . '/tcpdf/tcpdf.php';

/**
 * Pdf driver based on pecl/haru
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfTcpdfDriver extends ezcDocumentPdfDriver
{
    /**
     * Tcpdf Document instance
     * 
     * @var Tcpdf
     */
    protected $document;

    /**
     * Page instances, given as an array, indexed by their page number starting
     * with 0.
     * 
     * @var array
     */
    protected $pages;

    /**
     * Array with fonts, and their equivalents for bold and italic markup. This
     * array will be extended when loading new fonts, but contains the builtin
     * fonts by default.
     *
     * The fourth value for each font is bold + oblique, the index is the
     * bitwise and combination of the repective combinations. Each font MUST
     * have at least a value for FONT_PLAIN assigned.
     * 
     * @var array
     */
    protected $fonts = array(
        'sans-serif' => array(
            self::FONT_PLAIN   => 'times',
            self::FONT_BOLD    => 'timesb',
            self::FONT_OBLIQUE => 'timesi',
            3                  => 'timesbi',
        ),
        'serif' => array(
            self::FONT_PLAIN   => 'helvetica',
            self::FONT_BOLD    => 'helveticab',
            self::FONT_OBLIQUE => 'helveticai',
            3                  => 'helveticabi',
        ),
        'monospace' => array(
            self::FONT_PLAIN   => 'courier',
            self::FONT_BOLD    => 'courierb',
            self::FONT_OBLIQUE => 'courieri',
            3                  => 'courierbi',
        ),
        'Symbol' => array(
            self::FONT_PLAIN   => 'symbol',
        ),
        'ZapfDingbats' => array(
            self::FONT_PLAIN   => 'zapfdingbats',
        ),
    );

    /**
     * Reference to the page currently rendered on
     * 
     * @var haruPage
     */
    protected $currentpage;

    /**
     * Name and style of default font / currently used font
     * 
     * @var array
     */
    protected $currentFont = array(
        'name'  => 'sans-serif',
        'style' => self::FONT_PLAIN,
        'size'  => 12,
    );

    /**
     * Construct driver
     *
     * Creates a new document instance maintaining all document context.
     * 
     * @return void
     */
    public function __construct()
    {
        // Do nothing in here, we can only instantiate the document on first
        // page creation, because we do not know about the page format
        // beforehand.
        $this->pages = array();

        // Sorry for this, but we need it to prevent from warnings in TCPDF:
        $GLOBALS['utf8tolatin'] = array();
    }

    /**
     * Create a new page
     *
     * Create a new page in the PDF document with the given width and height.
     * 
     * @param float $width 
     * @param float $height 
     * @return void
     */
    public function createPage( $width, $height )
    {
        if ( $this->document === null )
        {
            $this->document = new TCPDF(
                'P',  // Portrait size, which should notter sinc we provide the exact size
                'mm', // Units used for all values, except font sizes
                array( $width, $height ),
                true,   // Use unicode
                'UTF-8'
            );

            // We do this ourselves
            $this->document->SetAutoPageBreak( false );

            $this->document->setFont(
                $this->fonts[$this->currentFont['name']][self::FONT_PLAIN],
                '', // Style
                $this->currentFont['size']
            );
        }

        // Create a new page, and create a reference in the pages array
        $this->document->AddPage( 'P', array( $width, $height ) );
        $this->pages[] = $this->document->getPage();
    }

    /**
     * Try to set font
     *
     * Stays with the old font, if the newly specified font is not available.
     *
     * If the font does not support the given style, it falls back to the style
     * used beforehand, and if this is also not support the plain style will be
     * used.
     * 
     * @param string $name 
     * @param int $style 
     * @return void
     */
    public function trySetFont( $name, $style )
    {
        // Just du no use new font, if it is unknown
        // @TODO: Add some kind of weak error reporting here?
        if ( !isset( $this->fonts[$name] ) )
        {
            $name = $this->currentFont['name'];
        }

        // Style fallback
        if ( !isset( $this->fonts[$name][$style] ) )
        {
            $style = isset( $this->fonts[$name][$this->currentFont['style']] ) ? $this->currentFont['style'] : self::FONT_PLAIN;
        }

        // Create and use font on current page
        $this->document->setFont(
            $this->fonts[$name][self::FONT_PLAIN],
            ( $style & self::FONT_BOLD      ? 'B' : '' ) .
            ( $style & self::FONT_OBLIQUE   ? 'I' : '' ) .
            ( $style & self::FONT_UNDERLINE ? 'U' : '' )
        );

        $this->currentFont = array(
            'name'  => $name,
            'style' => $style,
            'size'  => $this->currentFont['size'],
        );
    }

    /**
     * Set text formatting option
     *
     * Set a text formatting option. The names of the options are the same used
     * in the PCSS files and need to be translated by the driver to the proper
     * backend calls.
     *
     *
     * @param string $type 
     * @param mixed $value 
     * @return void
     */
    public function setTextFormatting( $type, $value )
    {
        switch ( $type )
        {
            case 'font-style':
                if ( ( $value === 'oblique' ) ||
                     ( $value === 'italic' ) )
                {
                    $this->trySetFont(
                        $this->currentFont['name'],
                        $this->currentFont['style'] | self::FONT_OBLIQUE
                    );
                }
                else
                {
                    $this->trySetFont(
                        $this->currentFont['name'],
                        $this->currentFont['style'] & ~self::FONT_OBLIQUE
                    );
                }
                break;

            case 'font-weight':
                if ( ( $value === 'bold' ) ||
                     ( $value === 'bolder' ) )
                {
                    $this->trySetFont(
                        $this->currentFont['name'],
                        $this->currentFont['style'] | self::FONT_BOLD
                    );
                }
                else
                {
                    $this->trySetFont(
                        $this->currentFont['name'],
                        $this->currentFont['style'] & ~self::FONT_BOLD
                    );
                }
                break;

            case 'font-family':
                $this->trySetFont( $value, $this->currentFont['style'] );
                break;

            case 'font-size':
                $this->currentFont['size'] = $this->mmToPixel( (float) $value );
                $this->document->setFontSize( $this->currentFont['size'] );
                break;

            default:
                // @TODO: Error reporting.
        }
    }

    /**
     * Calculate the rendered width of the current word
     *
     * Calculate the width of the passed word, using the currently set text
     * formatting options.
     * 
     * @param string $word 
     * @return float
     */
    public function calculateWordWidth( $word )
    {
        return $this->document->GetStringWidth( $word );
    }

    /**
     * Draw word at given position
     *
     * Draw the given word at the given position using the currently set text
     * formatting options.
     * 
     * @param float $x 
     * @param float $y 
     * @param string $word 
     * @return void
     */
    public function drawWord( $x, $y, $word )
    {
        $this->document->setXY( $x, $y );
        $this->document->Write(
            $this->pixelToMm( $this->currentFont['size'] ),
            $word
        );
    }

    /**
     * Generate and return PDF
     *
     * Return the generated binary PDF content as a string.
     * 
     * @return string
     */
    public function save()
    {
        return $this->document->Output( 'ignored', 'S' );
    }
}
?>
