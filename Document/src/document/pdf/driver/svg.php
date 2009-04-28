<?php
/**
 * File containing the ezcDocumentPdfSvgDriver class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * SVG renderer for PDF driver, useful for manual introspection and test
 * comparisions.
 *
 * ONLY FOR TESTING.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfSvgDriver extends ezcDocumentPdfDriver
{
    /**
     * Svg Document instance
     * 
     * @var DOMDocument
     */
    protected $document;

    /**
     * Node of SVG root element
     * 
     * @var DOMElement
     */
    protected $svg;

    /**
     * Root node for page elements
     * 
     * @var DOMElement
     */
    protected $pages;

    /**
     * Root node of current page
     * 
     * @var DOMElement
     */
    protected $currentpage;

    /**
     * Current inner document offset
     * 
     * @var float
     */
    protected $offset = 0;

    /**
     * Next inner document offset after page creation
     * 
     * @var float
     */
    protected $nextOffset = 0;

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
            self::FONT_PLAIN   => 'Bitstream Vera Sans',
            self::FONT_BOLD    => 'Bitstream Vera Sans',
            self::FONT_OBLIQUE => 'Bitstream Vera Sans',
            3                  => 'Bitstream Vera Sans',
        ),
        'serif' => array(
            self::FONT_PLAIN   => 'Bitstream Vera Serif',
            self::FONT_BOLD    => 'Bitstream Vera Serif',
            self::FONT_OBLIQUE => 'Bitstream Vera Serif',
            3                  => 'Bitstream Vera Serif',
        ),
        'monospace' => array(
            self::FONT_PLAIN   => 'Bitstream Vera Sans Mono',
            self::FONT_BOLD    => 'Bitstream Vera Sans Mono',
            self::FONT_OBLIQUE => 'Bitstream Vera Sans Mono',
            3                  => 'Bitstream Vera Sans Mono',
        ),
        'Symbol' => array(
            self::FONT_PLAIN   => 'Symbol',
        ),
        'ZapfDingbats' => array(
            self::FONT_PLAIN   => 'ZapfDingbats',
        ),
    );

    /**
     * Name and style of default font / currently used font
     * 
     * @var array
     */
    protected $currentFont = array(
        'name'  => 'sans-serif',
        'style' => self::FONT_PLAIN,
        'size'  => 28.5,
        'font'  => null,
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
        $this->document = new DOMDocument( '1.0' );
        $this->document->formatOutput = true;

        $this->svg = $this->document->createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
        $this->svg = $this->document->appendChild( $this->svg );

        $this->svg->setAttribute( 'version', '1.2' );
        $this->svg->setAttribute( 'streamable', 'true' );

        $this->pages = $this->document->createElement( 'g' );
        $this->pages = $this->svg->appendChild( $this->pages );
        $this->pages->setAttribute( 'id', 'pages' );
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
        $this->offset      = $this->nextOffset;
        $this->nextOffset += $width + 10;

        $this->currentPage = $this->document->createElement( 'g' );
        $this->currentPage = $this->pages->appendChild( $this->currentPage );

        // Render a containing box visually representing a page in the box
        $page = $this->document->createElement( 'rect' );
        $page = $this->currentPage->appendChild( $page );
        $page->setAttribute( 'x', $this->offset . 'mm' );
        $page->setAttribute( 'y', '0mm' );
        $page->setAttribute( 'width', $width . 'mm' );
        $page->setAttribute( 'height', $height . 'mm' );
        $page->setAttribute( 'style', 'fill: #ffffff; stroke: #000000; stroke-width: 1px; fill-opacity: 1; stroke-opacity: 1;' );
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
                    $this->currentFont['style'] |= self::FONT_OBLIQUE;
                }
                else
                {
                    $this->currentFont['style'] &= ~self::FONT_OBLIQUE;
                }
                break;

            case 'font-weight':
                if ( ( $value === 'bold' ) ||
                     ( $value === 'bolder' ) )
                {
                    $this->currentFont['style'] |= self::FONT_BOLD;
                }
                else
                {
                    $this->currentFont['style'] &= ~self::FONT_BOLD;
                }
                break;

            case 'font-family':
                $this->currentFont['name'] = $value;
                break;

            case 'font-size':
                $this->currentFont['size'] = ezcDocumentPdfMeasure::create( $value )->get( 'pt' );
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
        return ezcDocumentPdfMeasure::create( 
            ( $this->currentFont['size'] * iconv_strlen( $word, 'UTF-8' ) * .43 ) . 'pt'
        )->get();
    }

    /**
     * Get current line height
     *
     * Return the current line height in millimeter based on the current font
     * and text rendering settings.
     * 
     * @return float
     */
    public function getCurrentLineHeight()
    {
        return ezcDocumentPdfMeasure::create( $this->currentFont['size'] . 'pt' )->get();
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
        $textNode = $this->document->createElement( 'text', htmlspecialchars( $word,  ENT_QUOTES, 'UTF-8' ) );
        $textNode->setAttribute( 'x', sprintf( '%.4Fmm', $x + $this->offset ) );
        $textNode->setAttribute( 'y', sprintf( '%.4Fmm', $y ) );
        $textNode->setAttribute( 
            'style', 
            sprintf(
                'font-size: %dpt; font-family: %s; font-style: %s; font-weight: %s; stroke: none;',
                $this->currentFont['size'],
                $this->fonts[$this->currentFont['name']][self::FONT_PLAIN],
                ( $this->currentFont['style'] & self::FONT_OBLIQUE ) ? 'oblique' : 'normal',
                ( $this->currentFont['style'] & self::FONT_BOLD )    ? 'bold'    : 'normal'
            )
        );
        $this->currentPage->appendChild( $textNode );
    }

    /**
     * Draw rectangle
     *
     * Draw rectangle of specified dimensions in specified color. The last
     * parameter defined, if only an outline should be renderer, or if a filled
     * rectangle should be rendered.
     *
     * @param float $x 
     * @param float $y 
     * @param float $width 
     * @param float $heigt 
     * @param mixed $color 
     * @param bool $filled 
     * @return void
     */
    public function drawRectangle( $x, $y, $width, $height, $color, $filled = true )
    {
        $textNode = $this->document->createElement( 'rect' );
        $textNode->setAttribute( 'x', sprintf( '%.4Fmm', $x + $this->offset ) );
        $textNode->setAttribute( 'y', sprintf( '%.4Fmm', $y ) );
        $textNode->setAttribute( 'width', sprintf( '%.4Fmm', $width ) );
        $textNode->setAttribute( 'height', sprintf( '%.4Fmm', $height ) );
        $textNode->setAttribute( 
            'style', 
            sprintf(
                'fill: %s; stroke: %s; stroke-width: 1px; fill-opacity: .3; stroke-opacity: 0;',
                $color,
                '#000000'
            )
        );
        $this->currentPage->appendChild( $textNode );
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
        return $this->document->saveXml();
    }
}
?>
