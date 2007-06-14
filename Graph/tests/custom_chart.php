<?php

class ezcCustomTestChart extends ezcGraphPieChart
{
    public function __construct( array $options = array() )
    {
        parent::__construct( $options );

        $this->driver = new ezcGraphSvgDriver();
        $this->renderer = new ezcGraphRenderer3d();

        $this->palette = new ezcGraphPaletteEzBlue();

        $this->title = 'Test chart';

        $this->data['testdata'] = new ezcGraphArrayDataSet( array(
            'foo' => 123,
            'bar' => 43,
            'blubb' => 453,
        ) );
    }
}

?>
