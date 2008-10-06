<?php
/**
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package MvcTools
 * @subpackage Tests
 */

/**
 * Test the handler classes.
 *
 * @package MvcTools
 * @subpackage Tests
 */
class ezcMvcToolsBugzillaRequestFilterTest extends ezcTestCase
{
    public function testFilter()
    {
        $request = new ezcMvcRequest;
        $request->variables['subject'] = 'The short description';
        $request->body = <<<ENDBODY
@product      = Bugzilla
@component    = general
@version      = All
@groupset     = ReadWorld ReadPartners
@op_sys       = Linux
@priority     = P3
@rep_platform = i386

This is the description of the bug I found. It is not necessary to start
it with a keyword.

Note: The short_description is necessary and may be given with the keyword
@short_description or will be retrieved from the mail subject.
ENDBODY;
        $filter = new ezcMvcMailBugzillaRequestFilter();
        $filter->filterRequest( $request );

        self::assertSame( $request->variables['short_desc'], "The short description" );
        self::assertSame( $request->variables['description'], "This is the description of the bug I found. It is not necessary to start it with a keyword. Note: The short_description is necessary and may be given with the keyword @short_description or will be retrieved from the mail subject." );
        self::assertSame( $request->variables['product'], "Bugzilla" );
        self::assertSame( $request->variables['rep_platform'], "i386" );
    }

    public function testFilterWithOverriddenShortDesc()
    {
        $request = new ezcMvcRequest;
        $request->variables['subject'] = 'The short description';
        $request->body = <<<ENDBODY
@short_desc = The overridden
short description
@product    = eZ Components
ENDBODY;
        $filter = new ezcMvcMailBugzillaRequestFilter();
        $filter->filterRequest( $request );

        self::assertSame( $request->variables['product'], "eZ Components" );
        self::assertSame( $request->variables['short_desc'], "The overridden short description" );
    }

    public static function suite()
    {
         return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }
}
?>
