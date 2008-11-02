<?php
/**
 * File containing the ezcWebdavLockCheckInfo struct class.
 *
 * @package Webdav
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Struct containing information on lock checking for a request.
 *
 * An array of such structs is given to {@link
 * ezcWebdavLockPlugin::checkViolations()}. It contains all information
 * necessary to check violations on locks.
 * 
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
class ezcWebdavLockCheckInfo extends ezcBaseStruct
{
    /**
     * Path to check
     * 
     * @var string
     */
    public $path;

    /**
     * Depth to check in the $path. 
     * 
     * @var ezcWebdavRequest::DEPTH_*
     */
    public $depth;

    /**
     * If header item fitting to that path 
     * 
     * @var ezcWebdavLockIfHeaderTaggedList|ezcWebdavLockIfHeaderNoTagList
     */
    public $ifHeader;

    /**
     * Authorization header content. 
     * 
     * @var ezcWebdavAuthBasic|ezcWebdavAuthDigest|null
     */
    public $authHeader;

    /**
     * Access type for auth checks. 
     * 
     * @var ezcWebdavAuthorizer::ACCESS
     */
    public $access;

    /**
     * Request generator to notify for this $path. 
     * 
     * @var ezcWebdavLockCheckObserver
     */
    public $requestGenerator;

    /**
     * If a lock-null resource may occur while checking. 
     * 
     * @var bool
     */
    public $lockNullMayOccur;

    /**
     * Creates a new lock info struct.
     *
     * @param string $path
     * @param int $depth
     * @param ezcWebdavAuthBasic|ezcWebdavAuthDigest|null $ifHeader
     * @param ezcWebdavAuthBasic|ezcWebdavAuthDigest|null $authHeader
     * @param int $access
     * @param ezcWebdavLockCheckObserver $requestGenerator
     */
    public function __construct(
        $path                                        = '',
        $depth                                       = ezcWebdavRequest::DEPTH_INFINITY,
        $ifHeader                                    = null,
        $authHeader                                  = null,
        $access                                      = ezcWebdavAuthorizer::ACCESS_WRITE,
        ezcWebdavLockCheckObserver $requestGenerator = null,
        $lockNullMayOccur                            = true
    )
    {
        $this->path             = $path;
        $this->depth            = $depth;
        $this->ifHeader         = $ifHeader;
        $this->authHeader       = $authHeader;
        $this->access           = $access;
        $this->requestGenerator = $requestGenerator;
        $this->lockNullMayOccur = $lockNullMayOccur;
    }
}

?>
