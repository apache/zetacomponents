<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "ce_message_category_rel";
$def->class = "CeMessageCategoryRel";



$def->properties['categoryId'] = new ezcPersistentObjectProperty;
$def->properties['categoryId']->columnName = 'category_id';
$def->properties['categoryId']->propertyName = 'categoryId';
$def->properties['categoryId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

$def->properties['isShadow'] = new ezcPersistentObjectProperty;
$def->properties['isShadow']->columnName = 'is_shadow';
$def->properties['isShadow']->propertyName = 'isShadow';
$def->properties['isShadow']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_BOOL;

$def->properties['messageId'] = new ezcPersistentObjectProperty;
$def->properties['messageId']->columnName = 'message_id';
$def->properties['messageId']->propertyName = 'messageId';
$def->properties['messageId']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_INT;

return $def;

?>
