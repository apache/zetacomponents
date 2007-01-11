<?php
/**
 * File containing the ezcInputFormDefinitionElement struct
 *
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * This struct records information about Input Form definition elements.
 *
 * @package UserInput
 * @version //autogentag//
 * @mainclass
 */
class ezcInputFormDefinitionElement extends ezcBaseStruct
{
    /**
     * @var OPTIONAL marks an input field as "optional". Optional input fields
     *               do not throw errors if they are not available while
     *               parsing input variables.
     */
    const OPTIONAL = 0;

    /**
     * @var REQUIRED marks an input field as "required". When a required input
     *               variable is not available while parsing input variables,
     *               the __construct will throw the UserInputMissingData
     *               exception.
     */
    const REQUIRED = 1;

    /**
     * Whether the field is optional or required. One of the self::OPTIONAL or
     * self::REQUIRED constants.
     *
     * @var int
     */
    public $type = self::OPTIONAL;

    /**
     * The name of the filter to use for this definition element.
     *
     * @var string
     */
    public $filterName = 'string';

    /**
     * The extra options to this filter.
     *
     * @var mixed
     */
    public $options = false;

    /**
     * The extra flags to this filter.
     *
     * @var mixed
     */
    public $flags = false;

    /**
     * Constructs a definition item.
     *
     * Constructs the definition item with all its options and flags.
     *
     * @param int $type
     * @param string $filterName
     * @param mixed $options
     * @param int $flags
     */
    public function __construct( $type = ezcInputFormDefinitionElement::OPTIONAL, $filterName = 'string', $options = null, $flags = null )
    {
        $this->type = $type;
        $this->filterName = $filterName;
        $this->options = $options;
        $this->flags = $flags;
    }

    public static function __set_state( array $array )
    {
        return new ezcInputFormDefinitionElement( $array['type'], $array['filterName'], $array['options'], $array['flags'] );
    }
}
?>
