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
class ezcTreeVisitorYUITest extends ezcTreeVisitorTest
{
    public function testVisitorYUIDefault()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $tree->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
      <div class='bd'>
      <ul>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae'>Hylobatidae</a>
          <div id='Hylobatidae' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates'>Hylobates</a>
                  <div id='Hylobates' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Lar Gibbon'>Lar Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Agile Gibbon'>Agile Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Silvery Gibbon'>Silvery Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Pileated Gibbon'>Pileated Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock'>Hoolock</a>
                  <div id='Hoolock' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Symphalangus'>Symphalangus</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus'>Nomascus</a>
                  <div id='Nomascus' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hominidae'>Hominidae</a>
          <div id='Hominidae' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pongo'>Pongo</a>
                  <div id='Pongo' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pongo/Bornean Orangutan'>Bornean Orangutan</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pongo/Sumatran Orangutan'>Sumatran Orangutan</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla'>Gorilla</a>
                  <div id='Gorilla' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Western Gorilla'>Western Gorilla</a>
                          <div id='Western Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Western Gorilla/Western Lowland Gorilla'>Western Lowland Gorilla</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Western Gorilla/Cross River Gorilla'>Cross River Gorilla</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Eastern Gorilla'>Eastern Gorilla</a>
                          <div id='Eastern Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Eastern Gorilla/Mountain Gorilla'>Mountain Gorilla</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Gorilla/Eastern Gorilla/Eastern Lowland Gorilla'>Eastern Lowland Gorilla</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Homo'>Homo</a>
                  <div id='Homo' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Homo/Homo Sapiens'>Homo Sapiens</a>
                          <div id='Homo Sapiens' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Homo/Homo Sapiens/Homo Sapiens Sapiens'>Homo Sapiens Sapiens</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Homo/Homo Sapiens/Homo Superior'>Homo Superior</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pan'>Pan</a>
                  <div id='Pan' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pan/Common Chimpanzee'>Common Chimpanzee</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae/Pan/Bonobo'>Bonobo</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUIDisplayRootNode()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $visitor->options->displayRootNode = true;

        $tree->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
  <div class='bd'>
    <ul>
      <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hominoidea/Hylobatidae'>Hominoidea</a>
          <div id='Hominoidea' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae'>Hylobatidae</a>
                  <div id='Hylobatidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates'>Hylobates</a>
                          <div id='Hylobates' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Lar Gibbon'>Lar Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Agile Gibbon'>Agile Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Silvery Gibbon'>Silvery Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Pileated Gibbon'>Pileated Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hylobates/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hoolock'>Hoolock</a>
                          <div id='Hoolock' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hoolock/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Hoolock/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Symphalangus'>Symphalangus</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Nomascus'>Nomascus</a>
                          <div id='Nomascus' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Nomascus/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Nomascus/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Nomascus/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hylobatidae/Nomascus/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae'>Hominidae</a>
                  <div id='Hominidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pongo'>Pongo</a>
                          <div id='Pongo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pongo/Bornean Orangutan'>Bornean Orangutan</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pongo/Sumatran Orangutan'>Sumatran Orangutan</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla'>Gorilla</a>
                          <div id='Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Western Gorilla'>Western Gorilla</a>
                                  <div id='Western Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Western Gorilla/Western Lowland Gorilla'>Western Lowland Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Western Gorilla/Cross River Gorilla'>Cross River Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Eastern Gorilla'>Eastern Gorilla</a>
                                  <div id='Eastern Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Eastern Gorilla/Mountain Gorilla'>Mountain Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Gorilla/Eastern Gorilla/Eastern Lowland Gorilla'>Eastern Lowland Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Homo'>Homo</a>
                          <div id='Homo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Homo/Homo Sapiens'>Homo Sapiens</a>
                                  <div id='Homo Sapiens' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Homo/Homo Sapiens/Homo Sapiens Sapiens'>Homo Sapiens Sapiens</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Homo/Homo Sapiens/Homo Superior'>Homo Superior</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pan'>Pan</a>
                          <div id='Pan' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pan/Common Chimpanzee'>Common Chimpanzee</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominoidea/Hominidae/Pan/Bonobo'>Bonobo</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
      </li>
    </ul>
  </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUISelectedNodeLink1()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $visitor->options->selectedNodeLink = true;

        $tree->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
      <div class='bd'>
      <ul>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae'>Hylobatidae</a>
          <div id='Hylobatidae' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobates'>Hylobates</a>
                  <div id='Hylobates' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Lar Gibbon'>Lar Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Agile Gibbon'>Agile Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Silvery Gibbon'>Silvery Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pileated Gibbon'>Pileated Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hoolock'>Hoolock</a>
                  <div id='Hoolock' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Symphalangus'>Symphalangus</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Nomascus'>Nomascus</a>
                  <div id='Nomascus' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hominidae'>Hominidae</a>
          <div id='Hominidae' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pongo'>Pongo</a>
                  <div id='Pongo' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Bornean Orangutan'>Bornean Orangutan</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Sumatran Orangutan'>Sumatran Orangutan</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Gorilla'>Gorilla</a>
                  <div id='Gorilla' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Gorilla'>Western Gorilla</a>
                          <div id='Western Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Lowland Gorilla'>Western Lowland Gorilla</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Cross River Gorilla'>Cross River Gorilla</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Gorilla'>Eastern Gorilla</a>
                          <div id='Eastern Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Mountain Gorilla'>Mountain Gorilla</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Lowland Gorilla'>Eastern Lowland Gorilla</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo'>Homo</a>
                  <div id='Homo' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Sapiens'>Homo Sapiens</a>
                          <div id='Homo Sapiens' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Sapiens Sapiens'>Homo Sapiens Sapiens</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Superior'>Homo Superior</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pan'>Pan</a>
                  <div id='Pan' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Common Chimpanzee'>Common Chimpanzee</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Bonobo'>Bonobo</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUISelectedNodeLink2()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $visitor->options->displayRootNode = true;
        $visitor->options->selectedNodeLink = true;

        $tree->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
  <div class='bd'>
    <ul>
      <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hominoidea/Hylobatidae'>Hominoidea</a>
          <div id='Hominoidea' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae'>Hylobatidae</a>
                  <div id='Hylobatidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobates'>Hylobates</a>
                          <div id='Hylobates' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Lar Gibbon'>Lar Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Agile Gibbon'>Agile Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Silvery Gibbon'>Silvery Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pileated Gibbon'>Pileated Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hoolock'>Hoolock</a>
                          <div id='Hoolock' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Symphalangus'>Symphalangus</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Nomascus'>Nomascus</a>
                          <div id='Nomascus' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hominidae'>Hominidae</a>
                  <div id='Hominidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pongo'>Pongo</a>
                          <div id='Pongo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Bornean Orangutan'>Bornean Orangutan</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Sumatran Orangutan'>Sumatran Orangutan</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Gorilla'>Gorilla</a>
                          <div id='Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Gorilla'>Western Gorilla</a>
                                  <div id='Western Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Western Lowland Gorilla'>Western Lowland Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Cross River Gorilla'>Cross River Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Gorilla'>Eastern Gorilla</a>
                                  <div id='Eastern Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Mountain Gorilla'>Mountain Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Eastern Lowland Gorilla'>Eastern Lowland Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo'>Homo</a>
                          <div id='Homo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Sapiens'>Homo Sapiens</a>
                                  <div id='Homo Sapiens' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Sapiens Sapiens'>Homo Sapiens Sapiens</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Homo Superior'>Homo Superior</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Pan'>Pan</a>
                          <div id='Pan' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Common Chimpanzee'>Common Chimpanzee</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Bonobo'>Bonobo</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
      </li>
    </ul>
  </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUISelectedNodeLink3()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $visitor->options->displayRootNode = true;
        $visitor->options->selectedNodeLink = true;
        $visitor->options->basePath = 'testing';

        $tree->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
  <div class='bd'>
    <ul>
      <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hominoidea/Hylobatidae'>Hominoidea</a>
          <div id='Hominoidea' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Hylobatidae'>Hylobatidae</a>
                  <div id='Hylobatidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Hylobates'>Hylobates</a>
                          <div id='Hylobates' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Lar Gibbon'>Lar Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Agile Gibbon'>Agile Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Silvery Gibbon'>Silvery Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Pileated Gibbon'>Pileated Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Hoolock'>Hoolock</a>
                          <div id='Hoolock' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Symphalangus'>Symphalangus</a></li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Nomascus'>Nomascus</a>
                          <div id='Nomascus' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Hominidae'>Hominidae</a>
                  <div id='Hominidae' class='yuimenu'>
                    <div class='bd'>
                      <ul>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Pongo'>Pongo</a>
                          <div id='Pongo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Bornean Orangutan'>Bornean Orangutan</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Sumatran Orangutan'>Sumatran Orangutan</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Gorilla'>Gorilla</a>
                          <div id='Gorilla' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Western Gorilla'>Western Gorilla</a>
                                  <div id='Western Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Western Lowland Gorilla'>Western Lowland Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Cross River Gorilla'>Cross River Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Eastern Gorilla'>Eastern Gorilla</a>
                                  <div id='Eastern Gorilla' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Mountain Gorilla'>Mountain Gorilla</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Eastern Lowland Gorilla'>Eastern Lowland Gorilla</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Homo'>Homo</a>
                          <div id='Homo' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Homo Sapiens'>Homo Sapiens</a>
                                  <div id='Homo Sapiens' class='yuimenu'>
                                    <div class='bd'>
                                      <ul>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Homo Sapiens Sapiens'>Homo Sapiens Sapiens</a></li>
                                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Homo Superior'>Homo Superior</a></li>
                                      </ul>
                                    </div>
                                  </div>
                                </li>
                              </ul>
                            </div>
                          </div>
                        </li>
                        <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Pan'>Pan</a>
                          <div id='Pan' class='yuimenu'>
                            <div class='bd'>
                              <ul>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Common Chimpanzee'>Common Chimpanzee</a></li>
                                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='testing/Bonobo'>Bonobo</a></li>
                              </ul>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
      </li>
    </ul>
  </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUIXmlId()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $visitor = new ezcTreeVisitorYUI();
        $visitor->options->xmlId = 'productsandservices';

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = <<<END
<div id="productsandservices" class='yuimenubar yuimenubarnav'>
      <div class='bd'>
      <ul>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Hylobates'>Hylobates</a>
          <div id='Hylobates' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Lar Gibbon'>Lar Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Agile Gibbon'>Agile Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Silvery Gibbon'>Silvery Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Pileated Gibbon'>Pileated Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Hoolock'>Hoolock</a>
          <div id='Hoolock' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Symphalangus'>Symphalangus</a></li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Nomascus'>Nomascus</a>
          <div id='Nomascus' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public function testVisitorYUIHighlightNodes()
    {
        $tree = ezcTreeMemory::create( new ezcTreeMemoryDataStore() );
        $this->addTestData( $tree );

        $options = new ezcTreeVisitorYUIOptions;
        $options->highlightNodeIds = array( 'Nomascus', 'Eastern Black Crested Gibbon', 'Hoolock' );
        $visitor = new ezcTreeVisitorYUI( $options );

        $tree->fetchNodeById( 'Hylobatidae' )->accept( $visitor );
        $expected = <<<END
<div class='yuimenubar yuimenubarnav'>
      <div class='bd'>
      <ul>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Hylobates'>Hylobates</a>
          <div id='Hylobates' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Lar Gibbon'>Lar Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Agile Gibbon'>Agile Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Müller&#039;s Bornean Gibbon'>Müller's Bornean Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Silvery Gibbon'>Silvery Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Pileated Gibbon'>Pileated Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hylobates/Kloss&#039;s Gibbon'>Kloss's Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel highlight' href='/Hylobatidae/Hoolock'>Hoolock</a>
          <div id='Hoolock' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Western Hoolock Gibbon'>Western Hoolock Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Hoolock/Eastern Hoolock Gibbon'>Eastern Hoolock Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel' href='/Hylobatidae/Symphalangus'>Symphalangus</a></li>
        <li class='yuimenubaritem'><a class='yuimenubaritemlabel highlight' href='/Hylobatidae/Nomascus'>Nomascus</a>
          <div id='Nomascus' class='yuimenu'>
            <div class='bd'>
              <ul>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Black Crested Gibbon'>Black Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel highlight' href='/Hylobatidae/Nomascus/Eastern Black Crested Gibbon'>Eastern Black Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/White-cheecked Crested Gibbon'>White-cheecked Crested Gibbon</a></li>
                <li class='yuimenuitem'><a class='yuimenuitemlabel' href='/Hylobatidae/Nomascus/Yellow-cheecked Gibbon'>Yellow-cheecked Gibbon</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
</div>

END;
        self::assertSame( $expected, $visitor->__toString() );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( "ezcTreeVisitorYUITest" );
    }
}

?>
