<?php
/**
 * File containing the class representing a OPTIONS response on a resource from
 * the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class used to answer OPTIONS responses on a resource by the webdav backend.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavOptionsResponse extends ezcWebdavResponse
{

    const VERSION_ONE = '1';
    const VERSION_TWO = '2';
    const VERSION_ONE_EXTENDED = '1#extended';

    /**
     * Construct options response.
     * Construct options response indicating supported version numbers.
     * 
     * @param mixed $resource 
     * @return void
     */
    public function __construct( $version = null )
    {
        parent::__construct( ezcWebdavResponse::STATUS_200 );
        $this->headers['DAV'] = ( $version === null ? '1' : $version );
    }

    /**
     * Validates the headers set in this request.
     * This method validates that all required headers are available and that
     * all feasible headers for this request have valid values.
     *
     * @return void
     *
     * @throws ezcWebdavMissingHeaderException
     *         if a required header is missing.
     * @throws ezcWebdavInvalidHeaderException
     *         if a header is present, but its content does not validate.
     */
    public function validateHeaders()
    {
        if ( isset( $this->headers['DAV'] ) === false )
        {
            throw new ezcWebdavMissingHeaderException( 'DAV' );
        }
        $dav = array_map( 'trim', explode( ',', $this->headers['DAV'] ) );
        foreach ( $dav as $number )
        {
            if ( $number !== self::VERSION_ONE && $number !== self::VERSION_TWO && $number !== self::VERSION_ONE_EXTENDED )
            {
                throw new ezcWebdavInvalidHeaderException(
                    'DAV',
                    $this->headers['DAV'],
                    'Komponents must be ezcWebdavOptionsResponse::VERSION_ONE, ezcWebdavOptionsResponse::VERSION_TWO or ezcWebdavOptionsResponse::VERSION_ONE_EXTENDED'
                );
            }
        }
        // Unified spaces
        $this->headers['DAV'] = implode( ', ', $dav );
        
        // Validate common HTTP/WebDAV headers
        parent::validateHeaders();
    }
}

?>
