<?php
/**
 * File containing the ezcReflectionAnnotationParam class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Represents a param annotation in the php source code comment.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotationParam extends ezcReflectionAnnotation {

    /**
    * @param string[] $line Array of words
    */
    public function __construct($line) {
        $this->annotationName = $line[0];

        if (isset($line[1])) {
            $this->params[0] = ezcReflectionTypeMapper::getInstance()->getType($line[1]);
        }
        if (isset($line[2]) and strlen($line[2])>0) {
            if ($line[2]{0} == '$') {
                $line[2] = substr($line[2], 1);
            }
            $this->params[1] = $line[2];
        }
        if (isset($line[3])) {
            $this->desc = $line[3];
        }
    }

    /**
    * @return string
    */
    public function getParamName() {
        if (isset($this->params[1])) {
            return $this->params[1];
        }
        else {
            return null;
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
