<?php
/**
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 * @subpackage Tests
 */

require_once 'PersistentObject/tests/persistent_session/test_case.php';

/**
 * Tests the code manager.
 *
 * @package PersistentObject
 * @subpackage Tests
 */
class ezcPersistentSessionIdentityDecoratorTest extends ezcPersistentSessionTest
{
    protected $idMap;

    protected $idSession;

    protected function setUp()
    {
        parent::setUp();

        $this->idMap = new ezcPersistentBasicIdentityMap(
            $this->session->definitionManager
        );

        $this->idSession = new ezcPersistentSessionIdentityDecorator(
            $this->session,
            $this->idMap
        );
    }
}

?>
