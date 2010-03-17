<?php

return array (
  'init' => 
  array (
    0 => 'dav:/> ',
    1 => 'down
up
dav:/> ',
    2 => 'Listing collection `/\': succeeded.
Error: secure_collection              403 Forbidden
Coll:   collection                          4096  Aug 15  2005
        file.bin                               7  Aug 15  2005
        file.xml                              19  Aug 15  2005
dav:/> ',
  ),
  'list collection' => 
  array (
    0 => 'dav:/collection/> ',
    1 => 'Listing collection `/collection/\': succeeded.
Coll:   subdir                              4096  Aug 15  2005
        file.txt                              18  Aug 15  2005
dav:/collection/> ',
    2 => 'dav:/collection/> ',
    3 => 'dav:/collection/> ',
  ),
  'download file' => 
  array (
    0 => 'Downloading `/collection/file.txt\' to file.txt: [..] succeeded.
dav:/collection/> ',
    1 => 'file.txt
dav:/collection/> ',
  ),
  'enter subdir' => 
  array (
    0 => 'dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
        file.html                             39  Aug 15  2005
        file.xml                              18  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'create newdir' => 
  array (
    0 => 'Creating `newdir\': succeeded.
dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   newdir                              4096  Aug 15  2005
        file.html                             39  Aug 15  2005
        file.xml                              18  Aug 15  2005
dav:/collection/subdir/> ',
    2 => 'dav:/collection/subdir/newdir/> ',
    3 => 'Listing collection `/collection/subdir/newdir/\': collection is empty.
dav:/collection/subdir/newdir/> ',
  ),
  'upload file' => 
  array (
    0 => 'Uploading file.txt to `/collection/subdir/newdir/file.txt\': [.. succeeded.
dav:/collection/subdir/newdir/> ',
    1 => 'Listing collection `/collection/subdir/newdir/\': succeeded.
        file.txt                               0  Aug 15  2005
dav:/collection/subdir/newdir/> ',
  ),
  'create newsubdir' => 
  array (
    0 => 'Creating `newsubdir\': succeeded.
dav:/collection/subdir/newdir/> ',
    1 => 'Listing collection `/collection/subdir/newdir/\': succeeded.
Coll:   newsubdir                           4096  Aug 15  2005
        file.txt                               0  Aug 15  2005
dav:/collection/subdir/newdir/> ',
    2 => 'dav:/collection/subdir/newdir/newsubdir/> ',
    3 => 'Listing collection `/collection/subdir/newdir/newsubdir/\': collection is empty.
dav:/collection/subdir/newdir/newsubdir/> ',
  ),
  'upload file overwrite' => 
  array (
    0 => 'Uploading file.txt to `/collection/subdir/newdir/newsubdir/file.txt\': [.. succeeded.
dav:/collection/subdir/newdir/newsubdir/> ',
    1 => 'Listing collection `/collection/subdir/newdir/newsubdir/\': succeeded.
        file.txt                               0  Aug 15  2005
dav:/collection/subdir/newdir/newsubdir/> ',
    2 => 'Uploading file.txt to `/collection/subdir/newdir/newsubdir/file.txt\': [.. succeeded.
dav:/collection/subdir/newdir/newsubdir/> ',
    3 => 'Listing collection `/collection/subdir/newdir/newsubdir/\': succeeded.
        file.txt                               0  Aug 15  2005
dav:/collection/subdir/newdir/newsubdir/> ',
  ),
  'delete newdir' => 
  array (
    0 => 'dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   newdir                              4096  Aug 15  2005
        file.html                             39  Aug 15  2005
        file.xml                              18  Aug 15  2005
dav:/collection/subdir/> ',
    2 => 'Deleting collection `newdir\': succeeded.
dav:/collection/subdir/> ',
    3 => 'Listing collection `/collection/subdir/\': succeeded.
        file.html                             39  Aug 15  2005
        file.xml                              18  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'download multiple files' => 
  array (
    0 => 'Downloading `/collection/subdir/file.html\' to file.html: [..] succeeded.
dav:/collection/subdir/> ',
    1 => 'Downloading `/collection/subdir/file.xml\' to file.xml: [..] succeeded.
dav:/collection/subdir/> ',
    2 => 'file.html
file.txt
file.xml
dav:/collection/subdir/> ',
  ),
  'delete files' => 
  array (
    0 => 'Deleting `file.html\': succeeded.
dav:/collection/subdir/> ',
    1 => 'Deleting `file.xml\': succeeded.
dav:/collection/subdir/> ',
    2 => 'Listing collection `/collection/subdir/\': collection is empty.
dav:/collection/subdir/> ',
  ),
  'upload utf-8' => 
  array (
    0 => 'dav:/collection/subdir/> ',
    1 => 'collection
put_test.html
put_test_utf8_content.txt
put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt
dav:/collection/subdir/> ',
    2 => 'Uploading put_test.html to `/collection/subdir/put_test.html\': [.... succeeded.
Uploading put_test_utf8_content.txt to `/collection/subdir/put_test_utf8_content.txt\': [.. succeeded.
Uploading put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt to `/collection/subdir/put_test_utf8_filename_%cf%82%d2%a3%ce%b1%e2%8a%81%e2%88%ad%e2%8b%89%e2%82%ac%e2%82%b1%e2%80%b1%e2%81%8c.txt\': [.. succeeded.
dav:/collection/subdir/> ',
    3 => 'Listing collection `/collection/subdir/\': succeeded.
        put_test.html                          0  Aug 15  2005
        put_test_utf8_content.txt              0  Aug 15  2005
        put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt          0  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'upload collection' => 
  array (
    0 => 'Creating `collection\': succeeded.
dav:/collection/subdir/> ',
    1 => 'dav:/collection/subdir/collection/> ',
    2 => 'Listing collection `/collection/subdir/collection/\': collection is empty.
dav:/collection/subdir/collection/> ',
    3 => 'dav:/collection/subdir/collection/> ',
    4 => 'Uploading put_test.xml to `/collection/subdir/collection/put_test.xml\': [... succeeded.
Uploading put_test.zip to `/collection/subdir/collection/put_test.zip\': [... succeeded.
dav:/collection/subdir/collection/> ',
    5 => 'Listing collection `/collection/subdir/collection/\': succeeded.
        put_test.xml                           0  Aug 15  2005
        put_test.zip                           0  Aug 15  2005
dav:/collection/subdir/collection/> ',
  ),
  'download uploaded' => 
  array (
    0 => 'dav:/collection/subdir/> ',
    1 => 'dav:/collection/subdir/> ',
    2 => 'file.html
file.txt
file.xml
dav:/collection/subdir/> ',
    3 => 'Downloading `/collection/subdir/put_test.html\' to put_test.html: [.....] succeeded.
Downloading `/collection/subdir/put_test_utf8_content.txt\' to put_test_utf8_content.txt: [..] succeeded.
Downloading `/collection/subdir/put_test_utf8_filename_%cf%82%d2%a3%ce%b1%e2%8a%81%e2%88%ad%e2%8b%89%e2%82%ac%e2%82%b1%e2%80%b1%e2%81%8c.txt\' to put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt: [..] succeeded.
Downloading `/collection/subdir/collection/put_test.xml\' to put_test.xml: [.....] succeeded.
Downloading `/collection/subdir/collection/put_test.zip\' to put_test.zip: [....] succeeded.
dav:/collection/subdir/> ',
    4 => 'file.html
file.txt
file.xml
put_test.html
put_test_utf8_content.txt
put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt
put_test.xml
put_test.zip
dav:/collection/subdir/> ',
  ),
  'rename files utf-8' => 
  array (
    0 => 'Moving `/collection/subdir/put_test.html\' to `/collection/subdir/put_test_renamed.xml\':  succeeded.
dav:/collection/subdir/> ',
    1 => 'Moving `/collection/subdir/put_test_utf8_content.txt\' to `/collection/subdir/put_test_%c3%b6%c3%a4%c3%bc%c3%9f.txt\':  succeeded.
dav:/collection/subdir/> ',
    2 => 'Moving `/collection/subdir/put_test_utf8_filename_%cf%82%d2%a3%ce%b1%e2%8a%81%e2%88%ad%e2%8b%89%e2%82%ac%e2%82%b1%e2%80%b1%e2%81%8c.txt\' to `/collection/subdir/put_non_utf8_test.txt\':  succeeded.
dav:/collection/subdir/> ',
    3 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   collection                          4096  Aug 15  2005
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'copy files remote' => 
  array (
    0 => 'Copying `/collection/subdir/put_test_renamed.xml\' to `/collection/subdir/collection/put_test_renamed.xml\':  succeeded.
dav:/collection/subdir/> ',
    1 => 'Copying `/collection/subdir/put_test_%c3%b6%c3%a4%c3%bc%c3%9f.txt\' to `/collection/subdir/collection/put_test_%c3%b6%c3%a4%c3%bc%c3%9f.txt\':  succeeded.
dav:/collection/subdir/> ',
    2 => 'Copying `/collection/subdir/put_non_utf8_test.txt\' to `/collection/subdir/collection/put_non_utf8_test.txt\':  succeeded.
dav:/collection/subdir/> ',
    3 => 'Listing collection `/collection/subdir/collection/\': succeeded.
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test.xml                           0  Aug 15  2005
        put_test.zip                           0  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'rename collection' => 
  array (
    0 => 'Moving `/collection/subdir/collection\' to `/collection/subdir/renamed_collection\':  succeeded.
dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   renamed_collection                  4096  Aug 15  2005
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
    2 => 'Listing collection `/collection/subdir/renamed_collection/\': succeeded.
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test.xml                       14013  Aug 15  2005
        put_test.zip                       10644  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'copy collection' => 
  array (
    0 => 'Copying `/collection/subdir/renamed_collection\' to `/collection/subdir/collection\':  succeeded.
dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   collection                          4096  Aug 15  2005
Coll:   renamed_collection                  4096  Aug 15  2005
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
    2 => 'Listing collection `/collection/subdir/collection/\': succeeded.
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test.xml                       14013  Aug 15  2005
        put_test.zip                       10644  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
    3 => 'Listing collection `/collection/subdir/renamed_collection/\': succeeded.
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test.xml                       14013  Aug 15  2005
        put_test.zip                       10644  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
  ),
  'delete renamed_collection' => 
  array (
    0 => 'Deleting collection `renamed_collection\': succeeded.
dav:/collection/subdir/> ',
    1 => 'Listing collection `/collection/subdir/\': succeeded.
Coll:   collection                          4096  Aug 15  2005
        put_non_utf8_test.txt                 21  Aug 15  2005
        put_test_öäüß.txt                739  Aug 15  2005
        put_test_renamed.xml               18803  Aug 15  2005
dav:/collection/subdir/> ',
  ),
);

?>