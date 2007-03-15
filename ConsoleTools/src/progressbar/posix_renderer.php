<?php

class ezcConsoleProgressbarPosixRenderer extends ezcConsoleProgressbarRenderer
{

    /**
     * Start the progress bar
     * Starts the progress bar and sticks it to the current line.
     * No output will be done yet. Call {@link ezcConsoleProgressbar::output()}
     * to print the bar.
     * 
     * @return void
     */
    public function start() 
    {
        $this->calculateMeasures();
        $this->output->storePos();
        $this->started = true;
    }

    /**
     * Draw the progress bar.
     * Prints the progress-bar to the screen. If start() has not been called 
     * yet, the current line is used for {@link ezcConsolProgressbar::start()}.
     *
     * @return void
     */
    public function output()
    {
        if ( $this->started === false )
        {
            $this->start();
        }
        $this->output->restorePos();
        $this->generateValues();
        echo $this->insertValues();
    }

    /**
     * Finish the progress bar.
     * Finishes the bar (jump to 100% if not happened yet,...) and jumps
     * to the next line to allow new output. Also resets the values of the
     * output handler used, if changed.
     *
     * @return void
     */
    public function finish()
    {
        $this->currentStep = $this->numSteps;
        $this->output();
    }
}

?>
