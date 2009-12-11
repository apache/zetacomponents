<?php
/**
 * File containing the ezcReflectionAnnotationVar class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Represents a var annotation in the php source code comment.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotationVar extends ezcReflectionAnnotation {

    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->annotationName = $line[0];

        if (isset($line[1])) {
            $this->params[0] = ezcReflectionTypeMapper::getInstance()->getType($line[1]);
        }
        if (isset($line[2])) {
            $this->desc = $line[2];
        }
        if (isset($line[3])) {
            $this->desc .= ' '.$line[3];
        }
    }

    /**
    * @return string
    */
    public function getType() {
        return $this->params[0];
    }
}
?>
