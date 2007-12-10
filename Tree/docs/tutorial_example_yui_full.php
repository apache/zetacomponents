<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.3.1/build/menu/assets/skins/sam/menu.css"/>

    <script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/container/container_core-min.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.3.1/build/menu/menu-min.js"></script>
    <script type="text/javascript">
    YAHOO.util.Event.onContentReady('menu', function () {
        var oMenu = new YAHOO.widget.MenuBar("menu", { autosubmenudisplay: true, showdelay: 200 });

        oMenu.render();
    });
    </script>
</head>
<body  class="yui-skin-sam">
<?php
require_once 'tutorial_autoload.php';

$store = new ezcTreeXmlInternalDataStore();
$tree = new ezcTreeXml( 'files/example1.xml', $store );

$visitor = new ezcTreeVisitorYUI( 'menu' );
$tree->accept( $visitor );
echo (string) $visitor;
?>
</body>
</html>
