<?php
/**
 * File containing the ezcSearchQueryBuilder class.
 *
 * @package Search
 * @version //autogen//
 * @copyright Copyright (C) 2005-2008 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcSearchQueryBuilder provides a method to add a natural language search
 * query to an exisiting query object.
 *
 * @package Search
 * @version //autogen//
 * @mainclass
 */
class ezcSearchQueryBuilder
{
	/**
	 * Parses the $searchQuery and adds the selection clauses to the $query object
	 *
	 * @param ezcSearchQuery $query
	 * @param string $searchQuery
	 */
	static public function buildSearchQuery( ezcSearchQuery $query, $searchQuery, $searchFields )
	{
		$tokens = self::tokenize( $searchQuery );
		self::buildQuery( $query, $tokens, $searchFields );
	}

	/**
	 * Tokenizes the search query into tokens
	 *
	 * @param string $searchQuery
	 * @return array(ezcSearchQueryToken)
	 */
	static protected function tokenize( $searchQuery )
	{
		$map = array(
			' '  => ezcSearchQueryToken::SPACE,
			'\t' => ezcSearchQueryToken::SPACE,
			'"'  => ezcSearchQueryToken::QUOTE,
			'+'  => ezcSearchQueryToken::PLUS,
			'-'  => ezcSearchQueryToken::MINUS,
			'('  => ezcSearchQueryToken::BRACE_OPEN,
			')'  => ezcSearchQueryToken::BRACE_CLOSE,
			'and' => ezcSearchQueryToken::LOGICAL_AND,
			'or'  => ezcSearchQueryToken::LOGICAL_OR,
			':'   => ezcSearchQueryToken::COLON,
		);
		$tokens = array();
		$tokenArray = preg_split( '@(\s)|(["+():-])|(AND)|(OR)@', $searchQuery, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
		foreach ( $tokenArray as $token )
		{
			if ( isset( $map[strtolower($token)] ) )
			{
				$tokens[] = new ezcSearchQueryToken( $map[strtolower($token)], $token );
			}
			else
			{
				$tokens[] = new ezcSearchQueryToken( ezcSearchQueryToken::STRING, $token );
			}
		}
		return $tokens;
	}

	static protected function buildQuery( ezcSearchQuery $q, $tokens, $searchFields )
	{
		$state = 'normal';
		foreach ( $tokens as $token )
		{
			switch ( $state )
			{
				case 'normal':
					if ( $token->type == ezcSearchQueryToken::STRING )
					{
						$q->where( $q->eq( $searchFields[0], $token->token ) );
					}
			}
		}
	}
}
?>
