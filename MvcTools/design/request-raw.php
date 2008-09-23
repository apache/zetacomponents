<?php
/**
 * Class that is the parent class for all protocol-dependent raw request
 * objects.
 *
 * @package MvcTools
 * @version //autogentag//
 */
abstract class ezcMvcRawRequest extends ezcBaseStruct
{
    /**
     * Contains filter-specific data that can be added, modified and
     * removed by filters on the-fly.
     *
     * @var array(string=>mixed)
     */
    public $filterData;
}
?>
