<?php

namespace graychen\yii2\queue\backend;

use yii;
use yii\base\Module as BaseModule;

/**
 * portal module definition class
 */
class Module extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'graychen\yii2\queue\backend\controllers';
    /**
     *
     * @var string source language for translation
     */
    public $sourceLanguage = 'en-US';

        /**
         * @inheritdoc
         */
    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

        /**
         * Registers the translation files
         */
    protected function registerTranslations()
    {
        Yii::$app->i18n->translations['graychen/yii2/queue/backend/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => $this->sourceLanguage,
            'basePath' => '@graychen/yii2/queue/backend/messages',
            'fileMap' => [
                'graychen/yii2/queue/backend/message' => 'queue.php',
            ],
        ];
    }

        /**
         * Translates a message. This is just a wrapper of Yii::t
         *
         * @see Yii::t
         *
         * @param $category
         * @param $message
         * @param array $params
         * @param null $language
         * @return string
         */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('graychen/yii2/queue/backend/' . $category, $message, $params, $language);
    }
    }
