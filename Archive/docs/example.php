<?php
/**
 *
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Archive
 */

// Add "MyDirectory" to a new archive: myArchive.tar
// [ tar -cf myArchive.tar MyDirectory ]

$ar = new Tar( "myArchive.tar" );
$ar->append( "MyDirectory" );

// Show the files in the archive.
// [ tar -tf myArchive.tar ]
$fileListing = $ar->getList();
foreach( $fileListing as $file )
{
    print( "Archived file: $file\n" );
}

// Append the file /etc/passwd
// [ tar -rf myArchive.tar /etc/passwd ]
$ar->append( "/etc/passwd" );

// Delete the directory and it's contents
// [ tar -f myArchive.tar --delete MyDirectory ]
$ar->delete( "MyDirectory" );

// Append another directory .. 
$ar->append( "AnotherDirectory" );

// .. and show detailed file permissions plus the file or directory path.
$fileListing = $ar->getList();
foreach( $fileListing as $file )
{
    $entry = $ar->getArchivedEntry( $file );

    print( $entry->getPermissionsString() );

    if ( $entry->isDirectory() )
    {
        print( " [ ".$entry->getPath()." ]\n" );
    }
    else
    {
        print( "   ".$entry->getPath()."\n" );
    }
}


// Extract the whole archive to the tmp directory
$ar->extractTo( "/tmp/" );

// Extract the passwd file to the file: /tmp/passwd-backup
$ar->extractTo( "/tmp/passwd-backup", "passwd" );



// Extracting the gzipped archive: compressedTar.tgz to the tmp directory:
$ar = new Tar( "compress.zlib://compressedTar.tgz" );
$ar->extractTo( "/tmp/" );

// .. and append the password file.
$ar->append( "/etc/passwd" );
?>
