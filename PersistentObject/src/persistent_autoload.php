<?php
/**
 * Autoloader definition for the PersistentObject component.
 *
 * @copyright Copyright (C) 2005-2009 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package PersistentObject
 */

return array(
    'ezcPersistentObjectException'                        => 'PersistentObject/exceptions/persistent_object_exception.php',
    'ezcPersistentDefinitionMissingIdPropertyException'   => 'PersistentObject/exceptions/definition_missing_id_property.php',
    'ezcPersistentDefinitionNotFoundException'            => 'PersistentObject/exceptions/definition_not_found.php',
    'ezcPersistentIdentifierGenerationException'          => 'PersistentObject/exceptions/identifier_generation.php',
    'ezcPersistentInvalidObjectStateException'            => 'PersistentObject/exceptions/invalid_object_state.php',
    'ezcPersistentObjectAlreadyPersistentException'       => 'PersistentObject/exceptions/already_persistent.php',
    'ezcPersistentObjectNotPersistentException'           => 'PersistentObject/exceptions/not_persistent.php',
    'ezcPersistentQueryException'                         => 'PersistentObject/exceptions/query_exception.php',
    'ezcPersistentRelatedObjectNotFoundException'         => 'PersistentObject/exceptions/related_object_not_found.php',
    'ezcPersistentRelationInvalidException'               => 'PersistentObject/exceptions/relation_invalid.php',
    'ezcPersistentRelationNotFoundException'              => 'PersistentObject/exceptions/relation_not_found.php',
    'ezcPersistentRelationOperationNotSupportedException' => 'PersistentObject/exceptions/relation_operation_not_supported.php',
    'ezcPersistentSessionNotFoundException'               => 'PersistentObject/exceptions/session_not_found.php',
    'ezcPersistentUndeterministicRelationException'       => 'PersistentObject/exceptions/undeterministic_relation.php',
    'ezcPersistentDefinitionManager'                      => 'PersistentObject/interfaces/definition_manager.php',
    'ezcPersistentIdentifierGenerator'                    => 'PersistentObject/interfaces/identifier_generator.php',
    'ezcPersistentPropertyConverter'                      => 'PersistentObject/interfaces/property_converter.php',
    'ezcPersistentRelation'                               => 'PersistentObject/interfaces/relation.php',
    'ezcPersistentSessionHandler'                         => 'PersistentObject/interfaces/handler.php',
    'ezcPersistentCacheManager'                           => 'PersistentObject/managers/cache_manager.php',
    'ezcPersistentCodeManager'                            => 'PersistentObject/managers/code_manager.php',
    'ezcPersistentDeleteHandler'                          => 'PersistentObject/handlers/delete_handler.php',
    'ezcPersistentDoubleTableMap'                         => 'PersistentObject/structs/double_table_map.php',
    'ezcPersistentFindIterator'                           => 'PersistentObject/find_iterator.php',
    'ezcPersistentFindQuery'                              => 'PersistentObject/queries/find_query.php',
    'ezcPersistentGeneratorDefinition'                    => 'PersistentObject/structs/generator_definition.php',
    'ezcPersistentIdentity'                               => 'PersistentObject/structs/identity.php',
    'ezcPersistentLoadHandler'                            => 'PersistentObject/handlers/load_handler.php',
    'ezcPersistentManualGenerator'                        => 'PersistentObject/generators/manual_generator.php',
    'ezcPersistentManyToManyRelation'                     => 'PersistentObject/relations/many_to_many.php',
    'ezcPersistentManyToOneRelation'                      => 'PersistentObject/relations/many_to_one.php',
    'ezcPersistentMultiManager'                           => 'PersistentObject/managers/multi_manager.php',
    'ezcPersistentNativeGenerator'                        => 'PersistentObject/generators/native_generator.php',
    'ezcPersistentObject'                                 => 'PersistentObject/interfaces/persistent_object.php',
    'ezcPersistentObjectColumns'                          => 'PersistentObject/object/persistent_object_columns.php',
    'ezcPersistentObjectDefinition'                       => 'PersistentObject/object/persistent_object_definition.php',
    'ezcPersistentObjectIdProperty'                       => 'PersistentObject/object/persistent_object_id_property.php',
    'ezcPersistentObjectProperties'                       => 'PersistentObject/object/persistent_object_properties.php',
    'ezcPersistentObjectProperty'                         => 'PersistentObject/object/persistent_object_property.php',
    'ezcPersistentObjectRelations'                        => 'PersistentObject/object/persistent_object_relations.php',
    'ezcPersistentOneToManyRelation'                      => 'PersistentObject/relations/one_to_many.php',
    'ezcPersistentOneToOneRelation'                       => 'PersistentObject/relations/one_to_one.php',
    'ezcPersistentPropertyDateTimeConverter'              => 'PersistentObject/object/property_converters/date.php',
    'ezcPersistentRelationCollection'                     => 'PersistentObject/object/relation_collection.php',
    'ezcPersistentSaveHandler'                            => 'PersistentObject/handlers/save_handler.php',
    'ezcPersistentSequenceGenerator'                      => 'PersistentObject/generators/sequence_generator.php',
    'ezcPersistentSession'                                => 'PersistentObject/persistent_session.php',
    'ezcPersistentSessionInstance'                        => 'PersistentObject/persistent_session_instance.php',
    'ezcPersistentSingleTableMap'                         => 'PersistentObject/structs/single_table_map.php',
    'ezcPersistentStateTransformer'                       => 'PersistentObject/internal/state_transformer.php',
);
?>
