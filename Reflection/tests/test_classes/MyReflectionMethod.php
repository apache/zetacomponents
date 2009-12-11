<?php
class MyReflectionMethod extends ReflectionMethod {
    
    public function doSomeMetaProgramming()
    {
		return true;
	}
    
    public function change() {
		return true;
	}

	public function getDeclaringClass() {
		return new MyReflectionClass(parent::getDeclaringClass()->getName());
	}

	/*
    public function getParameters() {
    	$params = parent::getParameters();

    	$result = array();
    	foreach ($params as $param) {
    		$result[] = new MyReflectionParameter( $this->getName(), $param->getName() );
    	}
    	return $result;
    }
    */
    
}
?>