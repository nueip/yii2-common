<?php

namespace nueip\yii2\common\behaviors;

use nueip\yii2\common\base\GuSecurity;
use Yii;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;

/**
 * ActiveRecord 欄位資料加解密行為
 *
 * ```php
 *  public function behaviors()
 *  {
 *      return [
 *          'encryptAttrs' => [
 *              'class' => \nueip\yii2\common\behaviors\GuEncryptBehavior::class,
 *              'attributes' => ['attribute_a', 'attribute_b'],
 *          ],
 *      ];
 *  }
 * ```
 *
 * @author Gunter Chou <gunter.chou@staff.nueip.com>
 */
class GuEncryptBehavior extends Behavior
{
    /**
     * 加解密欄位
     *
     * @var array<string>
     */
    public array $attributes = [];

    /**
     * {@inheritDoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'decryptAttrs',
            ActiveRecord::EVENT_BEFORE_INSERT => 'encryptAttrs',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'encryptAttrs',
            ActiveRecord::EVENT_AFTER_INSERT => 'decryptAttrs',
            ActiveRecord::EVENT_AFTER_UPDATE => 'decryptAttrs',
        ];
    }

    /**
     * 加密所有欄位
     */
    public function encryptAttrs(): void
    {
        $security = $this->getSecurity();

        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = $security->encryptByConfig($this->owner->$attribute);
        }
    }

    /**
     * 解密所有欄位
     */
    public function decryptAttrs(): void
    {
        $security = $this->getSecurity();

        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = $security->decryptByConfig($this->owner->$attribute);
        }
    }

    /**
     * 取得加解密元件
     */
    private function getSecurity(): GuSecurity
    {
        /** @var GuSecurity $security */
        $security = Yii::$app->getSecurity();

        if (!method_exists($security, 'encryptByConfig') || !method_exists($security, 'decryptByConfig')) {
            throw new InvalidConfigException('[EncryptBehavior] GuSecurity component setting error. (encryptByConfig/decryptByConfig not exists)');
        }

        return $security;
    }
}
