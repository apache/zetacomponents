<?php
/**
 * @licence New BSD like
 * @donotdocument
 * @testclass
 * @ignore
 */
class SomeClass extends BaseClass implements IInterface {
    /**
     * @var int[] An array of integers
     */
    private $fields;

    /**
     * @var SomeClass
     */
    public $publicProperty;
    
    protected $undocumentedProperty;

    const CLASS_CONSTANT = 'ConstantValue';
    
    public static $staticProperty = 'StaticValue';

    public function __construct() {
        // echo "New SomeClass instance created.\n";
    }

    public function helloWorld()
    {
        return true;
    }
}
?>
