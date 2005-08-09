<?php
/**
 * File containing the ezcImageAnalyzer class.
 *
 * @package ImageAnalysis
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */

/**
 * Class to retreive information about a given image file.
 * This class provides a simple static method to analyse image files
 * in different ways. At least the MIME type of the file is returned.
 * In some cases (by now JPEG, TIFF and GIF) additional information is
 * included.
 * 
 * @package ImageAnalysis
 * @version //autogen//
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL {@link http://www.gnu.org/copyleft/lesser.html}
 */
class ezcImageAnalyzer
{
    
    /**
     * Analyse a file.
     * This method analyses the given file and returns information on it.
     * The information returned has the following format:
     *
     * <code>
     * array(
     *  'mime'  => '<mimeType>',
     *  'extra' => array()      // optional extra information, depends on MIME type.
     * );
     * </code>
     *
     * @param string The file to analyse.
     * @return array(string)
     *
     * @throws ezcImageAnalyzerException If image could not be analysed.
     * @throws ezcImageAnalyzerFileException If image is not readable.
     */
    public static function analyse( $file ) {
        
    }

    /**
     * Analyses files containing EXIF information.
     * Analyses JPEG and TIFF images.
     *
     * @param string The file to process.
     * @return array(string) Information gathered from EXIF.
     */
    private static function processExif( $file ) {
        
    }
    
    /**
     * Analyse GIF files.
     * Analyse GIF files and check if they are animated.
     *
     * @param string The file to process
     * @return array(string) Information gathered from the file.
     */
    private static function processGif( $file ) {
        
    }
}
