<?php
/**
 * Created by PhpStorm.
 * User: gero
 * Date: 05.03.18
 * Time: 15:30
 */

namespace Iways\HomePage\Model\Config\Homepage;

use Iways\Base\Model\Config\Source;


class TextPositionOptions extends Source
{
    const NONE = 'no-text';
    const UP_LEFT = 'top-left';
    const UP_RIGHT = 'top-right';
    const BOTTOM_LEFT = 'bottom-left';
    const BOTTOM_RIGHT = 'bottom-right';
    const MIDDLE = 'middle';

    public function toArray()
    {
        return [
            self::NONE => __("no Text"),
            self::UP_LEFT=> __("top left"),
            self::UP_RIGHT => __("top right"),
            self::BOTTOM_LEFT=> __("bottom left"),
            self::BOTTOM_RIGHT => __("bottom right"),
            self::MIDDLE => __("middle"),
        ];
    }
}