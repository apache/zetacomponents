<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Tree
 * @subpackage Tests
 */

require_once 'tree.php';

/**
 * @package Tree
 * @subpackage Tests
 */
class ezcTreeVisitorTest extends ezcTestCase
{
    public function setUp()
    {
        $this->tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
    }

    private function addTestData( $tree )
    {
        $primates = array(
            'Hominoidea' => array(
                'Hylobatidae' => array(
                    'Hylobates' => array(
                        'Lar Gibbon',
                        'Agile Gibbon',
                        'Müller\'s Bornean Gibbon',
                        'Silvery Gibbon',
                        'Pileated Gibbon',
                        'Kloss\'s Gibbon',
                    ),
                    'Hoolock' => array(
                        'Western Hoolock Gibbon',
                        'Eastern Hoolock Gibbon',
                    ),
                    'Symphalangus' => array(),
                    'Nomascus' => array(
                        'Black Crested Gibbon',
                        'Eastern Black Crested Gibbon',
                        'White-cheecked Crested Gibbon',
                        'Yellow-cheecked Gibbon',
                    ),
                ),
                'Hominidae' => array(
                    'Pongo' => array(
                        'Bornean Orangutan',
                        'Sumatran Orangutan',
                    ), 
                    'Gorilla' => array(
                        'Western Gorilla' => array(
                            'Western Lowland Gorilla',
                            'Cross River Gorilla',
                        ),
                        'Eastern Gorilla' => array(
                            'Mountain Gorilla',
                            'Eastern Lowland Gorilla',
                        ),
                    ), 
                    'Homo' => array(
                        'Homo Sapiens' => array(
                            'Homo Sapiens Sapiens',
                            'Homo Superior'
                        ),
                    ),
                    'Pan' => array(
                        'Common Chimpanzee',
                        'Bonobo',
                    ),
                ),
            ),
        );

        $root = $tree->createNode( 'Hominoidea', 'Hominoidea' );
        $tree->setRootNode( $root );

        $this->addChildren( $root, $primates['Hominoidea'] );
    }

    private function addChildren( ezcTreeNode $node, array $children )
    {
        foreach( $children as $name => $child )
        {
            if ( is_array( $child ) )
            {
                $newNode = $node->tree->createNode( $name, $name );
                $node->addChild( $newNode );
                $this->addChildren( $newNode, $child );
            }
            else
            {
                $newNode = $node->tree->createNode( $child, $child );
                $node->addChild( $newNode );
            }
        }
    }

    public function testVisitor1()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorGraphViz;
        $tree->accept( $visitor );
        self::assertSame( 'c422c6271ff3c9a213156e660a1ba8b2', md5( (string) $visitor ) );
    }

    public function testVisitor2()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $expected = <<<END
Hominoidea
├─Hylobatidae
│ ├─Hylobates
│ │ ├─Lar Gibbon
│ │ ├─Agile Gibbon
│ │ ├─Müller's Bornean Gibbon
│ │ ├─Silvery Gibbon
│ │ ├─Pileated Gibbon
│ │ └─Kloss's Gibbon
│ ├─Hoolock
│ │ ├─Western Hoolock Gibbon
│ │ └─Eastern Hoolock Gibbon
│ ├─Symphalangus
│ └─Nomascus
│   ├─Black Crested Gibbon
│   ├─Eastern Black Crested Gibbon
│   ├─White-cheecked Crested Gibbon
│   └─Yellow-cheecked Gibbon
└─Hominidae
  ├─Pongo
  │ ├─Bornean Orangutan
  │ └─Sumatran Orangutan
  ├─Gorilla
  │ ├─Western Gorilla
  │ │ ├─Western Lowland Gorilla
  │ │ └─Cross River Gorilla
  │ └─Eastern Gorilla
  │   ├─Mountain Gorilla
  │   └─Eastern Lowland Gorilla
  ├─Homo
  │ └─Homo Sapiens
  │   ├─Homo Sapiens Sapiens
  │   └─Homo Superior
  └─Pan
    ├─Common Chimpanzee
    └─Bonobo

END;

        $visitor = new ezcTreeVisitorPlainText;
        $tree->accept( $visitor );
        self::assertSame( $expected, (string) $visitor );

        $visitor = new ezcTreeVisitorPlainText( ezcTreeVisitorPlainText::SYMBOL_UTF8 );
        $tree->accept( $visitor );
        self::assertSame( $expected, (string) $visitor );
    }

    public function testVisitor3()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorPlainText( ezcTreeVisitorPlainText::SYMBOL_ASCII );
        $tree->accept( $visitor );
        $expected = <<<END
Hominoidea
+-Hylobatidae
| +-Hylobates
| | +-Lar Gibbon
| | +-Agile Gibbon
| | +-Müller's Bornean Gibbon
| | +-Silvery Gibbon
| | +-Pileated Gibbon
| | +-Kloss's Gibbon
| +-Hoolock
| | +-Western Hoolock Gibbon
| | +-Eastern Hoolock Gibbon
| +-Symphalangus
| +-Nomascus
|   +-Black Crested Gibbon
|   +-Eastern Black Crested Gibbon
|   +-White-cheecked Crested Gibbon
|   +-Yellow-cheecked Gibbon
+-Hominidae
  +-Pongo
  | +-Bornean Orangutan
  | +-Sumatran Orangutan
  +-Gorilla
  | +-Western Gorilla
  | | +-Western Lowland Gorilla
  | | +-Cross River Gorilla
  | +-Eastern Gorilla
  |   +-Mountain Gorilla
  |   +-Eastern Lowland Gorilla
  +-Homo
  | +-Homo Sapiens
  |   +-Homo Sapiens Sapiens
  |   +-Homo Superior
  +-Pan
    +-Common Chimpanzee
    +-Bonobo

END;
        self::assertSame( $expected, (string) $visitor );
    }

    public function testVisitorXHTMLDefault()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $tree->accept( $visitor );
        $expected = <<<END
  <ul>
    <li><a href="/Hylobatidae">Hylobatidae</a>
      <ul>
        <li><a href="/Hylobatidae/Hylobates">Hylobates</a>
          <ul>
            <li><a href="/Hylobatidae/Hylobates/Lar Gibbon">Lar Gibbon</a></li>
            <li><a href="/Hylobatidae/Hylobates/Agile Gibbon">Agile Gibbon</a></li>
            <li><a href="/Hylobatidae/Hylobates/Müller's Bornean Gibbon">Müller's Bornean Gibbon</a></li>
            <li><a href="/Hylobatidae/Hylobates/Silvery Gibbon">Silvery Gibbon</a></li>
            <li><a href="/Hylobatidae/Hylobates/Pileated Gibbon">Pileated Gibbon</a></li>
            <li><a href="/Hylobatidae/Hylobates/Kloss's Gibbon">Kloss's Gibbon</a></li>
          </ul>
        </li>
        <li><a href="/Hylobatidae/Hoolock">Hoolock</a>
          <ul>
            <li><a href="/Hylobatidae/Hoolock/Western Hoolock Gibbon">Western Hoolock Gibbon</a></li>
            <li><a href="/Hylobatidae/Hoolock/Eastern Hoolock Gibbon">Eastern Hoolock Gibbon</a></li>
          </ul>
        </li>
        <li><a href="/Hylobatidae/Symphalangus">Symphalangus</a></li>
        <li><a href="/Hylobatidae/Nomascus">Nomascus</a>
          <ul>
            <li><a href="/Hylobatidae/Nomascus/Black Crested Gibbon">Black Crested Gibbon</a></li>
            <li><a href="/Hylobatidae/Nomascus/Eastern Black Crested Gibbon">Eastern Black Crested Gibbon</a></li>
            <li><a href="/Hylobatidae/Nomascus/White-cheecked Crested Gibbon">White-cheecked Crested Gibbon</a></li>
            <li><a href="/Hylobatidae/Nomascus/Yellow-cheecked Gibbon">Yellow-cheecked Gibbon</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="/Hominidae">Hominidae</a>
      <ul>
        <li><a href="/Hominidae/Pongo">Pongo</a>
          <ul>
            <li><a href="/Hominidae/Pongo/Bornean Orangutan">Bornean Orangutan</a></li>
            <li><a href="/Hominidae/Pongo/Sumatran Orangutan">Sumatran Orangutan</a></li>
          </ul>
        </li>
        <li><a href="/Hominidae/Gorilla">Gorilla</a>
          <ul>
            <li><a href="/Hominidae/Gorilla/Western Gorilla">Western Gorilla</a>
              <ul>
                <li><a href="/Hominidae/Gorilla/Western Gorilla/Western Lowland Gorilla">Western Lowland Gorilla</a></li>
                <li><a href="/Hominidae/Gorilla/Western Gorilla/Cross River Gorilla">Cross River Gorilla</a></li>
              </ul>
            </li>
            <li><a href="/Hominidae/Gorilla/Eastern Gorilla">Eastern Gorilla</a>
              <ul>
                <li><a href="/Hominidae/Gorilla/Eastern Gorilla/Mountain Gorilla">Mountain Gorilla</a></li>
                <li><a href="/Hominidae/Gorilla/Eastern Gorilla/Eastern Lowland Gorilla">Eastern Lowland Gorilla</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="/Hominidae/Homo">Homo</a>
          <ul>
            <li><a href="/Hominidae/Homo/Homo Sapiens">Homo Sapiens</a>
              <ul>
                <li><a href="/Hominidae/Homo/Homo Sapiens/Homo Sapiens Sapiens">Homo Sapiens Sapiens</a></li>
                <li><a href="/Hominidae/Homo/Homo Sapiens/Homo Superior">Homo Superior</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="/Hominidae/Pan">Pan</a>
          <ul>
            <li><a href="/Hominidae/Pan/Common Chimpanzee">Common Chimpanzee</a></li>
            <li><a href="/Hominidae/Pan/Bonobo">Bonobo</a></li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLDisplayRootNode()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->displayRootNode = true;

        $tree->accept( $visitor );
        $expected = <<<END
<ul>
<li>Hominoidea</li>
  <ul>
    <li><a href="/Hominoidea/Hylobatidae">Hylobatidae</a>
      <ul>
        <li><a href="/Hominoidea/Hylobatidae/Hylobates">Hylobates</a>
          <ul>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Lar Gibbon">Lar Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Agile Gibbon">Agile Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Müller's Bornean Gibbon">Müller's Bornean Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Silvery Gibbon">Silvery Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Pileated Gibbon">Pileated Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hylobates/Kloss's Gibbon">Kloss's Gibbon</a></li>
          </ul>
        </li>
        <li><a href="/Hominoidea/Hylobatidae/Hoolock">Hoolock</a>
          <ul>
            <li><a href="/Hominoidea/Hylobatidae/Hoolock/Western Hoolock Gibbon">Western Hoolock Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Hoolock/Eastern Hoolock Gibbon">Eastern Hoolock Gibbon</a></li>
          </ul>
        </li>
        <li><a href="/Hominoidea/Hylobatidae/Symphalangus">Symphalangus</a></li>
        <li><a href="/Hominoidea/Hylobatidae/Nomascus">Nomascus</a>
          <ul>
            <li><a href="/Hominoidea/Hylobatidae/Nomascus/Black Crested Gibbon">Black Crested Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Nomascus/Eastern Black Crested Gibbon">Eastern Black Crested Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Nomascus/White-cheecked Crested Gibbon">White-cheecked Crested Gibbon</a></li>
            <li><a href="/Hominoidea/Hylobatidae/Nomascus/Yellow-cheecked Gibbon">Yellow-cheecked Gibbon</a></li>
          </ul>
        </li>
      </ul>
    </li>
    <li><a href="/Hominoidea/Hominidae">Hominidae</a>
      <ul>
        <li><a href="/Hominoidea/Hominidae/Pongo">Pongo</a>
          <ul>
            <li><a href="/Hominoidea/Hominidae/Pongo/Bornean Orangutan">Bornean Orangutan</a></li>
            <li><a href="/Hominoidea/Hominidae/Pongo/Sumatran Orangutan">Sumatran Orangutan</a></li>
          </ul>
        </li>
        <li><a href="/Hominoidea/Hominidae/Gorilla">Gorilla</a>
          <ul>
            <li><a href="/Hominoidea/Hominidae/Gorilla/Western Gorilla">Western Gorilla</a>
              <ul>
                <li><a href="/Hominoidea/Hominidae/Gorilla/Western Gorilla/Western Lowland Gorilla">Western Lowland Gorilla</a></li>
                <li><a href="/Hominoidea/Hominidae/Gorilla/Western Gorilla/Cross River Gorilla">Cross River Gorilla</a></li>
              </ul>
            </li>
            <li><a href="/Hominoidea/Hominidae/Gorilla/Eastern Gorilla">Eastern Gorilla</a>
              <ul>
                <li><a href="/Hominoidea/Hominidae/Gorilla/Eastern Gorilla/Mountain Gorilla">Mountain Gorilla</a></li>
                <li><a href="/Hominoidea/Hominidae/Gorilla/Eastern Gorilla/Eastern Lowland Gorilla">Eastern Lowland Gorilla</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="/Hominoidea/Hominidae/Homo">Homo</a>
          <ul>
            <li><a href="/Hominoidea/Hominidae/Homo/Homo Sapiens">Homo Sapiens</a>
              <ul>
                <li><a href="/Hominoidea/Hominidae/Homo/Homo Sapiens/Homo Sapiens Sapiens">Homo Sapiens Sapiens</a></li>
                <li><a href="/Hominoidea/Hominidae/Homo/Homo Sapiens/Homo Superior">Homo Superior</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="/Hominoidea/Hominidae/Pan">Pan</a>
          <ul>
            <li><a href="/Hominoidea/Hominidae/Pan/Common Chimpanzee">Common Chimpanzee</a></li>
            <li><a href="/Hominoidea/Hominidae/Pan/Bonobo">Bonobo</a></li>
          </ul>
        </li>
      </ul>
    </li>
  </ul>
</ul>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLXmlId()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorXHTML();
        $visitor->options->xmlId = 'tree_id';

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = <<<END
  <ul id="tree_id">
    <li><a href="/Hylobatidae/Hylobates">Hylobates</a>
      <ul>
        <li><a href="/Hylobatidae/Hylobates/Lar Gibbon">Lar Gibbon</a></li>
        <li><a href="/Hylobatidae/Hylobates/Agile Gibbon">Agile Gibbon</a></li>
        <li><a href="/Hylobatidae/Hylobates/Müller's Bornean Gibbon">Müller's Bornean Gibbon</a></li>
        <li><a href="/Hylobatidae/Hylobates/Silvery Gibbon">Silvery Gibbon</a></li>
        <li><a href="/Hylobatidae/Hylobates/Pileated Gibbon">Pileated Gibbon</a></li>
        <li><a href="/Hylobatidae/Hylobates/Kloss's Gibbon">Kloss's Gibbon</a></li>
      </ul>
    </li>
    <li><a href="/Hylobatidae/Hoolock">Hoolock</a>
      <ul>
        <li><a href="/Hylobatidae/Hoolock/Western Hoolock Gibbon">Western Hoolock Gibbon</a></li>
        <li><a href="/Hylobatidae/Hoolock/Eastern Hoolock Gibbon">Eastern Hoolock Gibbon</a></li>
      </ul>
    </li>
    <li><a href="/Hylobatidae/Symphalangus">Symphalangus</a></li>
    <li><a href="/Hylobatidae/Nomascus">Nomascus</a>
      <ul>
        <li><a href="/Hylobatidae/Nomascus/Black Crested Gibbon">Black Crested Gibbon</a></li>
        <li><a href="/Hylobatidae/Nomascus/Eastern Black Crested Gibbon">Eastern Black Crested Gibbon</a></li>
        <li><a href="/Hylobatidae/Nomascus/White-cheecked Crested Gibbon">White-cheecked Crested Gibbon</a></li>
        <li><a href="/Hylobatidae/Nomascus/Yellow-cheecked Gibbon">Yellow-cheecked Gibbon</a></li>
      </ul>
    </li>
  </ul>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLNoLinks()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorXHTMLOptions;
        $options->addLinks = false;
        $visitor = new ezcTreeVisitorXHTML( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = <<<END
  <ul>
    <li>Hylobates
      <ul>
        <li>Lar Gibbon</li>
        <li>Agile Gibbon</li>
        <li>Müller's Bornean Gibbon</li>
        <li>Silvery Gibbon</li>
        <li>Pileated Gibbon</li>
        <li>Kloss's Gibbon</li>
      </ul>
    </li>
    <li>Hoolock
      <ul>
        <li>Western Hoolock Gibbon</li>
        <li>Eastern Hoolock Gibbon</li>
      </ul>
    </li>
    <li>Symphalangus</li>
    <li>Nomascus
      <ul>
        <li>Black Crested Gibbon</li>
        <li>Eastern Black Crested Gibbon</li>
        <li>White-cheecked Crested Gibbon</li>
        <li>Yellow-cheecked Gibbon</li>
      </ul>
    </li>
  </ul>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorXHTMLHighlightNodes()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorXHTMLOptions;
        $options->highlightNodeIds = array( 'Nomascus', 'Eastern Black Crested Gibbon' );
        $options->addLinks = false;
        $visitor = new ezcTreeVisitorXHTML( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = <<<END
  <ul>
    <li>Hylobates
      <ul>
        <li>Lar Gibbon</li>
        <li>Agile Gibbon</li>
        <li>Müller's Bornean Gibbon</li>
        <li>Silvery Gibbon</li>
        <li>Pileated Gibbon</li>
        <li>Kloss's Gibbon</li>
      </ul>
    </li>
    <li>Hoolock
      <ul>
        <li>Western Hoolock Gibbon</li>
        <li>Eastern Hoolock Gibbon</li>
      </ul>
    </li>
    <li>Symphalangus</li>
    <li class="highlight">Nomascus
      <ul>
        <li>Black Crested Gibbon</li>
        <li class="highlight">Eastern Black Crested Gibbon</li>
        <li>White-cheecked Crested Gibbon</li>
        <li>Yellow-cheecked Gibbon</li>
      </ul>
    </li>
  </ul>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorTest" );
    }
}

?>
