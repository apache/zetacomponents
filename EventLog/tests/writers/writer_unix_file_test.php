<?php

class ezcLogUnixFileWriterTest extends ezcTestCase
{
    protected $writer;

    public function setUp()
    {
        $this->createTempDir("ezcLogTest_");
        $this->writer = new ezcLogUnixFileWriter( $this->getTempDir(), "default.log" );
    }

    public function tearDown()
    {
        $this->removeTempDir();
    }

    public function testFileStructure()
    {
        $m = array("message" => "Alien alert.", "type" => 1, "source" => "UFO report", "category" => "fake warning" );
        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[UFO report\] \[fake warning\] Alien alert./";

        $this->assertRegExp($regExp, "Jan 24 09:32:26 [Debug] [UFO report] [fake warning] Alien alert.", "Testing myself");

        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"] );
        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() ."/default.log" ), 
                                "Content of default.log doesn't match with the regular expression.");
    }

    public function testExtraFields()
    {
        $m = array("message" => "Alien alert.", "type" => 1, "source" => "UFO report", "category" => "fake warning");
        $extra = array ("Line" => 42);
        $regExp = "/(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d+ \d+:\d+:\d+ \[Debug\] \[UFO report\] \[fake warning\] Alien alert. \(Line: 42\)/";

        $this->writer->writeLogMessage( $m["message"], $m["type"], $m["source"], $m["category"], $extra );
        $this->assertRegExp( $regExp, file_get_contents( $this->getTempDir() ."/default.log" ), 
                                "Content of default.log doesn't match with the regular expression.");
    }
    
	public static function suite()
	{
		return new ezcTestSuite("ezcLogUnixFileWriterTest");
	}
}

?>
