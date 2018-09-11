<?php
/**
 * Battleships plugin for Craft CMS 3.x
 *
 * Custom Field Type to pick x-y coordinates from an image
 *
 * @link      http://ournameismud.co.uk/
 * @copyright Copyright (c) 2018 @cole007
 */

namespace ournameismud\battleships\fields;

use ournameismud\battleships\Battleships;
use ournameismud\battleships\assetbundles\battleshipsfieldfield\BattleshipsFieldFieldAsset;

use Craft;
use craft\base\ElementInterface;
use craft\base\Volume;
use craft\elements\Asset;
use craft\base\Field;
use craft\helpers\Db;
use yii\db\Schema;
use craft\helpers\Json;

/**
 * @author    @cole007
 * @package   Battleships
 * @since     0.0.1
 */
class BattleshipsField extends Field
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $assetSource = '';

    // Static Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('battleships', 'BattleshipsField');
    }

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            // ['assetSource', 'string'],
            // ['xy', 'string'],
        ]);
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_TEXT;
    }

    /**
     * @inheritdoc
     */
    public function normalizeValue($value, ElementInterface $element = null)
    {
        return $value;
    }

    /**
     * @inheritdoc
     */
    public function serializeValue($value, ElementInterface $element = null)
    {
        return parent::serializeValue($value, $element);
    }


    // /Applications/__MAMP/htdocs/lorient/deploy/vendor/craftcms/cms/src/fields/Assets.php
    public function getSourceOptions(): array
    {
        $sourceOptions = [];

        foreach (Asset::sources('settings') as $key => $volume) {
            if (!isset($volume['heading'])) {
                $sourceOptions[] = [
                    'label' => $volume['label'],
                    'value' => $volume['key']
                ];
            }
        }

        return $sourceOptions;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml()
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'battleships/_components/fields/BattleshipsField_settings',
            [
                'field' => $this,
                'sourceOptions' => $this->getSourceOptions()
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(BattleshipsFieldFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'namespace' => $namespacedId,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').BattleshipsBattleshipsField(" . $jsonVars . ");");

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'battleships/_components/fields/BattleshipsField_input',
            [
                'name' => $this->handle,
                'value' => gettype($value) == 'array' ? $value : json_decode($value),
                'field' => $this,
                'id' => $id,
                'namespacedId' => $namespacedId,
            ]
        );
    }
}
