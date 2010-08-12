<?php
/**
 * File containing the ezcArchiveStatMode class.
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
 * @version //autogentag//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @access private
 */

/**
 * The ezcArchiveStatMode class stores the stat-mode constant values.
 *
 * Compare the bits from the "mode" array element from {@link http://www.php.net/stat}.
 * For example to get the file permissions in an octal number:
 * <code>
 * $stat = stat( "/tmp/myfile.txt" );
 * $perm = decoct( $stat["mode"] & ezcArchiveStatMode::S_PERM_MASK );
 * </code>
 *
 * To see if the file is a directory, the following code can be used:
 * <code>
 * $stat = stat( "/tmp/myfile.txt" );
 * $isDirectory = ( ( $stat["mode"] & S_FMT ) == ezcArchiveStatMode::S_IFDIR );
 * </code>
 *
 * @package Archive
 * @version //autogentag//
 * @access private
 */
class ezcArchiveStatMode
{
    /**
     * Type of the file.
     */
    const S_IFMT = 0170000;

    /**
     * Named pipe (fifo).
     */
    const S_IFIFO = 0010000;

    /**
     * character special.
     */
    const S_IFCHR = 0020000;

    /**
     * Directory
     */
    const S_IFDIR = 0040000;

    /**
     * block special
     */
    const S_IFBLK = 0060000;

    /**
     * regular file
     */
    const S_IFREG = 0100000;

    /**
     * Symbolic link
     */
    const S_IFLNK = 0120000;

    /**
     * Socket
     */
    const S_IFSOCK = 0140000;

    /**
     * Whiteout
     */
    const S_IFWHT = 0160000;

    /**
     * Permission mask
     */
    const S_PERM_MASK = 07777;
}
?>
