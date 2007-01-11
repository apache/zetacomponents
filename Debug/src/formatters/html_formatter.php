<?php
/**
 * File containing the ezcDebugHtmlFormatter class.
 *
 * @package Debug
 * @version //autogentag//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * ezcDebugHtmlFormatter class implements a HTML debug formatter that outputs
 * debug information nicely formated for inclusion on your web page.
 *
 * @package Debug
 * @version //autogentag//
 */
class ezcDebugHtmlFormatter implements ezcDebugOutputFormatter
{
    /**
     * Stores a mapping between the a verbosity level and the color to print it with.
     *
     * Format array(verbosity_level=>'color_name_using_css_names')
     *
     * @var array(int=>string)
     */
    private $verbosityColors = array();

    /**
     * Constructs a new HTML reporter.
     */
    public function __construct()
    {
    }

    /**
     * Sets the output $color of debug messages of the verbosity $verbosity.
     *
     * $color must be specified in a CSS color value.
     *
     * @param int $verbosity
     * @param string $color
     * @return void
     */
    public function setVerbosityColor( $verbosity, $color )
    {
        $this->verbosityColors[$verbosity] = $color;
    }

    /**
     * Returns a string containing the HTML formatted output based on $timerData and $writerData.
     *
     * @param array(ezcDebugStructure) $timerData
     * @param array $writerData
     * @return string
     */
    public function generateOutput( array $writerData, array $timerData )
    {
        $str = '';
        $str .= "<style type=\"text/css\">\n@import url(\"debug.css\");\n</style>\n\n";
        $str .=  "<table cellspacing='0'>\n";

        $str .= $this->getLog( $writerData );
        $str .= $this->getTimingsAccumulator( $timerData );
        return $str;
    }

    /**
     * Returns a string containing the HTML formatted output based on $writerData.
     *
     * @param array $writerData
     * @return string
     */
    public function getLog( array $writerData )
    {
        $str = '';
        foreach ( $writerData as $w )
        {
            $str .= "<tr>\n";
            $str .= "\t<td class='debugheader' valign='top'>";
            $str .= "<b><font color=\"". ( isset( $this->verbosityColors[$w->verbosity]) ? $this->verbosityColors[$w->verbosity] : "" )."\">";
            $str .= $w->verbosity;
            $str .= ":</font>{$w->source}::{$w->category}</b></td>\n";
            $str .= "\t<td class='debugheader' valign='top'>{$w->datetime}</td>\n";
            $str .= "</tr>\n";
            $str .= "<tr>\n";
            $str .= "\t<td class='debugbody' colspan='2'><pre>\n{$w->message}\n\t</pre></td>\n";
            $str .= "</tr>\n";
        }
        $str .= "</table>\n";

        return $str;
    }

    /**
     * Returns a string containing the HTML formatted output based on $timerData.
     *
     * @param array(ezcDebugStructure) $timerData
     * @return string
     */
    public function getTimingsAccumulator( array $timerData )
    {
        $groups = $this->getGroups( $timerData );

        if ( sizeof( $groups ) > 0 )
        {
            $str = "<table style='border: 1px dashed black;' cellspacing='0'>\n<tr><th>&nbsp;Timings</th><th>&nbsp;Elapsed</th>".
                   "<th>&nbsp;Percent</th><th>&nbsp;Count</th><th>&nbsp;Average</th></tr>\n";

            $isFirst = true;
            foreach ( $groups as $groupName => $group )
            {
                if ( !$isFirst )
                {
                    $str .= "<tr><td>&nbsp;</td></tr>";
                    $str .= "\n";
                }
                else
                {
                    $isFirst = false;
                }
     
                $str .= "<tr><td class='timingpoint1'><b>$groupName</b></td><td class='timingpoint1'>&nbsp;</td><td class='timingpoint1'>&nbsp;</td>".
                        "<td class='timingpoint1'>&nbsp;</td><td class='timingpoint1'>&nbsp;</td></tr>\n";

                // Calculate the total time.
                foreach ( $group->elements as $name => $element )
                {
                    $str .= "<tr><td class='timingpoint1'>$name</td>" .
                        "<td class='timingpoint1'>" . sprintf( '%.5f', $element->elapsedTime ) . "</td>" .
                        "<td class='timingpoint1' align='right'>". sprintf( '%.2f', (100 * ($element->elapsedTime / $group->elapsedTime ) ) ) ."</td>" .
                        "<td class='timingpoint1' align='right'>{$element->count}</td>" .
                        "<td class='timingpoint1' align='right'>" . sprintf( '%.5f', ( $element->elapsedTime / $element->count ) ) .
                        "</td></tr>\n";

                   foreach ( $element->switchTime as $switch )
                   {
                       $elapsedTime = $switch->time - $element->startTime;

                       $str .= "<tr><td class='timingpoint1'>&nbsp;&nbsp;&nbsp;&nbsp;{$switch->name}</td>" .
                       "<td class='timingpoint1'>" . sprintf( '%.5f', $elapsedTime ) . "</td>" .
                            "<td class='timingpoint1' align='right'>". sprintf( '%.2f', (100 * ($elapsedTime / $group->elapsedTime ) ) ) ."</td>" .
                            "<td class='timingpoint1' align='right'>-</td>" .
                            "<td class='timingpoint1' align='right'>-</td></tr>\n";
                   }
                }
                $str .= "\n";

                if ( $group->count > 1 )
                {
                    $str .= "<tr><td class='timingpoint1'><b>Total:</b></td>" .
                        "<td class='timingpoint1'>" . sprintf( '%.5f', $group->elapsedTime ) . "</td>" .
                        "<td class='timingpoint1' align='right'>100.00</td>" .
                        "<td class='timingpoint1' align='right'>{$group->count}</td>" .
                        "<td class='timingpoint1' align='right'>" . sprintf( '%.5f', ( $group->elapsedTime / $group->count ) ) .
                        "</td></tr>\n";
                }
           }

            $str .= "</table>";
            return $str;
       }

       return "";
    }

    /**
     *
     *
     * @param array(ezcDebugStructure)
     * @return array(string)
     */
    private function getGroups( array $timers )
    {
        $groups = array();
        foreach ( $timers as $time )
        {
            if ( !isset( $groups[$time->group] ) )
            {
                $groups[$time->group] = new ezcDebugStructure();
                $groups[$time->group]->elements = array();
                $groups[$time->group]->count = 0;
                $groups[$time->group]->elapsedTime = 0;
                $groups[$time->group]->startTime = INF;  // Infinite high number.
                $groups[$time->group]->stopTime = 0;
            }

            // $groups[$time->group]->elements[] = $time;
            $this->addElement( $groups[$time->group]->elements, $time );

            $groups[$time->group]->count++;
            $groups[$time->group]->elapsedTime += $time->elapsedTime;
            $groups[$time->group]->startTime = min( $groups[$time->group]->startTime, $time->startTime );
            $groups[$time->group]->stopTime = max( $groups[$time->group]->stopTime, $time->stopTime );
        }

        return $groups;
    }

    /**
     * @return void
     */
    private function addElement( &$element, $timeStruct )
    {
        if ( !isset( $element[$timeStruct->name] ) )
        {
            $element[$timeStruct->name] = new ezcDebugStructure();

            $element[$timeStruct->name]->count = 0;
            $element[$timeStruct->name]->elapsedTime = 0;
            $element[$timeStruct->name]->startTime = INF;
            $element[$timeStruct->name]->stopTime = 0;
        }

        $element[$timeStruct->name]->count++;
        $element[$timeStruct->name]->elapsedTime += $timeStruct->elapsedTime;
        $element[$timeStruct->name]->startTime = min( $element[$timeStruct->name]->startTime, $timeStruct->startTime );
        $element[$timeStruct->name]->stopTime = max( $element[$timeStruct->name]->stopTime, $timeStruct->stopTime );


        $element[$timeStruct->name]->switchTime = $timeStruct->switchTime;
    }
}
?>
