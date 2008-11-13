<?php

require_once 'custom_auth.php';

class myCustomLockAuth extends myCustomAuth
                   implements ezcWebdavLockAuthorizer
{
    protected $tokens;

    protected $storageFile;

    public function __construct( $storageFile )
    {
        $this->storageFile = $storageFile;
        $this->tokens      = array();
        if ( file_exists( $storageFile ) )
        {
            $this->tokens = include $storageFile;
        }
    }

    public function __destruct()
    {
        if ( $this->tokens !== array() )
        {
            file_put_contents(
                $this->storageFile,
                "<?php\n\nreturn " . var_export( $this->tokens, true ) . ";\n\n?>"
            );
        }
    }

    public function assignLock( $user, $lockToken )
    {
        if ( !isset( $this->tokens[$user] ) )
        {
            $this->tokens[$user] = array();
        }
        $this->tokens[$user][$lockToken] = true;
    }

    public function ownsLock( $user, $lockToken )
    {
        return ( isset( $this->tokens[$user][$lockToken] ) );
    }

    public function releaseLock( $user, $lockToken )
    {
        unset( $this->tokens[$user][$lockToken] );
    }

}

?>
