<?php
/**
 * File containing the ezcTemplateGrammarDescription class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Encapsulates EBNF grammar rules and provides means to display them.
 *
 * The grammar rules are passed to the constructor.
 * If the grammar rules references external rules it can be added as the second
 * parameter to the constructor, when this is supplied the generateString()
 * method will include all the referenced rules in the final result.
 *
 * @see $grammarList for the grammar format and $referenceList for the reference format.
 *
 * Example of creating grammars and displaying them:
 * <code>
 * $rules = array( "Letter"     => "'a' - 'z'",
 *                 "Digit"      => "'0' - '9'",
 *                 "Identifier" => "Letter ( Letter | Digit )*" );
 * $ebnf = new ezcTemplateGrammarDescription( $rules );
 * echo $ebnf->generateString(), "\n";
 * </code>
 *
 * @note The grammar rules are a minor extension of EBNF in that you can
 *       specify ranges for characters with a dash (-). .e.g <i>'a' - 'z'</i>.
 * @link http://en.wikipedia.org/wiki/Extended_Backus-Naur_form
 *
 * @package Template
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogen//
 */
class ezcTemplateGrammarDescription
{
    /**
     * The associative array of grammar rules.
     *
     * The array keys are used as the grammar rule-name and the value as
     * the grammar description as a string.
     * e.g.
     * <code>
     * array(
     *   "Letter" => "'a' - 'z'",
     *   "Digit"  => "'0' - '9'" );
     * </code>
     * @var array
     */
    public $grammarList;

    /**
     * Array of rule-names the grammars refer to.
     * This can be used to generated a complete grammar list by including
     * those external references in the total list.
     *
     * The format of the array is:
     * - class - The name of the class which has the referenced rules, this
     *           class must have a method named getGrammarDescription().
     * - rules - An array of rules which are used from the referenced grammar,
     *           this avoids having to include rules which are not in use.
     * e.g.
     * <code>
     * array(
     *   'class' => 'ezcTemplateSourceToTstParser',
     *   'rules' => array( 'Letter', 'Digit' );
     * </code>
     * @var array
     */
    public $referenceList;

    /**
     * Initialize the grammar description with the grammars and references.
     *
     * @param array $grammarList The grammar rules.
     * @param array $referenceList List of references to other grammars.
     */
    public function __construct( $grammarList, $referenceList = array() )
    {
        $this->grammarList = $grammarList;
        $this->referenceList = $referenceList;
    }

    /**
     * Generates a displayable string of the grammars.
     *
     * It will also include all externally referenced grammar rules.
     *
     * @note The returned string will not have an ending newline at the last rule.
     * @return string
     */
    public function generateString()
    {
        $text = '';
        $grammarList = $this->grammarList;
        $referenceList = $this->referenceList;
        $referencedClassList = array();
        while ( count( $referenceList ) > 0 )
        {
            $reference = array_pop( $referenceList );
            $referenceClass = $reference['class'];
            if ( !in_array( $referenceClass, $referencedClassList ) )
            {
                $ebnf = call_user_func( array( $referenceClass, 'getGrammarDescription' ) );
                if ( !$ebnf instanceof ezcTemplateGrammarDescription )
                    throw Exception( "{$referenceClass}::getGrammarDescription() did not return an object of class ezcTemplateGrammarDescription" );

                // Extract the grammars which are referenced
                $referenceGrammarList = $ebnf->grammarList;
                foreach ( $reference['rules'] as $ruleName )
                {
                    if ( !isset( $referenceGrammarList[$ruleName] ) )
                        throw new Exception( "Grammar from {$referenceClass}::getGrammarDescription() does not have the rule <{$ruleName}>" );
                    $grammarList[$ruleName] = $referenceGrammarList[$ruleName];
                }

                // Add grammar reference list to current list
                $referenceList += $ebnf->referenceList;

                // Add class to already referenced classes
                $referencedClassList[] = $referenceClass;
            }
        }

        // Find the largest rule-name, need for nice formatting
        $maxRuleLength = 0;
        foreach ( $grammarList as $ruleName => $expression )
        {
            $maxRuleLength = max( strlen( $ruleName ), $maxRuleLength );
        }

        $i = 0;
        foreach ( $grammarList as $ruleName => $expression )
        {
            if ( $i > 0 )
                $text .= "\n";
            ++$i;
            $text .= $ruleName;

            // str_repeat cannot take 0 as argument so we need to check for it
            if ( strlen( $ruleName ) < $maxRuleLength )
                $text .= str_repeat( ' ', $maxRuleLength - strlen( $ruleName ) );
            $text .= '  ::=  ' . $expression;
        }

        return $text;
    }
}

?>
