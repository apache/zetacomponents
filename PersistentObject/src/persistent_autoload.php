<?php
/**
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 */
return array(
    'ezcPersistentSession'                              => 'PersistentObject/persistent_session.php',
    'ezcPersistentSessionInstance'                      => 'PersistentObject/persistent_session_instance.php',
    'ezcPersistentSessionNotFoundException'             => 'PersistentObject/exceptions/session_not_found.php',
    'ezcPersistentFindIterator'                         => 'PersistentObject/find_iterator.php',
    'ezcPersistentStateTransformer'                     => 'PersistentObject/internal/state_transformer.php',
    
    'ezcPersistentObjectException'                      => 'PersistentObject/exceptions/persistent_object_exception.php',
    'ezcPersistentObjectNotPersistentException'         => 'PersistentObject/exceptions/not_persistent.php',
    'ezcPersistentObjectAlreadyPersistentException'     => 'PersistentObject/exceptions/already_persistent.php',
    'ezcPersistentQueryException'                       => 'PersistentObject/exceptions/query_exception.php',
    
    'ezcPersistentIdentifierGenerator'                  => 'PersistentObject/interfaces/identifier_generator.php',
    'ezcPersistentSequenceGenerator'                    => 'PersistentObject/generators/sequence_generator.php',
    'ezcPersistentManualGenerator'                      => 'PersistentObject/generators/manual_generator.php',
    'ezcPersistentNativeGenerator'                      => 'PersistentObject/generators/native_generator.php',
    'ezcPersistentIdentifierGenerationException'        => 'PersistentObject/exceptions/identifier_generation.php',

    'ezcPersistentObjectDefinition'                     => 'PersistentObject/structs/persistent_object_definition.php',
    'ezcPersistentObjectProperty'                       => 'PersistentObject/structs/persistent_object_property.php',
    'ezcPersistentObjectIdProperty'                     => 'PersistentObject/structs/persistent_object_id_property.php',
    'ezcPersistentGeneratorDefinition'                  => 'PersistentObject/structs/generator_definition.php',
    
    'ezcPersistentRelation'                             => 'PersistentObject/interfaces/relation.php',
    'ezcPersistentOneToOneRelation'                     => 'PersistentObject/relations/one_to_one.php',
    'ezcPersistentOneToManyRelation'                    => 'PersistentObject/relations/one_to_many.php',
    'ezcPersistentManyToOneRelation'                    => 'PersistentObject/relations/many_to_one.php',
    'ezcPersistentManyToManyRelation'                   => 'PersistentObject/relations/many_to_many.php',
    'ezcPersistentSingleTableMap'                       => 'PersistentObject/structs/single_table_map.php',
    'ezcPersistentDoubleTableMap'                       => 'PersistentObject/structs/double_table_map.php',
    'ezcPersistentRelationNotFoundException'            => 'PersistentObject/exceptions/relation_not_found.php',
    'ezcPersistentRelationInvalidException'            => 'PersistentObject/exceptions/relation_invalid.php',
    'ezcPersistentRelationOperationNotSupportedException' => 'PersistentObject/exceptions/relation_operation_not_supported.php',
    'ezcPersistentRelatedObjectNotFoundException'       => 'PersistentObject/exceptions/related_object_not_found.php',

    'ezcPersistentDefinitionManager'                    => 'PersistentObject/interfaces/definition_manager.php',
    'ezcPersistentMultiManager'                         => 'PersistentObject/managers/multi_manager.php',
    'ezcPersistentCodeManager'                          => 'PersistentObject/managers/code_manager.php',
    'ezcPersistentDefinitionNotFoundException'          => 'PersistentObject/exceptions/definition_not_found.php',
    'ezcPersistentDefinitionMissingIdPropertyException' => 'PersistentObject/exceptions/definition_missing_id_property.php',
);
?>
