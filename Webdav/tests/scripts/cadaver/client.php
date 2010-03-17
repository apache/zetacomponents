<?php

class ezcWebdavTestCadaverClient
{
    protected $proc;

    protected $pipes;

    public function __construct( $url, $cwd )
    {
        $this->initProc( $url, $cwd );
    }

    public function send( $string )
    {
        fwrite( $this->pipes[0], $string );
    }

    public function receive( $wait = 500000 )
    {
        usleep( $wait );
        return stream_get_contents( $this->pipes[1] );
    }

    public function receiveErrors()
    {
        return fread( $this->pipes[2], 1024 );
    }

    protected function initProc( $url, $cwd )
    {
        $this->proc = proc_open(
            'cadaver ' . escapeshellarg( $url ),
            array(
                array( 'pipe', 'r' ),
                array( 'pipe', 'w' ),
                array( 'pipe', 'w' ),
            ),
            $this->pipes,
            $cwd
        );

        stream_set_blocking( $this->pipes[1], 0 );
        stream_set_blocking( $this->pipes[2], 0 );

        if ( !is_resource( $this->proc ) )
        {
            throw new RuntimeException( 'Could not open cadaver.' );
        }
    }
}

?>
