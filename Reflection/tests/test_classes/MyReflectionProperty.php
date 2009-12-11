<?php
class MyReflectionProperty extends ReflectionProperty {
	public function change() {
		return true;
	}

	public function getDeclaringClass() {
		return new MyReflectionClass(parent::getDeclaringClass()->getName());
	}
}
?>