<?php

class tutorialCustomPalette extends ezcGraphPalette
{
    protected $axisColor = '#000000';

    protected $majorGridColor = '#000000BB';

    protected $dataSetColor = array(
        '#4E9A0688',
        '#3465A4',
        '#F57900'
    );

    protected $dataSetSymbol = array(
        ezcGraph::BULLET,
    );

    protected $fontName = 'sans-serif';

    protected $fontColor = '#555753';
}

?>
