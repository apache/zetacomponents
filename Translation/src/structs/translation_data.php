<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Translation
 */
/**
 * A container to store one translatable string.
 *
 * This struct is used in various classes to store the data accompanying one
 * translatable string.
 *
 * @package Translation
 */
class ezcTranslationData
{
    /**
     * Used when the translated string is up-to-date
     */
    const TRANSLATED = 0;

    /**
     * Used when a translated string has not been translated yet.
     */
    const UNFINISHED = 1;

    /**
     * Used when a translated string is obsolete.
     */
    const OBSOLETE = 2;

    /**
     * The original untranslated source string.
     *
     * @var string
     */
    public $original;

    /**
     * The translated string.
     *
     * @var string
     */
    public $translation;

    /**
     * Comment about the translation.
     *
     * @var string
     */
    public $comment;

    /**
     * The status, which is one of the three constants TRANSLATED, UNFINISHED or OBSOLETE.
     *
     * @var integer
     */
    public $status;

    /**
     * Constructs an ezcTranslationData object.
     *
     * @param string $original
     * @param string $translation
     * @param string $comment
     * @param int $status
     */
    function __construct( $original, $translation, $comment, $status )
    {
        $this->original = $original;
        $this->translation = $translation;
        $this->comment = $comment;
        $this->status = $status;
    }

    static public function __set_state( array $array )
    {
        return new ezcTranslationData( $array['original'], $array['translation'], $array['comment'], $array['status'] );
    }
}
?>
