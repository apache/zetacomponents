<?php
class myController extends ezcMvcController
{
    public function doaction()
    {
    }
}

class mytweeController extends ezcMvcController
{
    static public function createActionMethodName( $action )
    {
        return "foo{$action}bar";
    }

    public function fooactionbar()
    {
    }
}

class myCatchAllRoute extends ezcMvcCatchAllRoute
{
    public function createParamName( $index )
    {
        $map = array( 1 => 'wibble', 'wobble' );
        return $map[$index];
    }
}

class myCatchAllRouteForFullUri extends ezcMvcCatchAllRoute
{
    protected function getUriString( ezcMvcRequest $request )
    {
        return $request->requestId;
    }
}
?>
