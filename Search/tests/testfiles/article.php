<?php
class Article
{
    public  $id;
    public  $title;
    private $summary;
    private $body;
    private $published;
    private $author;


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
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'published' => $this->published,
            'author' => $this->author,
        );
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
