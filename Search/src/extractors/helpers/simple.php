<?php
class ezcSearchSimpleArticle implements ezcSearchDefinitionProvider, ezcBasePersistable
{
    public $id;
    public $title;
    public $body;
    public $published;
    public $url;
    public $type;

    function __construct( $id = null, $title = null, $body = null, $published = null, $url = null, $type = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->published = $published;
        $this->url = $url;
        $this->type = $type;
    }

    static public function getDefinition()
    {
        $n = new ezcSearchDocumentDefinition( 'ezcSearchSimpleArticle' );
        $n->idProperty = 'id';
        $n->fields['id']        = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::TEXT );
        $n->fields['title']     = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::TEXT, 2, true, false, true );
        $n->fields['body']      = new ezcSearchDefinitionDocumentField( 'body', ezcSearchDocumentDefinition::TEXT, 1, false, false, true );
        $n->fields['published'] = new ezcSearchDefinitionDocumentField( 'published', ezcSearchDocumentDefinition::DATE );
        $n->fields['url']       = new ezcSearchDefinitionDocumentField( 'url', ezcSearchDocumentDefinition::STRING );
        $n->fields['type']      = new ezcSearchDefinitionDocumentField( 'type', ezcSearchDocumentDefinition::STRING, 0, true, false, false );

        return $n;
    }

    function getState()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'published' => $this->published,
            'url' => $this->url,
            'type' => $this->type,
        );
    }

    function setState( array $state )
    {
        foreach ( $state as $key => $value )
        {
            $this->$key = $value;
        }
    }
}
?>
