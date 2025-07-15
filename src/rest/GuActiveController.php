<?php

namespace nueip\yii2\common\rest;

use yii\rest\ActiveController;

/**
 * Extends Yii rest ActiveController class.
 *
 * @author Gunter Chou <gunter.chou@staff.nueip.com>
 */
abstract class GuActiveController extends ActiveController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return BehaviorsConfig::corsHttpBearer(parent::behaviors());
    }
}
