<?php
/**
 * File containing the ezcTemplateCursor class
 *
 * @package Template
 * @version //autogen//
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */
/**
 * Cursor for template parser encapsulating text and position.
 *
 * @package Template
 * @version //autogen//
 * @access private
 */
class ezcTemplateCursor
{
    public $text;
    public $position;
    public $line;
    public $column;

    /**
     * Initialise with text block and position data.
     *
     * @param string $text     Text block which the cursor position relates to.
     * @param int    $position The string position in the text, starts at 0.
     * @param int    $line     The line position in the text, starts at 1.
     * @param int    $column   The column position in the text, starts at 0.
     */
    public function __construct( $text, $position = 0, $line = 1, $column = 0 )
    {
        $this->text = $text;
        $this->position = $position;
        $this->line = $line;
        $this->column = $column;
    }

    /**
     * Copies all the properties of cursor $other to this cursor.
     *
     * @param ezcTemplateCursor $other The cursor object to copy from.
     */
    public function copy( ezcTemplateCursor $other )
    {
        $this->text = $other->text;
        $this->position = $other->position;
        $this->line = $other->line;
        $this->column = $other->column;
    }

    /**
     * Calculates the length between this cursor and the specified cursor.
     * Note: If the specified cursor is before this one it returns negative values.
     *
     * @param ezcTemplateCursor $other The cursor to use as end position for measuring length.
     * @return int
     */
    public function length( ezcTemplateCursor $other )
    {
        return $other->position - $this->position;
    }

    /**
     * Checks if the cursor is at the beggining of the text and returns true if
     * it is.
     *
     * @return bool
     */
    public function atBeginning()
    {
        return $this->position == 0;
    }

    /**
     * Checks if the cursor is at the end of the text and returns true if it is.
     *
     * @return bool
     * Note: The cursor is considered at the end if it is placed after the last
     *       character in the text ( ie. strlen( $text ) ), this is different
     *       from being at the last character ( strlen( $text ) - 1 ).
     */
    public function atEnd()
    {
        return $this->position == strlen( $this->text );
    }

    /**
     * Moves the cursor to the beginning of the text.
     *
     * @see atBeginning()
     */
    public function gotoBeginning()
    {
        $this->position = 0;
        $this->line = 1;
        $this->column = 0;
    }

    /**
     * Moves the cursor to the end of the text.
     *
     * @see atEnd()
     */
    public function gotoEnd()
    {
        $endPosition = strlen( $this->text );
        if ( $this->position == $endPosition )
            return;

        $lines = preg_split( "#\r\n|\r|\n#", substr( $this->text, $this->position ) );
        if ( count( $lines ) > 0 )
        {
            $endLine = $this->line + count( $lines ) - 1;
            $lastLine = $lines[count( $lines ) - 1];
            if ( count( $lines ) > 1 )
                $endColumn = strlen( $lastLine );
            else
                $endColumn = $this->column + strlen( $lastLine );
        }
        else
        {
            $endLine = $this->line;
            $endColumn = $this->column;
        }
        $this->position = $endPosition;
        $this->line = $endLine;
        $this->column = $endColumn;
    }

    /**
     * Moves the cursor to the beginning of the current line.
     *
     * @see gotoLineEnd()
     */
    public function gotoLineBeginning()
    {
        $this->position -= $this->column;
        $this->column = 0;
    }

    /**
     * Moves the cursor to the end of the current line.
     * The end of the line is considered right before the EOL marker.
     *
     * Note: If the current line is at the end of the buffer the position will
     *       be placed at the end of the buffer similar to gotoEnd().
     * @see gotoLineBeginning()
     */
    public function gotoLineEnd()
    {
        $endPosition = strlen( $this->text );
        if ( $this->position == $endPosition )
            return;

        // If we find a newline we adjust endPosition to this location,
        // if not we use the end of the buffer.
        if ( preg_match( "#\r\n|\r|\n#", $this->text, $matches, PREG_OFFSET_CAPTURE, $this->position ) )
        {
            $endPosition = $matches[0][1];
        }
        // Increase column and set end position
        $this->column += $endPosition - $this->position;
        $this->position = $endPosition;
    }

    /**
     * Moves the cursor n steps relatively to the current position.
     *
     * @param int $delta The number of characters to advance.
     */
    public function advance( $delta = 1 )
    {
        $this->gotoPosition( $this->position + $delta );
    }

    /**
     * Moves the cursor to the specified position.
     *
     * @see atBeginning(), atEnd()
     */
    function gotoPosition( $endPosition )
    {
        if ( $endPosition > strlen( $this->text ) )
            throw new ezcTemplateCursorsException();

        if ( $this->position == $endPosition )
            return;

    /* Not supported yet, might not be needed
        if ( $this->position > $endPosition )
    */
        {
            $lines = preg_split( "#\r\n|\r|\n#", substr( $this->text, $this->position, $endPosition - $this->position ) );
            if ( count( $lines ) > 0 )
            {
                $endLine = $this->line + count( $lines ) - 1;
                $lastLine = $lines[count( $lines ) - 1];
                if ( count( $lines ) > 1 )
                    $endColumn = strlen( $lastLine );
                else
                    $endColumn = $this->column + strlen( $lastLine );
            }
            else
            {
                $endLine = $this->line;
                $endColumn = $this->column;
            }
        }
    /* Not supported yet, might not be needed
        else
        {
            $lines = preg_split( "#\r\n|\r|\n#", substr( $this->text, $endPosition, $this->position - $endPosition ) );
            if ( count( $lines ) > 0 )
            {
                $endLine = $this->line - count( $lines ) - 1;
                $lastLine = $lines[count( $lines ) - 1];
                if ( $endPosition > 0 )
                {
                    $endColumn = 0;
                    for ( $i = $endPosition - 1; $i > 0; --$i )
                    {
                        switch ( $this->text[$i] )
                        {
                            case "\n":
                            case "\r":
                                $endColumn = $endPosition - $i;
                                break 2;
                        }
                    }
                }
                else
                {
                    $endColumn = 0;
                }
            }
            else
            {
                $endLine = $this->line;
                $endColumn = $this->column;
            }
        }
    */
        $this->position = $endPosition;
        $this->line = $endLine;
        $this->column = $endColumn;
    }

    /**
     * Extracts a substring from the current position in the text and to a given
     * end position. If the position is at the end it returns false.
     *
     * @param string $endPosition The end position of the substring, if this is false
     *                            it will fetch the entire substring from the current
     *                            position.
     * @return string
     */
    public function subString( $endPosition = false )
    {
        if ( $endPosition === false )
            return substr( $this->text, $this->position );
        return substr( $this->text, $this->position, $endPosition - $this->position );
    }

    /**
     * Finds the first occurence of the string $searchString in the text block from
     * the current position.
     *
     * @param string $searchString The string to find in the text (case-sensitive).
     * @return int/false
     */
    public function findPosition( $searchString, $checkEscaped = false )
    {
        if ( $this->position === strlen( $this->text ) )
            return false;

        if ( !$checkEscaped )
            return strpos( $this->text, $searchString, $this->position );

        $position = $this->position;
        while ( ( $position = strpos( $this->text, $searchString, $position ) ) !== false )
        {
            
            $escapedPos = 1; 
            while ( $position - $escapedPos >= 0 && $this->text[$position - $escapedPos] == "\\" )
            {
                $escapedPos++;
            }

            if ( $escapedPos % 2 == 1 )
            {
                break;
            }

          /* 
            
            if ( $this->text[$position-1] != "\\" )
                break;
                */

            ++$position;
        }
        return $position;
    }

    /**
     * Creates a clone of the current cursor at the specified position and returns it.
     *
     * @param int $position The position for the new cursor, line and column will be recalculated accordingly.
     * @param int $newSize If this is non-false it will limit the text buffer for the new cursor.
     * @return ezcTemplateCursor
     */
    public function cursorAt( $position, $newSize = false )
    {
        if ( $position < $this->position )
            throw Exception( "Cannot move position backwards yet, sorry" );

        $cursor = clone $this;
        if ( $newSize !== false )
            $cursor->text = substr( $cursor->text, 0, $newSize );
        $cursor->gotoPosition( $position );
        return $cursor;
    }

    /**
     * Returns the character(s) at the current position. If the position is at the
     * end it returns false.
     *
     * @param int $length The number of character to fetch from current position, negative values fetches in reverse.
     * @return string/false
     * @see atEnd()
     */
    public function current( $length = 1 )
    {
        if ( $this->position === strlen( $this->text ) )
            return false;
        return substr( $this->text, $this->position, $length );
    }



    /**
     * Performs a preg_match() on the current position to figure out if the
     * pattern matches. The preg_match() will be called with PREG_OFFSET_CAPTURE
     * so the return matches will contain the offset as well, however the offset
     * will be relative to the starting position and not the start of the buffer.
     *
     * Note: To check that a pattern matches immediately at the start position use the
     *       ^ in the pattern string.
     *
     *
     *
     * @param tring $pattern The pattern which is passed to preg_match().
     * @return The result of the preg_match() if successful or false it it failed.
     */
    public function pregMatchComplete( $pattern )
    {
        if ( $this->position === strlen( $this->text ) )
            return false;

        if ( !preg_match( $pattern, substr( $this->text, $this->position ), $matches, PREG_OFFSET_CAPTURE ) )
            return false;


        return $matches;
    }

    /**
     * Does a pregMatchComplete and returns only the [0][0] part.
     */
    public function pregMatch( $pattern, $advance = true )
    {
        $matches = $this->pregMatchComplete( $pattern );

        if ( $matches === false )
        {
            return false;
        }

        if ( $advance )
        {
            $this->advance( strlen( $matches[0][0] ) );
        }

        return $matches[0][0];
    }


    /**
     * @return bool  True if the $word matches, otherwise false.
     */
    public function match( $word, $advance = true)
    {
        $len = strlen( $word );
        if ( $this->current( $len ) == $word )
        {
            if ( $advance ) $this->advance( $len );

            return true;
        }

        return false;
    }

}



?>
