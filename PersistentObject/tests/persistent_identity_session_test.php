<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'persistent_session_test.php';

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentIdentitySessionTest extends ezcTestCase
{
    protected $idMap;

    protected $idSession;

    protected function setUp()
    {
        parent::setUp();

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->session->definitionManager
        );

        $this->idSession = new ezcPersistentIdentitySession(
            $this->session,
            $this->idMap
        );
    }
}

?>
