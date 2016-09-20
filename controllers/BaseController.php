<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class BaseController extends Controller
{

    /**
     * @param $message
     * @return array
     */
    public function responseWithError($message) {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return [
            'error' => [
                'msg' => $message
            ]
        ];
    }


    /**
     * @param array $data
     * @return array
     */
    public function responseWithSuccess($data = []) {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        return $data;
    }

    /**
     * Gets User associated with token
     *
     * @return User|null
     */
    public function getUserFromRequest() {
        
        $request = Yii::$app->request;
        
        $token = $request->get('token')
            ? $request->get('token')
            : $request->getBodyParam('token');
        
        return $token 
            ? User::getUserByToken($token)
            : null;
        
    }
}
