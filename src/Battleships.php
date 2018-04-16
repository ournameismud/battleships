<?php
/**
 * Battleships plugin for Craft CMS 3.x
 *
 * Custom Field Type to pick x-y coordinates from an image
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\battleships;

use ournameismud\battleships\services\BattleshipsService as BattleshipsServiceService;
use ournameismud\battleships\variables\BattleshipsVariable;
use ournameismud\battleships\fields\BattleshipsField as BattleshipsFieldField;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\services\Fields;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterComponentTypesEvent;

use yii\base\Event;

/**
 * Class Battleships
 *
 * @author    @cole007
 * @package   Battleships
 * @since     0.0.1
 *
 * @property  BattleshipsServiceService $battleshipsService
 */
class Battleships extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Battleships
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '0.0.1';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = BattleshipsFieldField::class;
            }
        );

        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('battleships', BattleshipsVariable::class);
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'battleships',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
