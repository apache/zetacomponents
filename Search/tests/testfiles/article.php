<?php
class Article
{
    public  $id;
    private $title;
    private $summary;
    private $body;
    private $published;


    function __construct( $id, $title, $summary, $body, $published )
    {
        $this->id = $id;
        $this->title = $title;
        $this->summary = $summary;
        $this->body = $body;
        $this->published = $published;
    }

    function getState()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'published' => $this->published,
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
