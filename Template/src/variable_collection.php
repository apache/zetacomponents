<?php
/**
 * File containing the ezcTemplateVariableCollection class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Encapsulates template variables.
 *
 * The template variables are stored with their definition and the value which
 * can be queried by either template code or PHP code. These variables will be
 * part of a variable stack which is used in the execution of a template.
 *
 * The variables are instances of the ezcTemplateVariable class and can be
 * queried with getVariable() and hasVariable() however they should only be
 * accessed from internal code in the engine. Modification of the objects can be
 * done with setVariable(), removeVariable() and resetVariables().
 *
 * Any client of the engine should be calling the defineInput() or defineOutput()
 * functions which only defines a variable with a value. The client can later
 * query the values of variables with getInputValue() or getOutputValue() and
 * check if they have a value with hasVariableValue().
 *
 * The executed template should be calling the getAllVariables() to get the
 * objects and extract the values from them. In addition it can use the
 * getOutputVariables() to check if values are to passed back to calling template
 * or PHP code.
 *
 * After the template is executed the input  (DIR_IN) variables will be removed
 * from the collection since their use is over, however any output variables
 * (DIR_OUT) will be kept.
 * The collection will be unique to one executed templated, when another
 * subtemplate is executed a new collection is made and input variables are
 * copied from existing variables. After the subtemplate is done it will examine
 * the original collection for output (DIR_OUT) variables and copy the values
 * from the new collection if they exist.
 *
 * For instance calling a template with input is done with:
 * <code>
 * $collection = new ezcTemplateVariableCollection();
 * $collection->defineInput( "character", "Londo Mollari" );
 * $collection->defineInput( "actor", "Peter Jurasik" );
 * $collection->defineInput( "race", "Centauri" );
 *
 * // ...
 *
 * var_export( $collection->getVariableNames() );
 * </code>
 *
 * The executed template will have code which extracts the variables as PHP
 * variables and then reads output variables back in again.
 * <code>
 * foreach ( $collection->getAllVariables() as $var )
 * {
 *    ${"tpl_" . $var->name} = $var->value;
 * }
 *
 * // .. perform template code
 *
 * foreach ( $collection->getOutputVariables() as $var )
 * {
 *    if ( ${"tpl_" . $var->name} !== null )
 *        $var-value = ${"tpl_" . $var->name};
 * }
 * </code>
 *
 * <code>
 * $collection->defineOutput( "time_to_live" );
 *
 * // .. execute template
 *
 * // read out value
 * $collection->getOutputValue( "time_to_live" );
 * </code>
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateVariableCollection
{

    /**
     * The collection where all variables are stored. Each entry is an
     * ezcTemplateVariable object and is looked up with the name of the variable.
     * @var array
     */
    private $variables;

    /**
     * Initialises an empty collection of variables.
     *
     * @note To initialise it with existing variables pass them as the $variables
     * parameter.
     *
     * @param array $variables An array of variables to initialise the collection
     * with. The default is an empty collection.
     */
    public function __construct( $variables = array() )
    {
        $this->variables = $variables;
    }

    /**
     * Checks if the variable named $name exists and returns the result.
     *
     * @param string $name The name of the variable to check for existance.
     * @return bool
     */
    public function hasVariable( $name )
    {
        return isset( $this->variables[$name] );
    }

    /**
     * Returns the variable object which is named $name.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     *
     * @param string $name The name of the variable to return.
     * @return ezcTemplateVariable
     */
    public function getVariable( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        return $this->variables[$name];
    }

    /**
     * Returns all variables as an array, each entry contains a ezcTemplateVariable
     * object.
     *
     * @return array(ezcTemplateVariable)
     */
    public function getAllVariables()
    {
        return $this->variables;
    }

    /**
     * Removes the variable named $name from the collection.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     *
     * @param string $name The name of the variable to remove.
     */
    public function removeVariable( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        unset( $this->variables[$name] );
    }

    /**
     * Registers the variable object $variable using the $variable->name for
     * name. If the variable entry does not exist it is created.
     *
     * @param ezcTemplateVariable $variable The variable object to set.
     */
    public function setVariable( ezcTemplateVariable $variable )
    {
        $this->variables[$variable->name] = $variable;
    }

    /**
     * Removes all variables from the collection making an empty one.
     *
     * @param array $variables The variables to reset the collection with. The
     * default creates an empty collection.
     */
    public function resetVariables( $variables = array() )
    {
        $this->variables = $variables;
    }

    /**
     * Returns the names of all variables as an array.
     *
     * @return array(string)
     */
    public function getVariableNames()
    {
        return array_keys( $this->variables );
    }

    /**
     * Returns all output (DIR_OUT) variables as an array, each entry contains a
     * ezcTemplateVariable object.
     *
     * @return array(ezcTemplateVariable)
     */
    public function getOutputVariables()
    {
        $variables = array();
        foreach ( $this->variables as $variable )
        {
            if ( $variable->direction == ezcTemplateVariable::DIR_OUT )
                $variables[$variable->name] = $variable;
        }
        return $variables;
    }

    /**
     * Returns all input (DIR_IN) variables as an array, each entry contains a
     * ezcTemplateVariable object.
     *
     * @return array(ezcTemplateVariable)
     */
    public function getInputVariables()
    {
        $variables = array();
        foreach ( $this->variables as $variable )
        {
            if ( $variable->direction == ezcTemplateVariable::DIR_IN )
                $variables[$variable->name] = $variable;
        }
        return $variables;
    }

    /**
     * Returns all normal (DIR_NONE) variables as an array, each entry contains a
     * ezcTemplateVariable object.
     *
     * @return array(ezcTemplateVariables)
     */
    public function getVariables()
    {
        $variables = array();
        foreach ( $this->variables as $variable )
        {
            if ( $variable->direction == ezcTemplateVariable::DIR_NONE )
                $variables[$variable->name] = $variable;
        }
        return $variables;
    }

    /**
     * Defines a variable with name $name to be an input variable with value $value.
     * This variable will be passed onto the next executed template.
     *
     * @note If the variable already exists it will be redefined, use hasVariable()
     * to check this before defining.
     *
     * @param string $name The name of the input variable to define.
     * @param mixed $value The value of the defined input variable.
     */
    public function defineInput( $name, $value )
    {
        $this->variables[$name] = new ezcTemplateVariable( $name, $value,
                                                           null, ezcTemplateVariable::DIR_IN );
    }

    /**
     * Defines a variable with name $name to be an output variable. This variable
     * will be copied from any executed templates. The value of the variable will be
     * null.
     *
     * @note If the variable already exists it will be redefined, use hasVariable()
     * to check this before defining.
     *
     * @param string $name The name of the output variable to define.
     */
    public function defineOutput( $name )
    {
        $this->variables[$name] = new ezcTemplateVariable( $name, null,
                                                           null, ezcTemplateVariable::DIR_OUT );
    }

    /**
     * Defines a variable with name $name to be an normal variable. This variable can
     * be accessed and modified by the current execution but will not be passed onto
     * the next or previous execution.
     *
     * @note If the variable already exists it will be redefined, use hasVariable()
     * to check this before defining.
     *
     * @param string $name The name of the variable to define.
     * @param mixed $value The value of of the defined variable.
     */
    public function defineVariable( $name, $value )
    {
        $this->variables[$name] = new ezcTemplateVariable( $name, $value,
                                                           null, ezcTemplateVariable::DIR_NONE );
    }

    /**
     * Returns the value of the input variable named $name.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     * @throw ezcTemplateVariableWrongDirectionException if it is not an input variable.
     *
     * @return mixed
     */
    public function getInputValue( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        $variable = $this->variables[$name];
        if ( $variable->direction != ezcTemplateVariable::DIR_IN )
            throw new ezcTemplateVariableWrongDirectionException( $name, ezcTemplateVariable::DIR_IN, $variable->direction );
        return $variable->value;
    }

    /**
     * Returns the value of the output variable named $name.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     * @throw ezcTemplateVariableWrongDirectionException if it is not an output variable.
     *
     * @return mixed
     */
    public function getOutputValue( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        $variable = $this->variables[$name];
        if ( $variable->direction != ezcTemplateVariable::DIR_OUT )
            throw new ezcTemplateVariableWrongDirectionException( $name, ezcTemplateVariable::DIR_OUT, $variable->direction );
        return $variable->value;
    }

    /**
     * Returns the value of the normal variable named $name.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     * @throw ezcTemplateVariableWrongDirectionException if it is not an normal variable.
     *
     * @return mixed
     */
    public function getVariableValue( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        $variable = $this->variables[$name];
        if ( $variable->direction != ezcTemplateVariable::DIR_NONE )
            throw new ezcTemplateVariableWrongDirectionException( $name, ezcTemplateVariable::DIR_NONE, $variable->direction );
        return $variable->value;
    }

    /**
     * Checks if the variable named $name has a value. Any non null value will return
     * true.
     *
     * @throw ezcTemplateVariableUndefinedException if the variable does not exist.
     *
     * @param string $name The name of the variable to check.
     * @return bool
     */
    public function hasVariableValue( $name )
    {
        if ( !isset( $this->variables[$name] ) )
            throw new ezcTemplateVariableUndefinedException( $name );
        return $this->variables[$name]->value !== null;
    }

}
?>
