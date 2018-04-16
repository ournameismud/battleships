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
use craft\elements\Asset;

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
    public function getPos( $object )
    {
        $result = array();
        $result['asset'] = Craft::$app->assets->getAssetById( $object['asset'][0] );  
        $rows = array();
        foreach ($object['xy'] AS $row) {
            $tmpRow['label'] = $row[0];
            $tmpRow['x'] = $row[1];
            $tmpRow['y'] = $row[2];
            $rows[] = $tmpRow;
        }
        $result['rows'] = $rows;
        return $result;
    }
}
