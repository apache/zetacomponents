<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @version //autogentag//
 * @filesource
 * @package Template
 * @subpackage Tests
 */

/**
 * @package Template
 * @subpackage Tests
 */
class ezcStringFunctionTest extends ezcTestCase
{
    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testLtrim()
    {
        $in = '  test8test test';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::ltrim( $in ), $out );

        $in = '8888test8test test';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::ltrim( $in, '8' ), $out );

        $in = 'üöätest8test test';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::ltrim( $in, 'üöä' ), $out );
    }

    public function testRtrim()
    {
        $in = 'test8test test  ';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::rtrim( $in ), $out );

        $in = 'test8test test888';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::rtrim( $in, '8' ), $out );

        $in = 'test8test testüöä';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::rtrim( $in, 'üöä' ), $out );
    }

    public function testStrpad()
    {
        $in = 'äöüßasdfgh';
        $out = '_____äöüßasdfgh';
        self::assertEquals( ezcTemplateString::str_pad( $in, 15, '_', STR_PAD_LEFT ), $out );

        $in = 'äöüßasdfgh';
        $out = 'äöüßasdfgh_____';
        self::assertEquals( ezcTemplateString::str_pad( $in, 15, '_', STR_PAD_RIGHT ), $out );
    }

    public function testStrParagraphCount()
    {
$in = <<<END
Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet.

Düis äütem vel eüm iriüre dölör in hendrerit in vülpütäte velit esse mölestie cönseqüät, vel illüm dölöre eü feügiät nüllä fäcilisis ät verö erös et äccümsän et iüstö ödiö dignissim qüi bländit präesent lüptätüm zzril delenit äügüe düis dölöre te feügäit nüllä fäcilisi. Lörem ipsüm dölör sit ämet, cönsectetüer ädipiscing elit, sed diäm nönümmy nibh eüismöd tincidünt üt läöreet dölöre mägnä äliqüäm erät völütpät.

Ut wisi enim äd minim veniäm, qüis nöstrüd exerci tätiön üllämcörper süscipit löbörtis nisl üt äliqüip ex eä cömmödö cönseqüät. Düis äütem vel eüm iriüre dölör in hendrerit in vülpütäte velit esse mölestie cönseqüät, vel illüm dölöre eü feügiät nüllä fäcilisis ät verö erös et äccümsän et iüstö ödiö dignissim qüi bländit präesent lüptätüm zzril delenit äügüe düis dölöre te feügäit nüllä fäcilisi.

Näm liber tempör cüm sölütä nöbis eleifend öptiön cöngüe nihil imperdiet döming id qüöd mäzim pläcerät fäcer pössim ässüm. Lörem ipsüm dölör sit ämet, cönsectetüer ädipiscing elit, sed diäm nönümmy nibh eüismöd tincidünt üt läöreet dölöre mägnä äliqüäm erät völütpät. Ut wisi enim äd minim veniäm, qüis nöstrüd exerci tätiön üllämcörper süscipit löbörtis nisl üt äliqüip ex eä cömmödö cönseqüät.

Düis äütem vel eüm iriüre dölör in hendrerit in vülpütäte velit esse mölestie cönseqüät, vel illüm dölöre eü feügiät nüllä fäcilisis.

END;
        $out = 5;
        self::assertEquals( ezcTemplateString::str_paragraph_count( $in ), $out );
    }

    public function testStrWordCount()
    {
        $in = "Lörem ipsüm dölör sit ämet, cönse8tetür sädipscing elitr.";
        $out = 9;
        self::assertEquals( ezcTemplateString::str_word_count( $in ), $out );

        $out = 8;
        self::assertEquals( ezcTemplateString::str_word_count( $in, 0, '8' ), $out );

        $out = array(
            'Lörem',
            'ipsüm',
            'dölör',
            'sit',
            'ämet',
            'cönse',
            'tetür',
            'sädipscing',
            'elitr',
        );
        self::assertEquals( ezcTemplateString::str_word_count( $in, 1 ), $out );

        $out = array(
            'Lörem',
            'ipsüm',
            'dölör',
            'sit',
            'ämet',
            'cönse8tetür',
            'sädipscing',
            'elitr',
        );
        self::assertEquals( ezcTemplateString::str_word_count( $in, 1, '8' ), $out );

        $out = array(
            0 => 'Lörem',
            6 => 'ipsüm',
            12 => 'dölör',
            18 => 'sit',
            22 => 'ämet',
            28 => 'cönse',
            34 => 'tetür',
            40 => 'sädipscing',
            51 => 'elitr',
        );
        self::assertEquals( ezcTemplateString::str_word_count( $in, 2 ), $out );

        $out = array(
            0 => 'Lörem',
            6 => 'ipsüm',
            12 => 'dölör',
            18 => 'sit',
            22 => 'ämet',
            28 => 'cönse8tetür',
            40 => 'sädipscing',
            51 => 'elitr',
        );
        self::assertEquals( ezcTemplateString::str_word_count( $in, 2, '8' ), $out );
    }

    public function testStrpos()
    {
        $in = 'äöüß';
        $out = 1;
        self::assertEquals( ezcTemplateString::strpos( $in, 'ö' ), $out );

        $in = 'äöüß';
        $out = 0;
        self::assertEquals( ezcTemplateString::strpos( $in, 'ä' ), $out );

        $in = 'äöüß';
        $out = false;
        self::assertEquals( ezcTemplateString::strpos( $in, 'q' ), $out );

        $in = 'äöüß';
        $out = 3;
        self::assertEquals( ezcTemplateString::strpos( $in, 'ß', 1 ), $out );
    }

    public function testStrrpos()
    {
        $in = 'äöüß';
        $out = 2;
        self::assertEquals( ezcTemplateString::strrpos( $in, 'ü' ), $out );

        $in = 'äöüß';
        $out = 2;
        self::assertEquals( ezcTemplateString::strrpos( $in, 'ü', 0, false ), $out );

        $in = 'äöüß';
        $out = 2;
        self::assertEquals( ezcTemplateString::strrpos( $in, 'ü', 1, false ), $out );

        $in = 'äöüß';
        $out = 2;
        self::assertEquals( ezcTemplateString::strrpos( $in, 'ü', -1, false ), $out );
    }

    public function testStrrev()
    {
        $in = 'äöüß';
        $out = 'ßüöä';
        self::assertEquals( ezcTemplateString::strrev( $in ), $out );

        $in = 'äaöoüußs';
        $out = 'sßuüoöaä';
        self::assertEquals( ezcTemplateString::strrev( $in ), $out );
    }

    public function testStrtolower()
    {
        $in = 'ÄÖÜÀÉASDFGHJKLtuzerui"§$%&/()=';
        $out = 'äöüàéasdfghjkltuzerui"§$%&/()=';
        // use mb string extension = true
        self::assertEquals( ezcTemplateString::strtolower( $in ), $out );
        // use mb string extension = false to test custom strtolower using conversion table
        self::assertEquals( ezcTemplateString::strtolower( $in, false ), $out );
    }

    public function testStrtoupper()
    {
        $in = 'äöüàéasdfghjkltuzerui"§$%&/()=';
        $out = 'ÄÖÜÀÉASDFGHJKLTUZERUI"§$%&/()=';
        // use mb string extension = true
        self::assertEquals( ezcTemplateString::strtoupper( $in ), $out );
        // use mb string extension = false to test custom strtolower using conversion table
        self::assertEquals( ezcTemplateString::strtoupper( $in, false ), $out );
    }

    public function testTrim()
    {
        $in = '  test8test test  ';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::trim( $in ), $out );

        $in = '888test8test test888';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::trim( $in, '8' ), $out );

        $in = 'üöätest8test testüöä';
        $out = 'test8test test';
        self::assertEquals( ezcTemplateString::trim( $in, 'üöä' ), $out );
    }

    public function testUcfirst()
    {
        $in = 'äaöoüußs';
        $out = 'Äaöoüußs';
        self::assertEquals( ezcTemplateString::ucfirst( $in ), $out );

        $in = 'aäaöoüußs';
        $out = 'Aäaöoüußs';
        self::assertEquals( ezcTemplateString::ucfirst( $in ), $out );
    }

    public function testWordwrap()
    {
$in = <<<END
Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet.
END;
$out = <<<END
Lörem ipsüm dölör sit ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd
tempör invidünt üt läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At
verö eös et äccüsäm et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren,
nö seä täkimätä sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit
ämet, cönsetetür sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt
läböre et dölöre mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm
et jüstö düö dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä
sänctüs est Lörem ipsüm dölör sit ämet. Lörem ipsüm dölör sit ämet, cönsetetür
sädipscing elitr, sed diäm nönümy eirmöd tempör invidünt üt läböre et dölöre
mägnä äliqüyäm erät, sed diäm völüptüä. At verö eös et äccüsäm et jüstö düö
dölöres et eä rebüm. Stet clitä käsd gübergren, nö seä täkimätä sänctüs est
Lörem ipsüm dölör sit ämet.
END;
        self::assertEquals( ezcTemplateString::wordwrap( $in, 80, "\n" ), $out );
    }
}

?>