<?php
/**
 * class eczPhpGenerator
 * eZPHPCreator provides a simple interface for creating and executing PHP code.
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
 * @todo For implementor: Direct writes, no caching to arrays first
 * @todo Call stack for if/foreach etc. so you we can check that they are closed correctly
 * @todo: Use of flock while writing
 * @todo: Write to temporary file while generating, then move? (faster)
 *
 * @package PhpGenerator
 * @copyright Copyright (C) 2005 eZ systems as. All rights reserved.
 * @license LGPL - {@link http://www.gnu.org/copyleft/lesser.html Online version}
 * @version //autogentag//
 */
class ezcPhpGenerator
{
    const EZ_PHPCREATOR_INCLUDE_ONCE =  1;
    const EZ_PHPCREATOR_INCLUDE_ALWAYS = 2;

    const EZ_PPCREATOR_METHOD_CALL_PARAMETER_VALUE = 1;
    const EZ_PHPCREATOR_METHOD_CALL_PARAMETER_VARIABLE = 2;

    private $phpDir;
    private $phpFile;
    private $fileResource;
    private $isAtomic;
    private $tmpFilename;
    private $requestedFilename;

    // options
    private $indent = "  ";
    private $spacing = true;

    private $indentLevel;

    /**
     * Constructs a new PhpGenrator generator.
     *
     * The generated PHP code will be saved to $resultUri
     * @param string $resultURI
     * @param array $options
     * @throws PhpGeneratorException If the file can not be opened writing.
     */
    public function __construct( $resultUri, $options = array() )
    {
    }

    /**
     * Inserts a new define statement to the code with the name \a $name and value \a $value.
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
    public function appendDefine( $name, $value, $caseSensitive = true )
    {
    }

    /**
     * Inserts a new raw variable to the code with the name $name and value $value.
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
    public function appendRawVariable( $name, $value )
    {
    }

    /**
     * Inserts a new variable to the code with the name \a $name and value \a $value.
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
     * @param $parameters Optional parameters, can be any of the following:
     *            - \a full-tree, Whether to displays array values as one large expression (\c true) or
     *                            split it up into multiple variables (\c false)
     *
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendVariable( $name, $value, $assignmentType = EZ_PHPCREATOR_VARIABLE_ASSIGNMENT,
                          $parameters = array() )
    {
    }

    /**
     * Inserts code to unset a variable with the name \a $name.
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
    public function appendVariableUnset( $name )
    {
    }

    /**
     * Inserts code to unset a list of variables with name from \a $list.
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
    public function appendVariableUnsetList( $list )
    {
    }

    /**
     * Inserts $lines number of empty lines to the generated PHP code.
     *
     * Example:
     * <code>
     * $php->addSpace( 1 );
     * </code>
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendSpace( $lines = 1 )
    {
    }

    /**
     * Adds a method call to the generated code.
     *
     * Adds a call to method $mehtodName to the object $objectName and parameters $methodParametes.
     * You can catch the return value with the $returnValue parameter.
     *
     * @todo The way of changing behavior for the parameters and return type is somewhat
     * weird. Change this to something sane.
     * $methodParameters should be an array with parameter entries where each entry contains:
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
     * array( array( 'node' ), array( 'name' ) ) );
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * $name = $node->name();
     * $php->addMethodCall( 'node', 'name' );
     * </code>
     *
     * @param string $objectName
     * @param string $methodName
     * @param array $methodParameters
     * @param array $returnValue
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendMethodCall( $objectName, $methodName, $methodParameters, $returnValue = false )
    {
    }

    /**
     * Inserts a custom piece of code into the generated code.
     *
     * The code $code will be inserted directly into the generated code
     * except for added spacing. If your code does not end with a linebreak
     * it is added automatically. You should only use this a last resort if any of the other
     * \em add functions done give you the required result.
     *
     * Example:
     * <code>
     * $php->addCodePiece( "if ( \$value > 2 )\n{\n    \$value = 2;\n}\n" );
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * if ( $value > 2 )
     * {
     *   $value = 2;
     * }
     * </code>
     *
     * @param string $code
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendCodePiece( $code )
    {
    }

    /**
     * Inserts a comment into the code.
     *
     * The comment will be display using multiple end-of-line
     * comments (//), one for each newline in the $comment. A newline
     * will automatically be generated after the last comment.
     *
     * Example:
     * <code>
     * $php->addComment( "This file is auto generated\nDo not edit!" );
     * <code>
     *
     * Produces the PHP code:
     *
     * <code>
     * // This file is auto generated
     * // Do not edit!
     * <code>
     *
     * @param string $comment
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendComment( $comment)
    {
    }

    /**
     * Adds an include statement to $file.
     *
     * Example:
     * <code>
     * $php->addInclude( 'lib/ezutils/classes/ezphpcreator.php' );
     * <code>
     *
     * Produces the PHP code:
     *
     * <code>
     * include_once( 'lib/ezutils/classes/ezphpcreator.php' );
     * </code>
     * @param string $file
     * @param string $type EZ_PHPCREATOR_INCLUDE_ONCE | EZ_PHPCREATOR_INCLUDE_ALWAYS
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    function appendInclude( $file, $type = EZ_PHPCREATOR_INCLUDE_ONCE )
    {
    }

    /**
     * Adds the start of an if statement.
     *
     * The complete condition of the if statement must be present in $condition.
     * The if statement must be closed properly with a call to appendEndIf.
     * Example:
     * <code>
     * $php->appendIf( 'if( $myVar === 0 )' );
     * $php->appendEndIf();
     * </code>
     *
     * Produces the PHP code:
     *
     * <code>
     * if( $myVar === 0 )
     * {
     * }
     * </code>
     *
     * @see $ezcPhpGenerator::appendEndIf()
     * @param string $condition
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code.
     */
    public function appendIf( $condition ) {}

    /**
     * Ends an if statement.
     *
     * @see $ezcPhpGenerator::appendIf()
     * @return void
     * @throws PhpGeneratorException if it was not possible to write the code or if the method was not properly nested with an appendIf.
     */
    public function appendEndIf() {}
    public function appendElse( $condition = false ) {}
    public function appendForeach( $condition ) {}
    public function appendEndForeach(){}
    public function appendWhile( $condition ) {}
    public function appendEndWhile(){}
    public function appendDo( $condition ) {}
    public function appendEndDo(){}

    /**
     * Returns a variable statement with an assignment type.
          \param $variableName The name of the variable
     * @param array $assignmentType Controls the way the value is assigned, choose one of the following:
     *            - \b EZ_PHPCREATOR_VARIABLE_ASSIGNMENT, assign using \c = (default)
     *            - \b EZ_PHPCREATOR_VARIABLE_APPEND_TEXT, append using text concat operator \c .
     *            - \b EZ_PHPCREATOR_VARIABLE_APPEND_ELEMENT, append element to array using append operator \c []
     * @param array $variableParameters Optional parameters for the statement
            - \a is-reference, whether to do the assignment with reference or not (default is not)
     * @return string
    */
    private static function variableNameText( $variableName, $assignmentType, $variableParameters = array() )
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


    /**
     * Returns the $text split by $splitString
     *
     * For each line it will prepend the string \a $spacingString n times as specified by \a $spacing.
     *
     * It will try to be smart and not do anything when \a $spacing is set to \c 0.
     *
     * @param string $text
     * @param string $spacing
     * @param boolean $skipEmptyLines If \c true it will not prepend the string for empty lines.
     * @param $spacing Must be a positive number, \c 0 means to not prepend anything.
     * @return array
     */
    private static function prependSpacing( $text, $spacing, $skipEmptyLines = true, $spacingString = "  ", $splitString = "\n" )
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
    private function open()
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
    private function close()
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
    private function exists()
    {
        $path = $this->PHPDir . '/' . $this->PHPFile;
        return file_exists( $path );
    }



    /*!
     Stores the PHP cache, returns false if the cache file could not be created.
    */
    private function store( $atomic = false )
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
