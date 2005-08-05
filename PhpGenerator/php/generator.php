<?php
/**
 * \class eZPHPCreator ezphpcreator.php
 *  \ingroup eZUtils
 *  \brief eZPHPCreator provides a simple interface for creating and executing PHP code.
 *
 *  To create PHP code you must create an instance of this class,
 *  add any number of elements you choose with
 *  addDefine(), addVariable(), addVariableUnset(), addVariableUnsetList(),
 *  addSpace(), addText(), addMethodCall(), addCodePiece(), addComment() and
 *  addInclude().
 *  After that you call store() to write all changes to disk.
 *
 * <code>
 * $php = new eZPHPCreator( 'cache', 'code.php' );
 *
 * $php->addComment( 'Auto generated' );
 * $php->addInclude( 'inc.php' );
 * $php->addVariable( 'count', 10 );
 *
 * $php->store();
 * </code>
 * cacher til internt array --> skrive senere (istedet skrive med en gang
 * Bytt fremgangsmåte til caching til array til direkte skriving
 * bruk call stack til de under så man kan gjøre error checking
 * mulighet for å sette indenting (bruk en streng)
 * fjern can-restore og restore
 * bruk flock til å låse filer mens du skriver
 * skrive til temporær fil og så ta move til slutt?!?
 * Må kunne bruke FileStream (så filer kan lagres til database)
 * - exchange all add with emit
 * øk indent
 * startIf( $conditions );
 * endIf();
 *
 * startForeach()
 * endForeach()
 */

define( 'EZ_PHPCREATOR_VARIABLE', 1 );
define( 'EZ_PHPCREATOR_SPACE', 2 );
define( 'EZ_PHPCREATOR_TEXT', 3 );
define( 'EZ_PHPCREATOR_METHOD_CALL', 4 );
define( 'EZ_PHPCREATOR_CODE_PIECE', 5 );
define( 'EZ_PHPCREATOR_EOL_COMMENT', 6 );
define( 'EZ_PHPCREATOR_INCLUDE', 7 );
define( 'EZ_PHPCREATOR_VARIABLE_UNSET', 8 );
define( 'EZ_PHPCREATOR_DEFINE', 9 );
define( 'EZ_PHPCREATOR_VARIABLE_UNSET_LIST', 10 );
define( 'EZ_PHPCREATOR_RAW_VARIABLE', 11 );

define( 'EZ_PHPCREATOR_VARIABLE_ASSIGNMENT', 1 );
define( 'EZ_PHPCREATOR_VARIABLE_APPEND_TEXT', 2 );
define( 'EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT', 3 );

define( 'EZ_PHPCREATOR_INCLUDE_ONCE', 1 );
define( 'EZ_PHPCREATOR_INCLUDE_ALWAYS', 2 );

define( 'EZ_PPCREATOR_METHOD_CALL_PARAMETER_VALUE', 1 );
define( 'EZ_PHPCREATOR_METHOD_CALL_PARAMETER_VARIABLE', 2 );

class ezcPhpGenerator
{

    /// \privatesection
    private $phpDir;
    private $phpFile;
    private $fileResource;
    private $isAtomic;
    private $tmpFilename;
    private $requestedFilename;

    // options
    var $indent = "    ";
    var $spacing = true;

    var $indentLevel;

    /**
     * Constructs a new PhpGenrator generator.
     *
     * The generated PHP code will be saved to $file in $dir.
     * @throws PhpGeneratorException If the file can not be opened writing.
     */
    function ezcPhpGenerator( $dir, $file, $options = array() )
    {
    }

    /**
     * Adds a new define statement to the code with the name \a $name and value \a $value.
     *
     * The parameter \a $caseSensitive determines if the define should be made case sensitive or not.
     *
     * Example:
     * <code>
     * $php->addDefine( 'MY_CONSTANT', 5 );
     * </code>
     *
     *     Would result in the PHP code.
     *
     * <code>
     * define( 'MY_CONSTANT', 5 );
     * </code>
     *
     * @param string $name
     * @param string $value
     * @param boolean $caseSensitive
     *
     * note $name must start with a letter or underscore, followed by any number of letters, numbers, or underscores.
     * @See http://php.net/manual/en/language.constants.php for more information.
     * @see http://php.net/manual/en/function.define.php
     *
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the define to file.
     */
    function addDefine( $name, $value, $caseSensitive = true )
    {
    }

    /**
     * Adds a new raw variable to the code with the name $name and value $value.
     *
     * Example:
     * <code>
     * $php->addVariable( 'TransLationRoot', $cache['root'] );
     * </code>
     *
     * @param string $name
     * @param mixed $value;
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the define to file.
     */
    function addRawVariable( $name, $value )
    {
    }

    /**
     *
     * Adds a new variable to the code with the name \a $name and value \a $value.
     *
     * Example:
     * <code>
     * $php->addVariable( 'offset', 5  );
     * $php->addVariable( 'text', 'some more text', EZ_PHPCREATOR_VARIABLE_APPEND_TEXT );
     * $php->addVariable( 'array', 42, EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT );
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * $offset = 5;
     * $text .= 'some more text';
     * $array[] = 42;
     * </code>
     *
     * @param string $name
     * @param mixed $value;
     * @param $assignmentType Controls the way the value is assigned, choose one of the following:
     *            - \b EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, assign using \c = (default)
     *            - \b EZ_PHPCREATOR_VARIABLE_APPEND_TEXT, append using text concat operator \c .
     *            - \b EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT, append element to array using append operator \c []
     *     \param $parameters Optional parameters, can be any of the following:
     *            - \a full-tree, Whether to displays array values as one large expression (\c true) or
     *                            split it up into multiple variables (\c false)
     *
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    function addVariable( $name, $value, $assignmentType = EZ_PHPCREATOR_VARIABLE_ASSIGNMENT,
                          $parameters = array() )
    {
    }

    /**
     * Adds code to unset a variable with the name \a $name.
     *
     * Example:
     * <code>
     * $php->addVariableUnset( 'offset' );
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * unset( $offset );
     * </code>
     *
     * @param string $name
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
    */
    function addVariableUnset( $name )
    {
    }

    /**
     * Adds code to unset a list of variables with name from \a $list.
     *
     * Example:
     * <code>
     * $php->addVariableUnsetList( array ( 'var1', 'var2' ) );
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * unset( $var1, $var2 );
     * </code>
     *
     * @see http://php.net/manual/en/function.unset.php
     * @param array $list Format: array(string)
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    function addVariableUnsetList( $list )
    {
    }

    /**
     * Adds $lines number of empty lines to the generated PHP code.
     *
     * Example:
     * <code>
     * $php->addSpace( 1 );
     * </code>
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    function addSpace( $lines = 1 )
    {
    }

    /**
     * Add plaintext to the generated file.
     * The text will be placed outside of PHP start and end markers and will in principle
     * work as printing the text. This function may only be called before calling any
     * of the add* functions.
     *
     * Example:
     * <code>
     * $php->addText( 'Print me!' );
     * </code>
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    function prependText( $text )
    {
    }

    /**
     * START HERE
     * Adds code to call the method \a $methodName on the object named \a $objectName,
     * \a $methodParameters should be an array with parameter entries where each entry contains:
     *  - \a 0, The parameter value
     *  - \a 1 (\em optional), The type of parameter, is one of:
     *  - \b EZ_PPCREATOR_METHOD_CALL_PARAMETER_VALUE, Use value directly (default if this entry is missing)
     *  - \b EZ_PHPCREATOR_METHOD_CALL_PARAMETER_VARIABLE, Use value as the name of the variable.
     *
     *  Optionally the \a $returnValue parameter can be used to decide what should be done
     *  with the return value of the method call. It can either be \c false which means
     *  to do nothing or an array with the following entries.
     *  - \a 0, The name of the variable to assign the value to
     *  - \a 1 (\em optional), The type of assignment, uses the same value as addVariable().
     *
     * \param $parameters Optional parameters, can be any of the following:
     * - \a spacing, The number of spaces to place before each code line, default is \c 0.
     *
     * Example:
     * <code>
     * $php->addMethodCall( 'node', 'name', array(), array( 'name' ) );
     * $php->addMethodCall( 'php', 'addMethodCall',
     *    array( array( 'node' ), array( 'name' ) ) );
     * </code>
     *
     *     Would result in the PHP code.
     *
     *     \code
     *$name = $node->name();
     *$php->addMethodCall( 'node', 'name' );
     *     \endcode
     */
    function addMethodCall( $objectName, $methodName, $methodParameters, $returnValue = false, $parameters = array() )
    {
    }

    /*!
     Adds custom PHP code to the file, you should only use this a last resort if any
     of the other \em add functions done give you the required result.

     \param $code Contains the code as text, the text will not be modified (except for spacing).
                  This means that each expression must be ended with a newline even if it's just one.
     \param $parameters Optional parameters, can be any of the following:
            - \a spacing, The number of spaces to place before each code line, default is \c 0.

     Example:
     \code
$php->addCodePiece( "if ( \$value > 2 )\n{\n    \$value = 2;\n}\n" );
     \endcode

     Would result in the PHP code.

     \code
if ( $value > 2 )
{
    $value = 2;
}
     \endcode

    */
    function addCodePiece( $code, $parameters = array() )
    {
        $element = array( EZ_PHPCREATOR_CODE_PIECE,
                          $code,
                          $parameters );
        $this->Elements[] = $element;
    }

    /*!
     Adds a comment to the code, the comment will be display using multiple end-of-line
     comments (//), one for each newline in the text \a $comment.

     \param $eol Whether to add a newline at the last comment line
     \param $whitespaceHandling Whether to remove trailing whitespace from each line
     \param $parameters Optional parameters, can be any of the following:
            - \a spacing, The number of spaces to place before each code line, default is \c 0.

     Example:
     \code
$php->addComment( "This file is auto generated\nDo not edit!" );
     \endcode

     Would result in the PHP code.

     \code
// This file is auto generated
// Do not edit!
     \endcode

    */
    function addComment( $comment, $eol = true, $whitespaceHandling = true, $parameters = array() )
    {
    }

    /*!
     Adds an include statement to the code, the file to include is \a $file.

     \param $type What type of include statement to use, can be one of the following:
                  - \b EZ_PHPCREATOR_INCLUDE_ONCE, use \em include_once()
                  - \b EZ_PHPCREATOR_INCLUDE_ALWAYS, use \em include()
     \param $parameters Optional parameters, can be any of the following:
            - \a spacing, The number of spaces to place before each code line, default is \c 0.

     Example:
     \code
$php->addInclude( 'lib/ezutils/classes/ezphpcreator.php' );
     \endcode

     Would result in the PHP code.

     \code
include_once( 'lib/ezutils/classes/ezphpcreator.php' );
     \endcode

    */
    function addInclude( $file, $type = EZ_PHPCREATOR_INCLUDE_ONCE, $parameters = array() )
    {
        $element = array( EZ_PHPCREATOR_INCLUDE,
                          $file,
                          $type,
                          $parameters );
        $this->Elements[] = $element;
    }

    public function startIf( $condition ) {}
    public function endIf() {}
    public function emitElse( $condition = false ) {}
    public function startForeach( $condition ) {}
    public function endForeach(){}
    public function startWhile( $condition ) {}
    public function endWhile(){}
    public function startDo( $condition ) {}
    public function endDo(){}

    /*!
     \static
     Creates a variable statement with an assignment type and returns it.
     \param $variableName The name of the variable
     \param $assignmentType What kind of assignment to use, is one of the following;
                            - \b EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, assign using \c =
                            - \b EZ_PHPCREATOR_VARIABLE_APPEND_TEXT, append to text using \c .
                            - \b EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT, append to array using \c []
     \param $variableParameters Optional parameters for the statement
            - \a is-reference, whether to do the assignment with reference or not (default is not)
    */
    function variableNameText( $variableName, $assignmentType, $variableParameters = array() )
    {
        $variableParameters = array_merge( array( 'is-reference' => false ),
                                           $variableParameters );
        $isReference = $variableParameters['is-reference'];
        $text = '$' . $variableName;
        if ( $assignmentType == EZ_PHPCREATOR_VARIABLE_ASSIGNMENT )
        {
            if ( $isReference )
                $text .= ' =& ';
            else
                $text .= ' = ';
        }
        else if ( $assignmentType == EZ_PHPCREATOR_VARIABLE_APPEND_TEXT )
        {
            $text .= ' .= ';
        }
        else if ( $assignmentType == EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT )
        {
            if ( $isReference )
                $text .= '[] =& ';
            else
                $text .= '[] = ';
        }
        return $text;
    }


    /*!
     \static
     Splits \a $text into multiple lines using \a $splitString for splitting.
     For each line it will prepend the string \a $spacingString n times as specified by \a $spacing.

     It will try to be smart and not do anything when \a $spacing is set to \c 0.

     \param $skipEmptyLines If \c true it will not prepend the string for empty lines.
     \param $spacing Must be a positive number, \c 0 means to not prepend anything.
    */
    function prependSpacing( $text, $spacing, $skipEmptyLines = true, $spacingString = " ", $splitString = "\n" )
    {
        if ( $spacing == 0 or !$this->Spacing )
            return $text;
        $textArray = explode( $splitString, $text );
        $newTextArray = array();
        foreach ( $textArray as $text )
        {
            if ( trim( $text ) != '' and $this->Spacing )
                $textLine = str_repeat( $spacingString, $spacing ) . $text;
            else
                $textLine = $text;
            $newTextArray[] = $textLine;
        }
        return implode( $splitString, $newTextArray );
    }


    /*!
     Opens the file for writing and sets correct file permissions.
     \return The current file resource or \c false if it failed to open the file.
     \note The file name and path is supplied to the constructor of this class.
     \note Multiple calls to this method will only open the file once.
    */
    function open( $atomic = false )
    {
        if ( !$this->FileResource )
        {
            if ( !file_exists( $this->PHPDir ) )
            {
                include_once( 'lib/ezfile/classes/ezdir.php' );
                $ini =& eZINI::instance();
                $perm = octdec( $ini->variable( 'FileSettings', 'StorageDirPermissions' ) );
                eZDir::mkdir( $this->PHPDir, $perm, true );
            }
            $path = $this->PHPDir . '/' . $this->PHPFile;
            $oldumask = umask( 0 );
            $pathExisted = file_exists( $path );
            if ( $atomic )
            {
                $this->isAtomic = true;
                $this->requestedFilename = $path;
                $uniqid = md5( uniqid( "ezp". getmypid(), true ) );
                $path .= ".$uniqid";
                $this->tmpFilename = $path;
            }
            $ini =& eZINI::instance();
            $perm = octdec( $ini->variable( 'FileSettings', 'StorageFilePermissions' ) );
            $this->FileResource = @fopen( $this->FilePrefix . $path, "w" );
            if ( !$this->FileResource )
                eZDebug::writeError( "Could not open file '$path' for writing, perhaps wrong permissions" );
            if ( $this->FileResource and
                 !$pathExisted )
                chmod( $path, $perm );
            umask( $oldumask );
        }
        return $this->FileResource;
    }

    /*!
     Closes the currently open file if any.
    */
    function close()
    {
        if ( $this->FileResource )
        {
            fclose( $this->FileResource );

            if ( $this->isAtomic )
            {
                include_once( 'lib/ezfile/classes/ezfile.php' );
                eZFile::rename( $this->tmpFilename, $this->requestedFilename );
            }
            $this->FileResource = false;
        }
    }

    /*!
     \return \c true if the file and path already exists.
     \note The file name and path is supplied to the constructor of this class.
    */
    function exists()
    {
        $path = $this->PHPDir . '/' . $this->PHPFile;
        return file_exists( $path );
    }



    /*!
     Stores the PHP cache, returns false if the cache file could not be created.
    */
    function store( $atomic = false )
    {
        if ( $this->open( $atomic ) )
        {
            $this->write( "<?php\n" );

            $this->writeElements();

            $this->write( "?>\n" );

            $this->writeChunks();
            $this->flushChunks();
            $this->close();

            // Write log message to storage.log
            include_once( 'lib/ezutils/classes/ezlog.php' );
            eZLog::writeStorageLog( $this->PHPFile, $this->PHPDir . '/' );
            return true;
        }
        else
        {
            eZDebug::writeError( "Failed to open file '" . $this->PHPDir . '/' . $this->PHPFile . "'",
                                 'eZPHPCreator::store' );
            return false;
        }
    }

}
?>
