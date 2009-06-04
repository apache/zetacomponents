<?php
/**
 * File containing the ezcDocumentPdfHaruDriver class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Pdf driver based on pecl/haru
 *
 * Haru is a pecl extension for PDF rendering, based on libahru, available at
 * http://libharu.org.
 *
 * The extension can be installed using the pear command:
 *
 * <code>
 *  pear install pecl/haru
 * </code>
 *
 * The driver is currently the default driver, but can be explicitely set
 * using:
 *
 * <code>
 *  // Load the docbook document and create a PDF from it
 *  $pdf = new ezcDocumentPdf();
 *  $pdf->options->driver = new ezcDocumentPdfHaruDriver();
 *  $pdf->createFromDocbook( $docbook );
 *  file_put_contents( __FILE__ . '.pdf', $pdf );
 * </code>
 *
 * @package Document
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
     * Dummy document to provide font width estimations, before we actually
     * know what kind of pages will be rendered.
     *
     * @var HaruDoc
     */
    protected $dummyDoc;

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
    protected $currentPage;

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

        $this->dummyDoc = new HaruDoc();
        $this->dummyDoc->addPage();
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

        $this->currentPage->setWidth( ezcDocumentPdfMeasure::create( $width )->get( 'pt' ) );
        $this->currentPage->setHeight( ezcDocumentPdfMeasure::create( $height )->get( 'pt' ) );

        // The current font might need to be recreated for the new page.
        $this->currentFont['font'] = null;
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
        if ( $this->currentPage )
        {
            $font = $this->document->getFont( $this->fonts[$name][$style] );
            $this->currentPage->setFontAndSize( $font, $this->currentFont['size'] );
        }
        else
        {
            $font = $this->dummyDoc->getFont( $this->fonts[$name][$style] );
            $this->dummyDoc->getCurrentPage()->setFontAndSize( $font, $this->currentFont['size'] );
        }

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
                $this->currentFont['size'] = ezcDocumentPdfMeasure::create( $value )->get( 'pt' );

                if ( $this->currentFont['font'] !== null )
                {
                    if ( $this->currentPage )
                    {
                        $this->currentPage->setFontAndSize(
                            $this->currentFont['font'],
                            $this->currentFont['size']
                        );
                    }
                    else
                    {
                        $this->dummyDoc->getCurrentPage()->setFontAndSize(
                            $this->currentFont['font'],
                            $this->currentFont['size']
                        );
                    }
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

        if ( $this->currentPage )
        {
            return ezcDocumentPdfMeasure::create( $this->currentPage->getTextWidth( $word ) . 'pt' )->get();
        }
        else
        {
            return ezcDocumentPdfMeasure::create( $this->dummyDoc->getCurrentPage()->getTextWidth( $word ) . 'pt' )->get();
        }
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
     * The coordinate specifies the left bottom edge of the words bounding box.
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
            ezcDocumentPdfMeasure::create( $x )->get( 'pt' ),
            $this->currentPage->getHeight() - ezcDocumentPdfMeasure::create( $y )->get( 'pt' ),
            $word
        );
        $this->currentPage->endText();
    }

    /**
     * Draw image
     *
     * Draw image at the defined position. The first parameter is the
     * (absolute) path to the image file, and the second defines the type of
     * the image. If the driver cannot handle this aprticular image type, it
     * should throw an exception.
     *
     * The further parameters define the location where the image should be
     * rendered and the dimensions of the image in the rendered output. The
     * dimensions do not neccesarily match the real image dimensions, and might
     * require some kind of scaling inside the driver depending on the used
     * backend.
     *
     * @param string $file
     * @param string $type
     * @param float $x
     * @param float $y
     * @param float $width
     * @param float $height
     * @return void
     */
    public function drawImage( $file, $type, $x, $y, $width, $height )
    {
        switch ( $type )
        {
            case 'image/png':
                $image = $this->document->loadPNG( $file );
                break;
            case 'image/jpeg':
                $image = $this->document->loadJPEG( $file );
                break;
            default:
                throw new ezcBaseFunctionalityNotSupportedException( $type, 'Image type not supported by pecl/haru' );
        }

        $this->currentPage->drawImage(
            $image,
            ezcDocumentPdfMeasure::create( $x )->get( 'pt' ),
            $this->currentPage->getHeight() - ezcDocumentPdfMeasure::create( $y )->get( 'pt' ) -
                ( $height = ezcDocumentPdfMeasure::create( $height )->get( 'pt' ) ),
            ezcDocumentPdfMeasure::create( $width )->get( 'pt' ),
            $height
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
        $this->document->saveToStream();
        return $this->document->readFromStream( $this->document->getStreamSize() );
    }
}
?>
