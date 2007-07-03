<?php
class ezcGraphTestCase extends ezcTestImageCase
{

    /**
     * Compares to flash files comparing the output of `swftophp`
     * 
     * @param string $generated Filename of generated image
     * @param string $compare Filename of stored image
     * @return void
     */
    protected function swfCompare( $generated, $compare )
    {
        $this->assertTrue(
            file_exists( $generated ),
            'No image file has been created.'
        );

        $this->assertTrue(
            file_exists( $compare ),
            'Comparision image does not exist.'
        );

        $executeable = ezcBaseFeatures::findExecutableInPath( 'swftophp' );

        if ( !$executeable )
        {
            $this->markTestSkipped( 'Could not find swftophp executeable to compare flash files. Please check your $PATH.' );
        }

        $generatedCode = shell_exec( $executeable . ' ' . escapeshellarg( $generated ) );
        $compareCode = shell_exec( $executeable . ' ' . escapeshellarg( $compare ) );

        foreach ( 
            array(
                'generatedCode' => $generatedCode,
                'compareCode' => $compareCode,
            ) as $var => $content )
        {
            $content = preg_replace( '/\$[sf]\d+/', '$var', $content );
            $content = preg_replace( '[/\\*.*\\*/]i', '/* Comment irrelevant */', $content );

            $$var = $content;
        }

        $this->assertEquals(
            $generatedCode,
            $compareCode,
            'Rendered image is not correct.'
        );
    }

    /**
     * Compares a generated image with a stored file
     * 
     * @param string $generated Filename of generated image
     * @param string $compare Filename of stored image
     * @return void
     */
    protected function compare( $generated, $compare )
    {
        $this->assertXmlFileEqualsXmlFile(
            $generated,
            $compare
        );
    }
}

?>
