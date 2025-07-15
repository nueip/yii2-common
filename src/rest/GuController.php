<?php

namespace nueip\yii2\common\rest;

use yii\rest\Controller;
use yii\rest\OptionsAction;

/**
 * Extends Yii rest Controller class.
 *
 * @author Gunter Chou <gunter.chou@staff.nueip.com>
 */
abstract class GuController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return BehaviorsConfig::corsHttpBearer(parent::behaviors());
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
}
