<?php
class ezcSearchSimpleImage /* implements ezcSearchEmbeddedDefinition */
{
    public $id;
    public $title;
    public $url;
    public $width;
    public $height;
    public $mime;

    function __construct( $id = null, $title = null, $url = null, $width = null, $height = null, $mime = null )
    {
        $this->id = $id;
        $this->title = $title;
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
        $this->mime = $mime;
    }

    static public function fetchDefinition()
    {
        $n = new ezcSearchDocumentDefinition( 'ezcSearchSimpleImage' );
        $n->idProperty = 'id';
        $n->fields['id']        = new ezcSearchDefinitionDocumentField( 'id', ezcSearchDocumentDefinition::TEXT );
        $n->fields['title']     = new ezcSearchDefinitionDocumentField( 'title', ezcSearchDocumentDefinition::TEXT, 2, true, false, true );
        $n->fields['url']       = new ezcSearchDefinitionDocumentField( 'url', ezcSearchDocumentDefinition::STRING );
        $n->fields['width']     = new ezcSearchDefinitionDocumentField( 'width', ezcSearchDocumentDefinition::INT );
        $n->fields['height']    = new ezcSearchDefinitionDocumentField( 'height', ezcSearchDocumentDefinition::INT );
        $n->fields['mime']      = new ezcSearchDefinitionDocumentField( 'mime', ezcSearchDocumentDefinition::STRING );

        return $n;
    }

    function getState()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'width' => $this->width,
            'height' => $this->height,
            'mime' => $this->mime,
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
