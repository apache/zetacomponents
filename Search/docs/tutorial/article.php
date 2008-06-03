<?php
class Article implements ezcBasePersistable, ezcSearchDefinitionProvider
{
    public  $id;
    public  $title;
    private $body;
    private $published;
    private $url;
    private $type;

    function __construct( $id = null, $title = null, $body = null, $published = null, $url = null, $type = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->published = $published;
        $this->url = $url;
        $this->type = $type;
    }

    function getState()
    {
        $state = array(
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'published' => $this->published,
            'url' => $this->url,
            'type' => $this->type,
        );
        return $state;
    }

    function setState( $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }

    static public function getDefinition()
    {
        $n = new ezcSearchDocumentDefinition( __CLASS__ );
        $n->idProperty = 'id';
        $n->fields['id']        = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::TEXT );
        $n->fields['title']     = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::TEXT, 2, true, false, true );
        $n->fields['body']      = new ezcSearchDefinitionDocumentField( 'body', ezcSearchDocumentDefinition::TEXT, 1, false, false, true );
        $n->fields['published'] = new ezcSearchDefinitionDocumentField( 'published', ezcSearchDocumentDefinition::DATE );
        $n->fields['url']       = new ezcSearchDefinitionDocumentField( 'url', ezcSearchDocumentDefinition::STRING );
        $n->fields['type']      = new ezcSearchDefinitionDocumentField( 'type', ezcSearchDocumentDefinition::STRING, 0, true, false, false );

        return $n;
    }
}
?>
