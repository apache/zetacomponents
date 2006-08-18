<?php
/**
 * File containing the abstract ezcGraph class
 *
 * @package Graph
 * @version //autogentag//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Base options class for all eZ components.
 *
 * @package Graph
 */
class ezcGraph
{
    const NO_SYMBOL = 0;
    const DIAMOND = 1;
    const BULLET = 2;
    const CIRCLE = 3;

    const NO_REPEAT = 0;
    const HORIZONTAL = 1;
    const VERTICAL = 2;

    const TOP = 1;
    const BOTTOM = 2;
    const LEFT = 4;
    const RIGHT = 8;
    const CENTER = 16;
    const MIDDLE = 32;

    const PIE = 1;
    const LINE = 2;
    const BAR = 3;

    // native TTF font
    const TTF_FONT = 1;
    // PostScript Type1 fonts
    const PS_FONT = 2;
    // FreeType 2 fonts
    const FT2_FONT = 3;
    // Native GD bitmap fonts
    const GD_FONT = 4;

}

?>
