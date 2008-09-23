<?php
abstract class ezcMvcView
{
    protected $request;
    protected $result;

    public function __construct( $request, $result )
    {
        $this->request = $request;
        $this->result  = $result;
    }

    protected function createResponseBody()
    {
        $zones = $this->createZones( true );
        $processed = array();

        foreach( $zones as $zone )
        {
            // Get the variables returned by the controller for the view
            foreach( $this->result->getResultVariables() as $propertyName => $propertyValue )
            {
                // Send it verbatim to the template processor
                $zone->send( $propertyName, $propertyValue );
            }

            // Zones are additional templates that the final view should be built
            // with. The main page layout is the last zone returned from
            // createZones() method.
            foreach( $processed as $processedZone )
            {
                $zone->send( $processedZone->name, $processedZone->result );
            }

            $zone->process();

            $processed[] = $zone;
        }
        return $zone->result;
    }

    public function createResponse()
    {
        try
        {
            $resultBody = $this->createResponseBody();
        }
        catch ( Exception $e )
        {
            return $e;
        }
        return new ezcMvcResponse( $this->result->getResultHeaders(), $zone->result );
    }

    abstract public function createZones( $layout );
}

// User implementation
class yourBlogApplicationHtmlViewHandlerUsingPhp extends ezcMvcView
{
    // Configure the view handler
    public function createZones( $layout = true )
    {
        // Add a zone this way
        $zones[] = new ezcMvcPhpViewHandler( 'yourLastBlogTickets', 'last_blog_tickets.php' );

        if ( $layout )
        {
            // The last template is the layout template
            $zones[] = new ezcMvcPhpViewHandler( null, 'layout.php' );
        }

        return $zones;
    }
}

class yourWebshopApplicationHtmlViewHandlerUsingTemplate extends ezcMvcView
{
    // Configure the view handler
    public function createZones( $layout )
    {
        $zones = array();
        // Add a zone this way
        $zones[] = new ezcMvcTemplateViewHandler( 'yourShoppingCart', 'shopping_cart.ezt' );

        if ( $layout )
        {
            $zones[] = new ezcMvcTemplateViewHandler( null, 'layout.ezt' );
        }

        return $zones;
    }
}

class yourNewWebsiteUsingWebshopAndBlog extends ezcMvcView
{
    public function createZones( $layout )
    {
        $zones = array();
        // Include zones from another application (that is decoupled, and
        // ignore the page layout)
        $viewHandlerInstance = new yourWebshopApplicationHtmlViewHandlerUsingTemplate();
        $zones += $viewHandlerInstance->createZones( false );

        $viewHandlerInstance = new yourBlogApplicationHtmlViewHandlerUsingPhp();
        $zones += $viewHandlerInstance->createZones( false );

        return $zones;
    }
}

interface ezcMvcViewHandler
{
    public function __construct( $name, $templateLocation );
    public function send( $name, $value );
    public function process();
    public function getName();
    public function getResult();
}

class ezcMvcTemplateViewHandler implements ezcMvcViewHandler
{
    public function __construct( $name, $templateLocation )
    {
        $this->name = $name;
        $this->templateLocation = $templateLocation;
        $this->template = new ezcTemplate;
    }

    public function send( $name, $value )
    {
        $this->template->send->$name = $value;
    }

    public function process()
    {
        $this->result = $this->template->process( $this->templateLocation );
    }
}

class ezcMvcPhpViewHandler implements ezcMvcViewHandler
{
    protected $publicVariables = array();

    public function __construct( $name, $templateLocation )
    {
        $this->name = $name;
        $this->templateLocation = $templateLocation;
    }

    public function send( $name, $value )
    {
        // add it to $publicVariables
        $this->$name = $value;
    }

    public function process()
    {
        // maybe it is possible to use the template locator here as well
        $this->result = include $this->templateLocation;
    }

    // implement __get(), __set(), __isset() for $publicVariables
    // and use $this in the PHP template
}
?>
