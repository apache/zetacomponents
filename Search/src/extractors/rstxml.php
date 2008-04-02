<?php
class ezcSearchRstXmlExtractor /* implements ezcSearchExtractor */
{
	static public function extract( $fileName )
	{
		$published = filemtime( $fileName );

		$converted = file_get_contents( $fileName );
		$dom = new DomDocument();
		@$dom->loadHtml( $converted );
		$tbody = $dom->getElementsByTagName('div')->item(0);

		$xpath = new DOMXPath($dom);
        $tocElem = $xpath->evaluate("//h1[@class='title']", $tbody )->item(0);
		$title = $tocElem->nodeValue;

		$tbody = $dom->getElementsByTagName('p');
		$body = '';
		foreach( $tbody as $item )
		{
			$body .= strip_tags( $dom->saveXml( $item ) ) . "\n\n";
		}

		return new ezcSearchSimpleArticle( null, $title, $body, $published, "URLHERE" );
	}
}
?>
