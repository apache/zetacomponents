<?php
/**
 * File containing the ezcDocumentPdfHaruDriver class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Pdf driver based on pecl/haru
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfHaruDriver extends ezcDocumentPdfDriver
{
    /**
     * Haru Document instance
     * 
     * @var HaruDoc
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
            self::FONT_PLAIN   => 'Helvetica',
            self::FONT_BOLD    => 'Helvetica-Bold',
            self::FONT_OBLIQUE => 'Helvetica-Oblique',
            3                  => 'Helvetica-BoldOblique',
        ),
        'serif' => array(
            self::FONT_PLAIN   => 'Times-Roman',
            self::FONT_BOLD    => 'Times-Bold',
            self::FONT_OBLIQUE => 'Times-Oblique',
            3                  => 'Times-BoldOblique',
        ),
        'monospace' => array(
            self::FONT_PLAIN   => 'Courier',
            self::FONT_BOLD    => 'Courier-Bold',
            self::FONT_OBLIQUE => 'Courier-Oblique',
            3                  => 'Courier-BoldOblique',
        ),
        'Symbol' => array(
            self::FONT_PLAIN   => 'Symbol',
        ),
        'ZapfDingbats' => array(
            self::FONT_PLAIN   => 'ZapfDingbats',
        ),
    );

    /**
     * Encodings known by libharu.
     *
     * Libharu sadly does not know any encoding which is capable of
     * representing the full unicode charset. It only knows about several
     * encodings representing subsets of it. This is a list of all available
     * encodings which will just be tried to use for input strings, mapped to
     * their iconv equivalents.
     * 
     * @var array
     */
    protected $encodings = array(
        'StandardEncoding' => 'ISO_8859-1', // Assumption
        'MacRomanEncoding' => 'MAC',
        'WinAnsiEncoding'  => 'ISO_8859-1',
        'ISO8859-2'        => 'ISO_8859-2',
        'ISO8859-3'        => 'ISO_8859-3',
        'ISO8859-4'        => 'ISO_8859-4',
        'ISO8859-5'        => 'ISO_8859-5',
        'ISO8859-6'        => 'ISO_8859-6',
        'ISO8859-7'        => 'ISO_8859-7',
        'ISO8859-8'        => 'ISO_8859-8',
        'ISO8859-9'        => 'ISO_8859-9',
        'ISO8859-10'       => 'ISO_8859-10',
        'ISO8859-11'       => 'ISO_8859-11',
        'ISO8859-13'       => 'ISO_8859-12',
        'ISO8859-14'       => 'ISO_8859-13',
        'ISO8859-15'       => 'ISO_8859-14',
        'ISO8859-16'       => 'ISO_8859-16',
        'CP1250'           => 'CP1250',
        'CP1251'           => 'CP1251',
        'CP1252'           => 'CP1252',
        'CP1253'           => 'CP1253',
        'CP1254'           => 'CP1254',
        'CP1255'           => 'CP1255',
        'CP1256'           => 'CP1256',
        'CP1257'           => 'CP1257',
        'CP1258'           => 'CP1258',
        'KOI8-R'           => 'KOI8-R',
        /*
         * @TODO: Find out how about the respective equivalents in inconv
         * encoding notation.
        'GB-EUC-H'         => '',
        'GB-EUC-V'         => '',
        'GBK-EUC-H'        => '',
        'GBK-EUC-V'        => '',
        'ETen-B5-H'        => '',
        'ETen-B5-V'        => '',
        '90ms-RKSJ-H'      => '',
        '90ms-RKSJ-V'      => '',
        '90msp-RKSJ-H'     => '',
        'EUC-H'            => '',
        'EUC-V'            => '',
        'KSC-EUC-H'        => '',
        'KSC-EUC-V'        => '',
        'KSCms-UHC-H'      => '',
        'KSCms-UHC-HW-H'   => '',
        'KSCms-UHC-HW-V'   => '',
         */
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
        $this->document = new HaruDoc();
        $this->document->setPageMode( HaruDoc::PAGE_MODE_USE_THUMBS );
        $this->pages = array();
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
        $this->pages[] = $this->currentPage = $this->document->addPage();

        $this->currentPage->setWidth( $this->mmToPixel( $width ) );
        $this->currentPage->setHeight( $this->mmToPixel( $height ) );
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
        $font = $this->document->getFont( $this->fonts[$name][$style] );

        $this->currentPage->setFontAndSize( $font, $this->currentFont['size'] );

        $this->currentFont = array(
            'name'  => $name,
            'style' => $style,
            'size'  => $this->currentFont['size'],
            'font'  => $font,
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

                if ( $this->currentFont['font'] !== null )
                {
                    $this->currentPage->setFontAndSize(
                        $this->currentFont['font'],
                        $this->currentFont['size']
                    );
                }
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
        // $word = iconv( 'UTF-8', 'UCS-2', $word );

        // Ensure font is initialized
        if ( $this->currentFont['font'] === null )
        {
            $this->trySetFont( $this->currentFont['name'], $this->currentFont['style'] );
        }

        return $this->pixelToMm( $this->currentPage->getTextWidth( $word ) );
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
        // Ensure font is initialized
        if ( $this->currentFont['font'] === null )
        {
            $this->trySetFont( $this->currentFont['name'], $this->currentFont['style'] );
        }

        $this->currentPage->beginText();
        $this->currentPage->textOut( 
            $this->mmToPixel( $x ),
            $this->currentPage->getHeight() - $this->mmToPixel( $y ) - $this->currentFont['size'],
            $word
        );
        $this->currentPage->endText();
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
        $this->document->saveToStream();
        return $this->document->readFromStream( $this->document->getStreamSize() );
    }
}

