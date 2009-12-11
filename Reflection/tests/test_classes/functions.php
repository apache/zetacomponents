<?php

/**
 * To check whether an annotation was used
 * @webmethod
 * @author
 * @param string $test
 * @param ezcReflectionApi $test2
 * @param ReflectionClass $test3
 * @return string Hello World
 */
function m1($test, $test2, &$test3) {
    return 'Hello World';
}

function mmm($t = 'foo') {}

/**
 * @param void $DocuFlaw
 * @param boolean
 * @author flaw joe
weird coding standards should also be supported: */function m2() {

}

function m3() {
    static $staticVar;
}

/**
 * Enter description here...
 *
 * This function is used to set up the DOM-Tree and to make the important
 * nodes accessible by assigning global variables to them. Furthermore,
 * depending on the used "USE", diferent namespaces are added to the
 * definition element.
 * Important: the nodes are not appended now, because the messages are not
 * created yet. That's why they are appended after the messages are created.
 */
function m4() {

}

function functionWithTypeHint( ReflectionClass $paramWithTypeHintOnly ) {
}

?>
