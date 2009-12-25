<?php
/**
 * File containing the ezcReflectionDocCommentParserImpl class.
 *
 * @package Reflection
 * @version //autogen//
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Provides structured data from PHP Documentor comments
 *
 * Parser is implemented as state based parser using a state transisiton
 * table consisting of transition rules for empty and non-empty lines.
 *
 * @package Reflection
 * @version //autogen//
 * @author Stefan Marr <mail@stefan-marr.de>
 * @author Falko Menge <mail@falko-menge.de>
 */
class ezcReflectionDocCommentParserImpl implements ezcReflectionDocCommentParser {

    const BEGINNING   = 10;
    const SHORT_DESC  = 0;
    const LONG_DESC   = 1;
    const ANNOTATIONS = 2;

    /**
     * @var string
     */
    protected $docComment;

    /**
     * @var int STATE
     */
    protected $state = self::BEGINNING;

    /**
     * @var array(int=>int)
     */
    protected $stateTable = array(
        true => array ( // empty lines
            self::BEGINNING   => self::BEGINNING,
            self::SHORT_DESC  => self::LONG_DESC,
            self::LONG_DESC   => self::LONG_DESC,
            self::ANNOTATIONS => self::ANNOTATIONS
        ),
        false => array ( // non empty lines
            self::BEGINNING   => self::SHORT_DESC,
            self::SHORT_DESC  => self::SHORT_DESC,
            self::LONG_DESC   => self::LONG_DESC,
            self::ANNOTATIONS => self::ANNOTATIONS
        )
    );

    /**
     * @var ezcReflectionAnnotation
     */
    protected $lastAnnotation = null;

    /**
     * @var string
     */
    protected $shortDesc;

    /**
     * @var string
     */
    protected $longDesc;

    /**
     * @var ezcReflectionAnnotation[]
     */
    protected $annotations;

    /**
     * Constructs an instance of ezcReflectionDocCommentParserImpl
     * 
     * @return ezcReflectionDocCommentParserImpl
     */
    public function __construct() {
        $this->annotations = array();
    }

    /**
     * Initialize parsing of the given documentation fragment.
     * Results can be retrieved after completion by the getters provided.
     *
     * @param string $docComment
     * @return void
     * @see interfaces/ezcReflectionDocCommentParser#parse($docComment)
     */
    public function parse($docComment) {
    	$this->docComment = $docComment;

        $lines = explode("\n", $this->docComment);

        foreach ($lines as $line) {
            $line = $this->extractContentFromDocCommentLine($line);

            // in some states we need to do something
            if (!empty($line)) {
                if ($line[0] == '@') {
                    $this->state = self::ANNOTATIONS;
                    $this->parseAnnotation($line);
                }
                elseif ($this->state == self::ANNOTATIONS) {
                    $this->parseAnnotation($line);
                }
                else {
                    if ($this->state == self::SHORT_DESC
                        	or $this->state == self::BEGINNING) {
                        $this->shortDesc .= $line . "\n";
                    }
                    elseif ($this->state == self::LONG_DESC) {
                        $this->longDesc .= $line . "\n";
                    }
                }
            }
            else if ($this->state == self::LONG_DESC) {
                $this->longDesc .= "\n";
            }

            //next state
            $this->state = $this->stateTable[empty($line)][$this->state];
        }
        $this->shortDesc = trim($this->shortDesc);
        $this->longDesc = trim($this->longDesc);
    }

    /**
     * @param string $line
     * @return string
     */
    protected function extractContentFromDocCommentLine($line) {
        $line = trim($line);
        if (substr($line, -2) == '*/') {
            $line = substr($line, 0, -2);
        }
        while (strlen($line) > 0 and ($line[0] == '/' or $line[0] == '*')) {
            $line = substr($line, 1);
        }

        return trim($line);
    }

    /**
     * @param string $line
     * @return void
     */
    protected function parseAnnotation($line) {
        if (strlen($line) > 0) {
            if ($line[0] == '@') {
                $line = substr($line, 1);
                $words = preg_split('/\s+/', $line, 4); // split the line by whitespace into up to 4 parts
                $annotation = ezcReflectionAnnotationFactory::createAnnotation($words[0], $words);
                $this->annotations[$annotation->getName()][] = $annotation;
                $this->lastAnnotation = $annotation;
            }
            else {
                //no leading @, it is assumed a description is multiline
                if ($this->lastAnnotation != null) {
                    $this->lastAnnotation->addDescriptionLine($line);
                }
            }
        }
    }

    /**
     * Returns an array of annotations with a given name
     *
     * @param string $name
     * @return ezcReflectionAnnotation[]
     */
    public function getAnnotationsByName($name) {
        if (isset($this->annotations[$name])) {
            return $this->annotations[$name];
        }
        else {
            return array();
        }
    }

    /**
     * @return ezcReflectionAnnotation[]
     */
    public function getAnnotations() {
        $result = array();
        foreach ($this->annotations as $annotations) {
            foreach ($annotations as $annotation) {
                $result[] = $annotation;
            }
        }
        return $result;
    }

    /**
     * @return ezcReflectionAnnotationParam[]
     */
    public function getParamAnnotations() {
        return $this->getAnnotationsByName('param');
    }

    /**
     * @return ezcReflectionAnnotationVar[]
     */
    public function getVarAnnotations() {
        return $this->getAnnotationsByName('var');
    }

    /**
     * Return an array of return annotations
     *
     * @return ezcReflectionAnnotationReturn[]
     */
    public function getReturnAnnotations() {
        return $this->getAnnotationsByName('return');
    }

    /**
     * Checks whether a annotation is used
     *
     * @param string $with name of used annotation
     * @return boolean
     */
    public function hasAnnotation($with) {
        return isset($this->annotations[$with]);
    }

    /**
     * Returns the short description from the source code documentation
     *
     * @return string Short description
     */
    public function getShortDescription() {
        return $this->shortDesc;
    }

    /**
     * Returns the long description from the source code documentation
     *
     * @return string Long description
     */
    public function getLongDescription() {
        return $this->longDesc;
    }
}
?>
