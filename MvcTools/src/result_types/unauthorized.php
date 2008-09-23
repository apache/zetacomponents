<?php
class ezcMvcResultUnauthorized extends ezcMvcResult
{
    public $realm;

    public function __construct( $realm )
    {
        $this->realm = $realm;
    }
}
?>
