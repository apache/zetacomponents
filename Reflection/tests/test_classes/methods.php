<?php

class TestMethods {

    /**
     * @oneannotationonly
     */
    public function __construct() {

    }

    /**
     * @param
     * @author
     */
    public function m1() {

    }

    /**
     * @foo
     * @bar
     * @foobar
     */
    public function m2() {

    }

    /**
     * This is the short description
     *
     * This is the long description with may be additional infos and much more lines
     * of text.
     *
     * Empty lines are valide to.
     *
     * foo bar
     */
    public function m3($undocumented) {
        static $staticVar;
    }


    /**
     * To check whether an annotation was used
     * @restmethod POST /\/(.*?)\/m4\//
     * @restin XbelSerializer
     * @restout XbelSerializer
     * @webmethod
     * @author
     * @param string $test
     * @param ezcReflection $test2
     * @param NonExistingType $test3
     * @return string Hello
     *         World!
     */
    public function m4() {

    }
}

?>
