<?php
// Required for the eZ Components autoload mechanism.
// The components must be from SVN and the trunk directory must be in the path.
// For PEAR installations, use: require_once 'ezc/Base/base.php';
require_once "Base/src/base.php";

/**
 * Required for the eZ Components autoload mechanism.
 *
 * @param string $className A class to autoload
 */
function __autoload( $className )
{
    ezcBase::autoload( $className );
}

// *************************************************************************

echo "eZ Components feed creator\n";
if ( count( $argv ) < 3 )
{
    echo "\tFirst parameter: feed type (rss1, rss2 or atom)\n";
    echo "\tSecond parameter: text file name\n";
    die();
}

$feedType = $argv[1];
$sourceFile = $argv[2];

$data = readDataFile( $sourceFile );
$xml = createFeed( $feedType, $data );

$destFile = substr( $sourceFile, 0, strrpos( $sourceFile, '.' ) ) . '.xml';
echo "Creating xml file {$destFile} with contents:\n\n";
file_put_contents( $destFile, $xml );
echo $xml . "\n\n";

// *************************************************************************

/**
 * Reads data from a file and returns an array to be used with the function
 * createFeed().
 *
 * The format of the returned array is:
 * <code>
 * array( 'title' => 'Feed title',
 *        'link' => 'Feed link',
 *        'published' => 'Feed published date',
 *        'authorName' => 'Feed author name',
 *        'authorEmail' => 'Feed author email',
 *        'description' => 'Feed description',
 *        'items' => array(
 *                          0 => array( 'title' => 'Item 0 title',
 *                                      'link' => 'Item 0 link',
 *                                      'published' => 'Item 0 published date',
 *                                      'authorName' => 'Item 0 author name',
 *                                      'authorEmail' => 'Item 0 author email',
 *                                      'description' => 'Item 0 description',
 *                                    ),
 *                          1 => array( 'title' => 'Item 1 title',
 *                                      'link' => 'Item 1 link',
 *                                      'published' => 'Item 1 published date',
 *                                      'authorName' => 'Item 1 author name',
 *                                      'authorEmail' => 'Item 1 author email',
 *                                      'description' => 'Item 1 description',
 *                                    ),
 *                         )
 *      );
 * </code>
 *
 * @throws ezcBaseFileNotFoundException
 *         If $fileName is not found
 * @throws ezcBaseFilePermissionException
 *         If $fileName cannot be opened
 *
 * @param string $fileName A file name containing a full or relative path
 * @return array(mixed)
 */
function readDataFile( $fileName )
{
    if ( !file_exists( $fileName ) )
    {
        throw new ezcBaseFileNotFoundException( $fileName );
    }

    if ( ( $fh = @fopen( $fileName, 'r' ) ) === false )
    {
        throw new ezcBaseFilePermissionException( $fileName, ezcBaseFileException::READ );
    }

    $data = array();
    $data['title'] = trim( fgets( $fh ) );
    $data['link'] = trim( fgets( $fh ) );
    $data['published'] = trim( fgets( $fh ) );
    $data['authorName'] = trim( fgets( $fh ) );
    $data['authorEmail'] = trim( fgets( $fh ) );
    $data['description'] = trim( fgets( $fh ) );
    $empty = fgets( $fh );

    $data['item'] = array();
    $i = 0;
    while ( !feof( $fh ) )
    {
        $data['item'][$i] = array();
        $data['item'][$i]['title'] = trim( fgets( $fh ) );
        $data['item'][$i]['link'] = trim( fgets( $fh ) );
        $data['item'][$i]['published'] = trim( fgets( $fh ) );
        $data['item'][$i]['authorName'] = trim( fgets( $fh ) );
        $data['item'][$i]['authorEmail'] = trim( fgets( $fh ) );
        $data['item'][$i]['description'] = trim( fgets( $fh ) );
        $empty = fgets( $fh );
        $i++;
    }
    fclose( $fh );
    return $data;
}

/**
 * Uses the array $data to create a feed of type $feedType ('rss1', 'rss2' or
 * 'atom') and returns it as a string.
 *
 * The format of the $data array is:
 * <code>
 * array( 'title' => 'Feed title',
 *        'link' => 'Feed link',
 *        'published' => 'Feed published date',
 *        'authorName' => 'Feed author name',
 *        'authorEmail' => 'Feed author email',
 *        'description' => 'Feed description',
 *        'items' => array(
 *                          0 => array( 'title' => 'Item 0 title',
 *                                      'link' => 'Item 0 link',
 *                                      'published' => 'Item 0 published date',
 *                                      'authorName' => 'Item 0 author name',
 *                                      'authorEmail' => 'Item 0 author email',
 *                                      'description' => 'Item 0 description',
 *                                    ),
 *                          1 => array( 'title' => 'Item 1 title',
 *                                      'link' => 'Item 1 link',
 *                                      'published' => 'Item 1 published date',
 *                                      'authorName' => 'Item 1 author name',
 *                                      'authorEmail' => 'Item 1 author email',
 *                                      'description' => 'Item 1 description',
 *                                    ),
 *                         )
 *      );
 * </code>
 *
 * @param string $feedType The type of the feed to create ('rss1', 'rss2' or 'atom')
 * @param array(mixed) $data Data for the elements of the feed
 * @return string
 */
function createFeed( $feedType, $data )
{
    $feed = new ezcFeed();
    $feed->title = $data['title'];
    $feed->description = $data['description'];

    $feed->id = $data['link'];

    $link = $feed->add( 'link' );
    $link->href = $data['link'];

    $feed->updated = time();
    $feed->published = $data['published'];

    $author = $feed->add( 'author' );
    $author->name = $data['authorName'];
    $author->email = $data['authorEmail'];

    foreach ( $data['item'] as $dataItem )
    {
        $item = $feed->add( 'item' );
        $item->title = $dataItem['title'];
        $item->description = $dataItem['description'];

        $item->id = $dataItem['link'];
        $item->id->isPermaLink = true; // RSS2 only

        $link = $item->add( 'link' );
        $link->href = $dataItem['link'];
        $link->rel = 'alternate';

        $item->updated = time();
        $item->published = $dataItem['published'];

        $author = $item->add( 'author' );
        $author->name = $dataItem['authorName'];
        $author->email = $dataItem['authorEmail'];
    }

    return $feed->generate( $feedType );
}
?>
