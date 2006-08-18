<?php
/**
 * File containing the ezcInputFormDefinitionElement struct
 *
 * @package UserInput
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
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
     * The extra parameters to this filter.
     *
     * @var mixed
     */
    public $parameters = false;

    /**
     * Constructs a definition item.
     *
     * Constructs the definition item with all it's parameters.
     *
     * @param int $type
     * @param string $filterName
     * @param mixed $parameters
     */
    public function __construct( $type = ezcInputFormDefinitionElement::OPTIONAL, $filterName = 'string', $parameters = null )
    {
        $this->type = $type;
        $this->filterName = $filterName;
        $this->parameters = $parameters;
    }

    public static function __set_state( array $array )
    {
        return new ezcInputFormDefinitionElement( $array['type'], $array['filterName'], $array['parameters'] );
    }
}
?>
