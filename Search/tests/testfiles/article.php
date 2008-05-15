<?php
class Article
{
    public  $id;
    public  $title;
    private $summary;
    private $body;
    private $published;
    private $author;

    private $omitElement;

    function omitStateElement( $name )
    {
        $this->omitElement = $name;
    }


    function __construct( $id = null, $title = null, $summary = null, $body = null, $published = null, $author = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->body = $body;
        $this->published = $published;
        $this->author = $author;
    }

    function getState()
    {
        $state = array(
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'published' => $this->published,
            'author' => $this->author,
        );
        if ( $this->omitElement )
        {
            unset( $state[$this->omitElement] );
        }
        return $state;
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }
}
?>
