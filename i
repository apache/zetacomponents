<?php
/**
 * File containing class dzModel.
 * 
 * @package Form
 * @version //autogen//
 * @copyright Copyright (C) 2008 James Pic. All rights reserved.
 * @author James Pic <jamespic@gmail.com> 
 * @license http://ez.no/licenses/new_bsd New BSD License
 */
/**
 * Defining a model, you don't *need* __toString() but its too sexy to miss it:
 * <code>
 * <?php
 * class yourAuthor extends dzModel
 * {
 *     public function createFields()
 *     {
 *         $this['name'] = new dzModelCharField();
 *     }
 *
 *     public function __toString()
 *     {
 *         return $this->name;
 *     }
 * }
 * class yourBook extends dzModel
 * {
 *     public function createFields()
 *     {
 *         $this['title'] = new dzModelCharField();
 *         $this['author'] = new dzModelForeignKey( 'yourAuthor' );
 *     }
 *
 *     public function __toString()
 *     {
 *         return $this->title . " by " . $this->author;
 *     }
 * }
 * ?>
 * </code>
 * 
 * You are now able to do some basic stuff:
 * <code>
 * // create a new author with values
 * $james = new yourAuthor();
 * $james->name = 'James Pic';
 * // Save it
 * $james->save();
 *
 * // Get a queryset from it
 * $qs = $james->getQuerySet();
 * // The query set wraps around a select query and the session
 * // It's filterable and lazy ...
 *
 * $book = new yourBook();
 * $book->title = "Rapid and agile developpement with PHP 101";
 * // Set the author of the book
 * $book->author = $james;
 * $book->save();
 *
 * (string) $book; // = 'yourBook #1', overload __toString().
 * </code>
 *
 * That was quite sexy but not enough: how to implement 'syncdb'?
 *
 * <code>
 * $poDef = array();
 * $poDef[] = dzModel::getPoDef( 'yourBook' );
 * $poDef[] = dzModel::getPoDef( 'yourAuthor' );
 * $dbSchema = dzModel::createSchema();
 * </code>
 *
 * @package Form
 * @version //autogen//
 */
abstract class dzModel extends ArrayObject
{
    /**
     * List of fields, decorated by ArrayObject.
     * 
     * @var array
     */
    public $fields = array();

    /**
     * Model instance class name.
     *
     * @var string
     */
    public $class = null;


    /**
     * Options list
     * 
     * @var array
     */
    protected $options = array();

    /**
     * list of persistent object definitions
     */
    static private $poDefs = array();

    /**
     * Returns the unique name of the model.
     * 
     * @return string
     */
    public function __toString()
    {
        $id = $this->getIdPropertyName();
        return $this->class . ' #' . $this->$id;
    }

    /**
     * Adds a field to the model, and set the field's model class name.
     * 
     * @param mixed $name Void
     * @param dzModelField $field Field to add.
     * @return void
     */
    public function offsetSet( $name, $field )
    {
        if ( !$field instanceof dzModelField )
        {
            throw new ezcBaseValueException( 'field', $field, 'instance of dzModelField', 'value' );
        }

        // As promised, setUp for you
        $field->setup( $name, $this->class );

        parent::offsetSet( $field->name, $field );
    }

    /**
     * Invokes a new dzModel.
     * 
     * @param mixed $class Class name of the model.
     * @param mixed $values Values of the fields of the model.
     * @return void
     */
    public function __construct( $class, array $values = array() )
    {
        parent::__construct( $this->fields );

        $this->class = $class;
        $this->createFields();

        foreach( $values as $name => $value )
        {
            $this->$name = $value;
        }

        $this->setUp();
    }

    /**
     * Sets up the options. Checks if any field has option idProperty, or create one.
     * 
     * @return void
     */
    public function setUp()
    {
        $this->dbTableName    = strtolower( $this->class ) . 's';
        $this->idColumnName   = 'id';
        $this->idPropertyName = 'id';

        foreach( $this as $field )
        {
            if ( $field->idProperty )
            {
                return;
            }
        }
        $this[$this->idPropertyName] = new dzModelIntegerField( array( 'idProperty' => true, 'autoIncrement' => true ) );
    }

    /**
     * Returns the value of property $name.
     * 
     * @param mixed $name Name of the property to get.
     * @return void
     */
    public function __get( $name )
    {
        switch( $name )
        {
            case 'valid':
                return $this->isValid();
            case 'poDef':
                if ( !isset( $this->poDef ) )
                {
                    $this->options['poDef'] = $this->createPoDef();
                }
                return $this->options['poDef'];
            case 'dbDef':
                if ( !isset( $this->dbDef ) )
                {
                    $this->options['dbDef'] = $this->createDbDef();
                }
                return $this->options['dbDef'];
            case 'schemaDef':
                if ( !isset( $this->schemaDef ) )
                {
                    $this->options['schemaDef'] = $this->createSchemaDef();
                }
                return $this->options['schemaDef'];
            default:
                if ( isset( $this[$name] ) )
                {
                    return $this[$name]->value;
                }
                else
                {
                    return $this->options[$name];
                }
        }
    }

    /**
     * Set the value of a property.
     * 
     * @param mixed $name Name of the property to set.
     * @param mixed $value Value to set.
     * @return void
     */
    public function __set( $name, $value )
    {
        if ( isset( $this[$name] ) )
        {
            $this[$name]->value = $value;
        }
        else
        {
            $this->options[$name] = $value;
        }
    }

    /**
     * Return true if one or all fields are valid.
     * 
     * @param string|null $field Field name to check.
     * @return bool
     */
    public function isValid( $field = null )
    {
        if ( is_string( $field ) )
        {
            if ( !$this->offsetExists( $field ) )
            {
                throw new Exception( "Field not found: $field" );
            }
            return $this[$field]->valid;
        }
        else
        {
            foreach( $this as $name => $field )
            {
                if ( !$field->valid )
                {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * Sanitizes one or all fields.
     * 
     * @param string|null $field Field name.
     * @return void
     */
    public function clean( $field = null )
    {
        if ( is_string( $field ) )
        {
            return $this[$field]->clean();
        }

        foreach( $this as $name => $field )
        {
            $field->clean();
        }
    }

    /**
     * Returns a valid state for ezcPersistentSession.
     * 
     * @return array
     */
    public function getState()
    {
        $state = array();

        // @TODO: throw an exception when getting invalid state?

        foreach( $this as $name => $field )
        {
            $state[$field->columnName] = $field->getDbValue();
        }

        return $state;
    }

    /**
     * Set the model in a state, for ezcPersistentSession.
     * 
     * @param mixed $state 
     * @return void
     */
    public function setState( $state )
    {
        foreach( $this as $name => $field )
        {
            if ( array_key_exists( $field->columnName, $state ) )
                $field->value = $state[$field->columnName];
            elseif ( array_key_exists( $field->propertyName, $state ) )
                $field->value = $state[$field->propertyName];
        }
    }

    /**
     * Create and return the persistent object definition.
     *
     * Note: it is then stored in self::$poDefs[$this->class].
     * 
     * Overload:
     * - overload setUpPoIdProperty(),
     * - for non-id properties, overload setUpPoDef().
     * 
     * @return void
     */
    public function createPoDef()
    {
        if ( !array_key_exists( $this->class, self::$poDefs ) )
        {
            $def = self::$poDefs[$this->class] = new ezcPersistentObjectDefinition();
            $def->table = $this->dbTableName;
            $def->class = $this->class;
            $this->alterPoDef( $def );
        }

        // Just in case
        $def = self::$poDefs[$this->class];

        foreach( $this as $name => $field )
        {
            if ( $field->idProperty )
            {
                $def->idProperty = $field->poDef;
            }
            else
            {
                $def->properties[$field->columnName] = $field->poDef;
            }
            $field->alterPoDef( $def );
        }

        return self::$poDefs[$this->class];
    }

    /**
     * Returns the persistent object definition for a model.
     * 
     * @param mixed $class Class name of the model.
     * @return ezcPersistentObjectDefinition
     */
    static public function getPoDef( $class )
    {
        if ( !array_key_exists( $class, self::$poDefs ) )
        {
            $model = new $class;
            self::$poDefs[$class] = $model->createPoDef();
        }

        return self::$poDefs[$class];
    }

    /**
     * Alter the persistent object definition.
     * 
     * @return void
     */
    public function alterPoDef()
    {
    }

    /**
     * Returns the delete url for the model.
     * 
     * @param mixed $id Id of the model.
     * @return string
     */
    public function getDeleteUrl( $id = null )
    {
        if ( is_null( $id ) )
        {
            $idProperty = $this->idProperty;
            $id = $this->$idProperty;
        }
        return '/admin/delete/' . $this->class . '/' . $id;
    }

    /**
     * Returns true if a user has delete permission on this model.
     * 
     * @param mixed $user 
     * @return bool
     */
    public function hasDeletePermission( $user )
    {
        return true;
    }

    /**
     * Returns the update url for the model.
     * 
     * @param mixed $id Id of the model.
     * @return string
     */
    public function getUpdateUrl( $id = null )
    {
        if ( is_null( $id ) )
        {
            $idProperty = $this->idProperty;
            $id = $this->$idProperty;
        }
        return '/admin/update/' . $this->class . '/' . $id;
    }

    /**
     * Returns true if a user has update permission on this model.
     * 
     * @param mixed $user 
     * @return bool
     */
    public function hasUpdatePermission( $user )
    {
        return true;
    }

    /**
     * Returns the create url for the model.
     * 
     * @return string
     */
    public function getCreateUrl()
    {
        return '/admin/create/' . $this->class;
    }

    /**
     * Return true if $user can create a model of this class.
     * 
     * @param mixed $user User to test
     * @return bool
     */
    public function hasCreatePermission( $user )
    {
        return true;
    }

    /**
     * Returns the url to list models.
     * 
     * @return string
     */
    public function getListUrl()
    {
        return '/admin/list/' . $this->class;
    }

    /**
     * Returns the url to read a model.
     * 
     * @param mixed $id Id of the model.
     * @return string
     */
    public function getReadUrl( $id )
    {
        return '/admin/read/' . $this->class . '/' . $id;
    }

    /**
     * Returns a dzModelQuerySet for this model.
     * 
     * @return dzModelQuerySet
     */
    public function getQuerySet()
    {
        $session = ezcPersistentSessionInstance::get();
        $q = $session->createFindQuery( $this->class );
        $qs = new QuerySet( $q, $this->class, $session );
        return $qs;
    }

    /**
     * Creates the ezcDbSchema for the models.
     * 
     * @param array $models 
     * @return ezcDbSchema
     */
    static public function createSchema( array $models = array() )
    {
        $s = array();
        foreach( $models as $model )
        {
            $model = new $model;
            $table = $model->dbTableName;
            $s[$table] = new ezcDbSchemaTable(
                array(
                    $model->idPropertyName => new ezcDbSchemaField( 'integer', false, true, null, true ),
                ),
                array(
                    'primary' => new ezcDbSchemaIndex( array( 'id', new ezcDbSchemaIndexField( ) ), true ),
                )
            );
            foreach( $model as $name => $field )
            {
                $s[$table]->fields[$field->columnName] = $field->createDbDef();
                $field->alterDbDef( $s, $table );
            }
        }

        return $s;
    }

    // Coupled with dzModelForeignKey
    public function save( $recursive = true)
    {
        $saved = array(  );
        $this->saveObject( $saved, $this );

        if ( $recursive )
        {
            foreach( $this as $field )
            {
                if ( $field instanceof dzModelForeignKey )
                {
                    var_dump( $field->value );
                    if ( is_null( $field->value ) )
                    {
                        continue;
                    }
                    $this->saveObject( $saved, $field->value );
                    $session->addRelatedObject( $field->value, $this );
                    print 'added related object' . "\n";
                }
            }
        }
    }

    private function saveObject( &$saved, $object )
    {
        if ( in_array( $object, $saved ) )
        {
            return;
        }
        $session = ezcPersistentSessionInstance::get();
        $session->save( $object );
        $saved[] = $object;
    }
}
