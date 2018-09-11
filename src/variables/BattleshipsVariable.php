<?php
/**
 * Battleships plugin for Craft CMS 3.x
 *
 * Custom Field Type to pick x-y coordinates from an image
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\battleships\variables;

use ournameismud\battleships\Battleships;

use Craft;

/**
 * @author    @cole007
 * @package   Battleships
 * @since     0.0.1
 */
class BattleshipsVariable
{
    // Public Methods
    // =========================================================================

    /**
     * @param null $optional
     * @return string
     */
    public function exampleVariable($optional = null)
    {
        $result = "And away we go to the Twig template...";
        if ($optional) {
            $result = "I'm feeling optional today...";
        }
        return $result;
    }
}
