<?php
/**
 * Battleships plugin for Craft CMS 3.x
 *
 * Custom Field Type to pick x-y coordinates from an image
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\battleships\assetbundles\battleshipsfieldfield;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    @cole007
 * @package   Battleships
 * @since     0.0.1
 */
class BattleshipsFieldFieldAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@ournameismud/battleships/assetbundles/battleshipsfieldfield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/jquery.modal.min.js',
            'js/BattleshipsField.js',
        ];

        $this->css = [
            'css/jquery.modal.min.css',
            'css/BattleshipsField.css',
        ];

        parent::init();
    }
}
