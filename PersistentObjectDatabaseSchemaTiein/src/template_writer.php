<?php
/**
 * File containing the ezcPersistentObjectTemplateSchemaWriter class.
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
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 */

/**
 * Writer to generate PersistentObject class/definition files.
 *
 * This class is used in ezcPersistentObjectSchemaGenerator to generate
 * PersistentObject class and definition files based on templates.
 *
 * @package PersistentObjectDatabaseSchemaTiein
 * @version //autogentag//
 */
class ezcPersistentObjectTemplateSchemaWriter
{

    /**
     * Properties. 
     * 
     * @var array(string=>mixed)
     */
    protected $properties = array();

    /**
     * Creates a new writer instance.
     *
     * @param ezcPersistentObjectTemplateSchemaWriterOptions $options
     */
    public function __construct( ezcPersistentObjectTemplateSchemaWriterOptions $options = null )
    {
        if ( $options === null )
        {
            $options = new ezcPersistentObjectTemplateSchemaWriterOptions();
        }

        $this->properties['options'] = $options;

        $tplConf = ezcTemplateConfiguration::getInstance();
        $tplConf->addExtension( 'ezcPersistentObjectSchemaTemplateFunctions' );
    }

    /**
     * Writes the given $schema to $dir using $template.
     *
     * Iterates through all tables in $schema, sends each of them to a {@link
     * ezcTemplate} with $template and writes the result to $dir with the file
     * name returned by the template.
     * 
     * @param ezcDbSchema $schema 
     * @param string $template
     * @param mixed $dir 
     */
    public function write( ezcDbSchema $schema, $template, $dir )
    {
        $tplConf = ezcTemplateConfiguration::getInstance();

        $tplConf->templatePath = $this->properties['options']->templatePath;
        $tplConf->compilePath  = $this->properties['options']->templateCompilePath;

        $tpl                    = new ezcTemplate();
        $tpl->send->classPrefix = $this->properties['options']->classPrefix;

        foreach ( $schema->getSchema() as $tableName => $tableSchema )
        {
            $tpl->send->schema    = $tableSchema;
            $tpl->send->tableName = $tableName;

            $content  = $tpl->process( $template );
            $fileName = $dir . '/' . $tpl->receive->fileName;

            if ( !$this->properties['options']->overwrite && file_exists( $fileName ) )
            {
                throw new ezcPersistentObjectSchemaOverwriteException(
                    $fileName
                );
            }

            file_put_contents(
                $fileName,
                $content
            );

        }
    }

    /**
     * Property read access.
     *
     * @throws ezcBasePropertyNotFoundException 
     *         If the the desired property is not found.
     * 
     * @param string $propertyName Name of the property.
     * @return mixed Value of the property or null.
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
     * Property write access.
     * 
     * @param string $propertyName Name of the property.
     * @param mixed $propertyValue  The value for the property.
     *
     * @throws ezcBaseValueException 
     *         If a the value for the property options is not an instance of 
     *         ezcConsoleOutputOptions. 
     * @throws ezcBaseValueException 
     *         If a the value for the property formats is not an instance of 
     *         ezcConsoleOutputFormats. 
     * @ignore
     */
    public function __set( $propertyName, $propertyValue )
    {
        switch ( $propertyName ) 
        {
            case 'options':
                if ( !( $propertyValue instanceof ezcPersistentObjectTemplateSchemaWriterOptions ) )
                {
                    throw new ezcBaseValueException(
                        $propertyName,
                        $propertyValue,
                        'ezcPersistentObjectTemplateSchemaWriterOptions'
                    );
                }
                break;
            default:
                throw new ezcBasePropertyNotFoundException( $propertyName );
        }
        $this->properties[$propertyName] = $propertyValue;
    }
 
    /**
     * Property isset access.
     * 
     * @param string $propertyName Name of the property.
     * @return bool True is the property is set, otherwise false.
     * @ignore
     */
    public function __isset( $propertyName )
    {
        return array_key_exists( $propertyName, $this->properties );
    }

}
?>
