<?php

class MyReflectionClass extends ReflectionClass {

	public function doSomeMetaProgramming()
	{
		return true;
	}

	public function change() {
		return true;
	}

	public function getConstructor() {
	    $constructor = parent::getConstructor();
	    if ( $constructor != null ) {
	        return new MyReflectionMethod( $this->getName(), $constructor->getName() );
	    } else {
	        return $constructor;
	    }
	}

    public function getMethod($name) {
    	return new MyReflectionMethod($this->getName(), $name);
    }

    public function getMethods($filter = -1) {
    	$methods = parent::getMethods($filter);

    	$result = array();
    	foreach ($methods as $method) {
    		$result[] = new MyReflectionMethod($this->getName(), $method->getName());
    	}
    	return $result;
    }

    public function getProperty($name) {
    	return new MyReflectionProperty($this->getName(), $name);
    }

	public function getProperties($filter = -1) {
    	$props = parent::getProperties($filter);

    	$result = array();
    	foreach ($props as $prop) {
    		$result[] = new MyReflectionProperty($this->getName(), $prop->getName());
    	}
    	return $result;
    }

	public function getInterfaces() {
    	$ifaces = parent::getInterfaceNames();

    	$result = array();
    	foreach ($ifaces as $iface) {
    		$result[] = new MyReflectionClass($iface);
    	}
    	return $result;
    }

    public function getParentClass() {
    	$parent = parent::getParentClass();
    	if ( $parent == null ) {
    		return null;
    	} else {
    		return new MyReflectionClass($parent->getName());
    	}
    }

    public function getExtension() {
    	$extName =  parent::getExtensionName();
    	if ($extName) {
    		return new MyReflectionExtension($extName);
    	} else {
    		return NULL;
    	}
    }
}

?>