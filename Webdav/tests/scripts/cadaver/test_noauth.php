<?php

require_once 'Base/src/ezc_bootstrap.php';

require 'client.php';
require 'tester.php';

$cadaver = new ezcWebdavTestCadaverClient(
    'http://webdav/',
    ezcWebdavTestCadaverTester::setupEnv()
);

$tester = new ezcWebdavTestCadaverTester( $cadaver );

$commands = array(
    'init' => array(
        "",
        "lls\n",
        "ls\n",
    ),
    'list collection' => array(
        "cd collection\n",
        "ls\n",
        "lcd down\n",
        "lls\n",
    ),
    'download file' => array(
        "get file.txt\n",
        "lls\n",
    ),
    'enter subdir' => array(
        "cd subdir\n",
        "ls\n",
    ),
    'create newdir' => array(
        "mkcol newdir\n",
        "ls\n",
        "cd newdir\n",
        "ls\n",
    ),
    'upload file' => array(
        "put file.txt\n",
        "ls\n",
    ),
    'create newsubdir' => array(
        "mkcol newsubdir\n",
        "ls\n",
        "cd newsubdir\n",
        "ls\n",
    ),
    'upload file overwrite' => array(
        "put file.txt\n",
        "ls\n",
        "put file.txt\n",
        "ls\n",
    ),
    'delete newdir' => array(
        "cd ../../\n",
        "ls\n",
        "rmcol newdir\n",
        "ls\n",
    ),
    'download multiple files' => array(
        "get file.html\n",
        "get file.xml\n",
        "lls\n",
    ),
    'delete files' => array(
        "rm file.html\n",
        "rm file.xml\n",
        "ls\n",
    ),
    'upload utf-8' => array(
        "lcd ../up\n",
        "lls\n",
        "mput put_test.html put_test_utf8_content.txt put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt\n",
        "ls\n",
    ),
    'upload collection' => array(
        "mkcol collection\n",
        "cd collection\n",
        "ls\n",
        "lcd collection\n",
        "mput put_test.xml put_test.zip\n",
        "ls\n",
    ),
    'download uploaded' => array(
        "cd ..\n",
        "lcd ../../down\n",
        "lls\n",
        "mget put_test.html put_test_utf8_content.txt put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt collection/put_test.xml collection/put_test.zip\n",
        "lls\n",
    ),
    'rename files utf-8' => array(
        "move put_test.html put_test_renamed.xml\n",
        "move put_test_utf8_content.txt put_test_öäüß.txt\n",
        "move put_test_utf8_filename_ςңα⊁∭⋉€₱‱⁌.txt put_non_utf8_test.txt\n",
        "ls\n",
    ),
    'copy files remote' => array(
        "copy put_test_renamed.xml collection/\n",
        "copy put_test_öäüß.txt collection/\n",
        "copy put_non_utf8_test.txt collection/\n",
        "ls collection/\n",
    ),
    'rename collection' => array(
        "move collection renamed_collection\n",
        "ls\n",
        "ls renamed_collection/\n",
    ),
    'copy collection' => array(
        "copy renamed_collection collection\n",
        "ls\n",
        "ls collection\n",
        "ls renamed_collection\n",
    ),
    'delete renamed_collection' => array(
        "rmcol renamed_collection\n",
        "ls\n",
    ),
);

$tester->run(
    $commands,
    require dirname( __FILE__ ) . '/test_noauth_res.php'
);

// $results = $tester->generate( $commands );

// file_put_contents(
// dirname( __FILE__ ) . '/test_noauth_res.php',
// "<?php\n\nreturn " . var_export( $results, true ) . ";"
// );

// $tester->inspect( $commands, $results );

?>
