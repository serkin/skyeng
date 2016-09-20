<?php

namespace app\models;

use yii\db\ActiveRecord;

class User extends ActiveRecord
{

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * @param $token string
     *
     * @return User|null
     */
    public static function getUserByToken($token) {

        return User::find()
            ->where(['token' => $token])
            ->one();
    }

}
