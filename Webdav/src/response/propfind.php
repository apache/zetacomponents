<?php
/**
 * File containing the class representing a propfind response on a collection
 * from the webdav server.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Class used to answer propfind responses on a collection by the webdav
 * backend.
 *
 * @property mixed $node
 *           Contains a webdav node, either ezcWebdavCollection or
 *           ezcWebdavResource
 * @property array(ezcWebdavPropStatResponse) $responses
 *           Contains a list of propstat responses for the node.
 *
 * @version //autogentag//
 * @package Webdav
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavPropFindResponse extends ezcWebdavResponse
{
    /**
     * Construct a propfind response.
     *
     * The response is constructed from either a {@link ezcWebdavCollection} or
     * a {@link ezcWebdavResource} as the first parameter and a finite amount
     * of {@link ezcWebdavPropStatResponse}s as additional parameters.
     * 
     * @param mixed $node
     * @return void
     */
    public function __construct( $node )
    {
        parent::__construct( ezcWebdavResponse::STATUS_200 );
        $this->node = $node;

        // Add all ezcWebdavPropStatResponse
        $params = func_get_args();
        $responses = array();

        foreach ( $params as $nr => $param )
        {
            // Flatten array structure, if given
            if ( is_array( $param ) )
            {
                foreach( $param as $value )
                {
                    if ( $value instanceof ezcWebdavPropStatResponse )
                    {
                        $responses[] = $value;
                    }
                }

                continue;
            }

            // Also add plain params
            if ( $param instanceof ezcWebdavPropStatResponse )
            {
                $responses[] = $param;
            }
        }

        // If it actually consists of multiple sub responses be of type 207.
        if ( count( $responses ) )
        {
            $this->status = ezcWebdavResponse::STATUS_207;
        }

        $this->responses = $responses;
    }

    /**
     * Sets a property.
     * This method is called when an property is to be set.
     * 
     * @param string $propertyName The name of the property to set.
     * @param mixed $propertyValue The property value.
     * @ignore
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the given property does not exist.
     * @throws ezcBaseValueException
     *         if the value to be assigned to a property is invalid.
     * @throws ezcBasePropertyPermissionException
     *         if the property to be set is a read-only property.
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            case 'node':
                if ( ( ! $propertyValue instanceof ezcWebdavResource ) &&
                     ( ! $propertyValue instanceof ezcWebdavCollection ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'ezcWebdavResource or ezcWebdavCollection' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            case 'responses':
                if ( !is_array( $propertyValue ) )
                {
                    throw new ezcBaseValueException( $propertyName, $propertyValue, 'array(ezcWebdavPropStatResponse)' );
                }

                $this->properties[$propertyName] = $propertyValue;
                break;

            default:
                parent::__set( $propertyName, $propertyValue );
        }
    }
}

?>
