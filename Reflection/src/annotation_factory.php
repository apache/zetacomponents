<?php
/**
 * File containing the ezcReflectionAnnotationFactory class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2010 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Creates a ezcReflectionAnnotation object be the given annotation
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 */
class ezcReflectionAnnotationFactory
{

	/**
	 * Don't allow objects, it is just a static factory
	 */
    // @codeCoverageIgnoreStart
    private function __construct() {}
    // @codeCoverageIgnoreEnd

    /**
     * @param string $type
     * @param string[] $line array of words
     * @return ezcReflectionAnnotation
     */
    static public function createAnnotation($type, $line) {
        $annotationClassName = 'ezcReflectionAnnotation' . ucfirst($type);
        $annotation = null;
        if (!empty($type) and class_exists($annotationClassName)) {
            $annotation = new $annotationClassName($line);
        }
        else {
            $annotation = new ezcReflectionAnnotation($line);
        }
        return $annotation;
    }
}
?>
