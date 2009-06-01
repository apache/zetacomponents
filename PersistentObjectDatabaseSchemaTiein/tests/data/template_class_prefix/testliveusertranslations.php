<?php
/**
 * File containing the $className class.
 */
/**
 * testLiveuserTranslations
 *
 * @property string $description
* @property string $languageId
* @property string $name
* @property int $sectionId
* @property int $sectionType
* @property int $translationId
 */
class testLiveuserTranslations implements ezcPersistentObject
{
    /**
     * Properties.
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new testLiveuserTranslations
     * 
     * @return void
     */
    public function __construct()
    {
		
	    $this->properties['description'] = null;

	    $this->properties['languageId'] = null;

	    $this->properties['name'] = null;

	    $this->properties['sectionId'] = null;

	    $this->properties['sectionType'] = null;

	    $this->properties['translationId'] = null;
    }

    /**
     * Set properties after reading an object from the database. 
     * 
     * @param array(string=>mixed) $properties 
     * @return void
     *
     * @access private
     */
    public function setState( array $properties )
    {
        foreach ( $properties as $name => $value )
        {
            $this->properties[$name] = $value;
        }
    }

    /**
     * Returns the property values to store an object to the database.
     * 
     * @return array(string=>mixed)
     *
     * @access private
     */
    public function getState()
    {
        return $this->properties;
    }

    /**
     * Overloading to set properties.
     *
	 * @throws ezcBaseValueException
	 *         if the property value to set does no conform to type constraints.
	 * @throws ezcBasePropertyNotFoundException
	 *         if the desired property does not exist.
     * 
     * @param string $propertyName 
     * @param mixed $propertyValue 
     * @return void
	 *
	 * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName )
        {
            
			case 'description':
				if ( !is_string( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'string'
					);
				}
			break;

			case 'languageId':
				if ( !is_string( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'string'
					);
				}
			break;

			case 'name':
				if ( !is_string( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'string'
					);
				}
			break;

			case 'sectionId':
				if ( !is_int( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'int'
					);
				}
			break;

			case 'sectionType':
				if ( !is_int( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'int'
					);
				}
			break;

			case 'translationId':
				if ( !is_int( $propertyValue ) )
				{
					throw new ezcBaseValueException(
						$propertyName,
						$propertyValue,
						'int'
					);
				}
			break;

            default:
                throw new ezcBasePropertyNotFoundException(
					$propertyName,
					$propertyValue
				);
        }
        $this->properties[$propertyName] = $propertyValue;
    }

    /**
     * Overloading to get properties.
     * 
	 * @throws ezcBasePropertyNotFoundException
	 *         if the desired property does not exist.
	 *
     * @param string $propertyName 
     * @return void
	 *
	 * @ignore
     */
    public function __get( $propertyName )
    {
        if ( $this->__isset( $propertyName ) )
        {
            return $this->properties[$propertyName];
        }
        throw new ezcBasePropertyNotFoundException( $propertyName );
    }

    /**
     * Overloading for property isset() checks.
     * 
     * @param string $propertyName 
     * @return bool
	 *
	 * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }
}

?>
