<?php
/**
 * @copyright Copyright (C) 2005, 2006 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @version //autogentag//
 * @filesource
 * @package Configuration
 */

/**
 * A container to store one INI settings item
 *
 * This struct is used in various classes to store the data accompanying one
 * INI setting.
 *
 * @package Configuration
 */
class ezcConfigurationIniItem extends ezcBaseStruct
{
    /**
     * The Configuration item is a setting.
     *
     * @var int
     */
    const SETTING = 1;

    /**
     * The Configuration item is a group..
     *
     * @var int
     */
    const GROUP_HEADER = 2;

    /**
     * The item type.
     *
     * Either SETTING or GROUP_HEADER.
     *
     * @var int
     */
    public $type;

    /**
     * The name of the group this setting belongs to.
     *
     * @var string
     */
    public $group;

    /**
     * The name of the setting or the group.
     *
     * @var string
     */
    public $setting;

    /**
     * The dimensions of the setting.
     *
     * @var string
     */
    public $dimensions;

    /**
     * Comments that belong to this setting.
     *
     * @var string
     */
    public $comments;

    /**
     * The setting's value.
     *
     * @var mixed
     */
    public $value;

    /**
     * Constructs an ezcConfigurationIniItem object.
     *
     * @param int $type Either SETTING or GROUP_HEADER
     * @param string $group
     * @param string $setting
     * @param string $dimensions
     * @param string $comments
     * @param mixed $value
     */
    function __construct( $type, $group, $setting, $dimensions, $comments, $value )
    {
        $this->type = $type;
        $this->group = $group;
        $this->setting = $setting;
        $this->dimensions = $dimensions;
        $this->comments = $comments;
        $this->value = $value;
    }

    static public function __set_state( array $array )
    {
        return new ezcConfigurationIniItem(
            $array['type'], $array['group'], $array['setting'],
            $array['dimensions'], $array['comments'], $array['value']
        );
    }
}
?>
