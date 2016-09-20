<?php

namespace app\controllers;

use Yii;
use app\models\User;

class UserController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionCreate()
    {

        $request = Yii::$app->request;
        
        
        if($request->getBodyParam('name') === null) {
            return $this->responseWithError('Please provide a user name');
        }


        $user = new User();
        $user->name = $request->getBodyParam('name');
        $user->token = $this->generateRandomString();
        $user->save();


        return $this->responseWithSuccess([
            'id_user' => $user->id_user,
            'name' => $user->name,
            'token' => $user->token
        ]);
        
        
    }
    
    


    /*
     * Generates random string
     *
     * @param $length int
     *
     * @return string
     */
    private function generateRandomString($length = 40)
    {
        $characters = '123456789abcdfghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
