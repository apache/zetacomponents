<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package File
 */
/**
 * Provides a selection of static independent methods to provide functionality
 * for file and file system handling.
 *
 * @package File
 */
class ezcFile
{
	static public function findRecursive( $sourceDir, $filters )
	{
		$elements = array();
		$dir = glob( "$sourceDir/*" );
		foreach ( $dir as $entry )
		{
			if ( is_dir( $entry ) )
			{
				$subList = self::findRecursive( $entry, $filters );
				$elements = array_merge( $elements, $subList );
			}
			else
			{
				$ok = true;
				foreach( $filters as $filter )
				{
					if ( !preg_match( $filter, $entry ) )
					{
						$ok = false;
						break;
					}
				}
				if ( $ok )
				{
					$elements[] = $entry;
				}
			}
		}
		return $elements;
	}
}
?>
