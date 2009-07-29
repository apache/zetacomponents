<?php
/**
 * File containing the ezcDocumentPdfTransactionalDriverWrapper class
 *
 * @package Document
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * PDF driver proxy, which records write calls to proxied driver, wraps them
 * into transactions to optionally revert or commit them later.
 *
 * Since page layouting algorithms are basically always backtracking algorithms
 * they always try to render something, and need to recursively revert already
 * "rendered" stuff. This proxy class for all driver classes records calls,
 * optionally assiciates them with transaction identifies and allows to
 * selectively revert or commint groups of such calls to the backend. Only when
 * comitting or calling save() on the driver proxy any modifying (write)
 * operations are actually issued on the proxied driver.
 *
 * @package Document
 * @access private
 * @version //autogen//
 */
class ezcDocumentPdfTransactionalDriverWrapper extends ezcDocumentPdfDriver
{
    /**
     * Wrapper direver instance
     *
     * @var ezcDocumentPdfDriver
     */
    protected $driver;

    /**
     * Array with currently known pages, also depend on transactions
     *
     * @var array
     */
    protected $pages = array();

    /**
     * Recorded transactions
     *
     * @var array
     */
    protected $transactions = array();

    /**
     * Transaction identifier of current transaction
     *
     * @var mixed
     */
    protected $transaction = 0;

    /**
     * Construct transactional driver wrapper
     * 
     * @return void
     */
    public function __construct()
    {
        $this->transactions[$this->transaction] = new ezcDocumentPdfTransactionalDriverWrapperState();
    }

    /**
     * Set proxied driver
     *
     * Set driver, which should respond to read calls, and to which comitted
     * write calls should be passed.
     *
     * @param ezcDocumentPdfDriver $driver
     * @return void
     */
    public function setDriver( ezcDocumentPdfDriver $driver )
    {
        $this->driver = $driver;
    }

    /**
     * Start a new transaction sequence
     *
     * Start a new transaction, which will record all calls, until the next
     * transaction is started. This methods returns an identifier for this
     * transaction, which can be used to commit this transaction, or revert
     * everything since (including) this this transaction.
     *
     * @return mixed
     */
    public function startTransaction()
    {
        $current = $this->transactions[$this->transaction]->currentPage;
        $this->transactions[++$this->transaction] = new ezcDocumentPdfTransactionalDriverWrapperState();
        $this->transactions[$this->transaction]->currentPage = $current;

        if ( $page = $this->currentPage() )
        {
            $page->startTransaction( $this->transaction );
        }
        return $this->transaction;
    }

    /**
     * Commit recorded transactions
     *
     * If no transaction identifier is specified every recorded call will be
     * comitted to the proxied driver. If you specify a transaction identifier,
     * each transaction up to the current (including the current) transaction
     * will be comitted.
     *
     * @param mixed $transaction
     * @return void
     */
    public function commit( $transaction = null )
    {
        if ( ( $transaction !== null ) &&
             !isset( $this->transactions[$transaction] ) )
        {
            return false;
        }

        // Order calls using the page number they are called for, for all
        // transactions to commit.
        $grouped = array( array() );
        foreach ( $this->transactions as $id => $transactions )
        {
            foreach ( $transactions->calls as $page => $calls )
            {
                foreach ( $calls as $call )
                {
                    $grouped[$page][] = $call;
                }
            }

            $this->transactions[$id]->calls = array();
            if ( $id === $transaction )
            {
                break;
            }
        }

        // Execute ordered calls
        foreach ( $grouped as $page => $calls )
        {
            foreach ( $calls as $call )
            {
                call_user_func_array( array( $this->driver, $call[0] ), $call[1] );
            }
        }

        return true;
    }

    /**
     * Revert transaction
     *
     * Revert all transactions after the specified (including the specified)
     * transaction.
     *
     * @param mixed $transaction
     * @return void
     */
    public function revert( $transactionId )
    {
        // Revert all page creations and associated transactions
        $remove          = false;
        $lastTransaction = 0;
        foreach ( $this->transactions as $id => $transaction )
        {
            if ( !$remove &&
                 ( $id !== $transactionId ) )
            {
                $lastTransaction = $id;
                continue;
            }

            $remove = true;
            foreach ( $transaction->pageCreations as $pageNumber )
            {
                unset( $this->pages[$pageNumber] );
            }

            unset( $this->transactions[$id] );
        }

        // Revert transactions on all possibly affected pages
        $this->transaction = $lastTransaction;
        foreach ( $this->pages as $nr => $page )
        {
            if ( $nr >= $this->transactions[$lastTransaction]->currentPage )
            {
                $page->revert( $transactionId );
            }
        }

        return true;
    }

    /**
     * Record call
     *
     * Record a write call in the current transaction. A call is specified by
     * its method name and the parameters.
     *
     * @param string $name
     * @param array $parameters
     * @return void
     */
    protected function recordCall( $name, array $parameters )
    {
        $this->transactions[$this->transaction]->calls[$this->transactions[$this->transaction]->currentPage][] = array( $name, $parameters );
    }

    /**
     * Create and append a new page
     *
     * @param ezcDocumentPdfStyleInferencer $inferencer
     * @return void
     */
    public function appendPage( ezcDocumentPdfStyleInferencer $inferencer )
    {
        $current = $this->transactions[$this->transaction]->currentPage;
        // Check if the next page already exists
        if ( isset( $this->pages[$current + 1] ) )
        {
            $current = ++$this->transactions[$this->transaction]->currentPage;
            return $this->pages[$current];
        }

        $current = ++$this->transactions[$this->transaction]->currentPage;
        $styles = $inferencer->inferenceFormattingRules( new ezcDocumentPdfPage( 0, 0, 0, 0, 0 ) );
        $page = ezcDocumentPdfPage::createFromSpecification(
            $current,
            $styles['page-size']->value,
            $styles['page-orientation']->value,
            $styles['margin']->value,
            $styles['padding']->value
        );

        // Store in which transaction the page has been created
        $this->pages[$current]                                   = $page;
        $this->transactions[$this->transaction]->pageCreations[] = $current;

        // Tell driver about new page
        $this->createPage( $page->width, $page->height );

        return $page;
    }

    /**
     * Get current page
     *
     * Return the currently used page
     *
     * @return ezcDocumentPdfPage
     */
    public function currentPage()
    {
        if ( !isset( $this->transactions[$this->transaction] ) ||
             !isset( $this->pages[$this->transactions[$this->transaction]->currentPage] ) )
        {
            return null;
        }

        return $this->pages[$this->transactions[$this->transaction]->currentPage];
    }

    /**
     * Go back one page
     *
     * If something has been rendered on the next page, but the actual pointer
     * should stay at the current page, this function can be used to revert the
     * pointer to the last page.
     *
     * @return void
     */
    public function goBackOnePage()
    {
        --$this->transactions[$this->transaction]->currentPage;
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
        // Just record this write call
        $this->recordCall( __FUNCTION__, array( $width, $height ) );
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
        // This call can be relevant for the size estimation, so it needs to be
        // proxied and recorded
        $this->recordCall( __FUNCTION__, array( $type, $value ) );

        return $this->driver->setTextFormatting( $type, $value );
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
        // Just required to read rendering properties of the current driver, no
        // recording required.
        return $this->driver->calculateWordWidth( $word );
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
        // Just required to read rendering properties of the current driver, no
        // recording required.
        return $this->driver->getCurrentLineHeight();
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
        // Just record this write call
        $this->recordCall( __FUNCTION__, array( $x, $y, $word ) );
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
        // Just record this write call
        $this->recordCall( __FUNCTION__, array( $file, $type, $x, $y, $width, $height ) );
    }

    /**
     * Draw a fileld polygon
     *
     * Draw any filled polygon, filled using the defined color. The color
     * should be passed as an array with the keys "red", "green", "blue" and
     * optionally "alpha". Each key should have a value between 0 and 1
     * associated.
     *
     * The polygon itself is specified as an array of two-tuples, specifying
     * the x and y coordinate of the point.
     * 
     * @param array $points 
     * @param array $color 
     * @return void
     */
    public function drawPolygon( array $points, array $color )
    {
        // Just record this write call
        $this->recordCall( __FUNCTION__, array( $points, $color ) );
    }

    /**
     * Draw a polyline
     *
     * Draw any non-filled polygon, filled using the defined color. The color
     * should be passed as an array with the keys "red", "green", "blue" and
     * optionally "alpha". Each key should have a value between 0 and 1
     * associated.
     *
     * The polyline itself is specified as an array of two-tuples, specifying
     * the x and y coordinate of the point.
     *
     * The thrid parameter defines the width of the border and the last
     * parameter may optionally be set to false to not close the polygon (draw
     * another line from the last point to the first one).
     * 
     * @param array $points 
     * @param array $color 
     * @param mixed $width 
     * @param mixed $close 
     * @return void
     */
    public function drawPolyline( array $points, array $color, $width, $close = true )
    {
        // Just record this write call
        $this->recordCall( __FUNCTION__, array( $points, $color, $width, $close ) );
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
        // The ultimate write call. We can try to recommit an then just proxy
        // the call.
        $this->commit();
        return $this->driver->save();
    }
}
?>
