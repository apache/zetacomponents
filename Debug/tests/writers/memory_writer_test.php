<?php


class ezcDebugMemoryWriterTest extends ezcTestCase
{
	public function setUp()
	{        
        date_default_timezone_set("UTC");
        $this->writer = new ezcDebugMemoryWriter();
	}

    public function testSingleMessage()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $data = $this->writer->getStructure();

        $this->assertEquals($data[0]->message, "msg");
        $this->assertEquals($data[0]->verbosity, 2);
        $this->assertEquals($data[0]->severity, 1);
        $this->assertEquals($data[0]->source, "src");
        $this->assertEquals($data[0]->category, "cat");
        $this->assertNotEquals($data[0]->datetime, "");
    }

    public function testTwoMessages()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg2", 12, "src2", "cat2", array("verbosity" => 22) );
        $data = $this->writer->getStructure();

        $this->assertEquals($data[0]->message, "msg");
        $this->assertEquals($data[0]->verbosity, 2);
        $this->assertEquals($data[0]->severity, 1);
        $this->assertEquals($data[0]->source, "src");
        $this->assertEquals($data[0]->category, "cat");
        $this->assertNotEquals($data[0]->datetime, "");

        $this->assertEquals($data[1]->message, "msg2");
        $this->assertEquals($data[1]->verbosity, 22);
        $this->assertEquals($data[1]->severity, 12);
        $this->assertEquals($data[1]->source, "src2");
        $this->assertEquals($data[1]->category, "cat2");
        $this->assertNotEquals($data[1]->datetime, "");

        $this->assertEquals(count( $data ), 2);
    }

    public function testMultipleMessages()
    {
        $this->writer->reset();
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $this->writer->writeLogMessage( "msg", 1, "src", "cat", array("verbosity" => 2) );
        $data = $this->writer->getStructure();

        $this->assertEquals(count( $data ), 6);
    }


    public static function suite()
    {
        return new ezcTestSuite("ezcDebugMemoryWriterTest");
    }
}


?>
