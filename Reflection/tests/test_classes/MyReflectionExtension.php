<?php
class MyReflectionExtension extends ReflectionExtension {

	public function getFunctions() {
    	$functs = parent::getFunctions();

    	$result = array();
        foreach ($functs as $func) {
        	$result[] = new MyReflectionFunction($func->getName());
        }
        return $result;
    }

    public function getClasses() {
       	$classes = parent::getClasses();

       	$result = array();
        foreach ($classes as $class) {
        	$result[] = new MyReflectionClass($class->getName());
        }
        return $result;
    }

	public function change() {
		return true;
	}
}
?>