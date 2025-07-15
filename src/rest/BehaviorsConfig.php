<?php

namespace nueip\yii2\common\rest;

use yii\filters\auth\HttpBearerAuth;
use yii\filters\Cors;
use yii\web\Response;

/**
 * Behaviors config library
 *
 * @author Gunter Chou <gunter.chou@staff.nueip.com>
 */
final class BehaviorsConfig
{
    /**
     * Set CORS bearer
     *
     * @param array<string,mixed> $behaviors the behavior configurations.
     *
     * @return array<string,array|string>
     */
    public static function corsHttpBearer(array $behaviors): array
    {
        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];
        // add header auth token verification
        $behaviors['authenticator']['authMethods'][] = HttpBearerAuth::class;

        // only response json
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
        ];

        return $behaviors;
    }
}
