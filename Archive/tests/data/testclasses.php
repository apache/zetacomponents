<?php
class testExtractCallback extends ezcArchiveCallback
{
    function createFileCallback( $fileName, &$permissions, &$userId, &$groupId )
    {
        $permissions = $permissions & 0600;
    }

    function createDirectoryCallback( $dirName, &$permissions, &$userId, &$groupId )
    {
        $permissions = $permissions & 0700;
    }
}
?>
