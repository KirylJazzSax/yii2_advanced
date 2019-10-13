<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property int $expire_at
 *
 * @property User $user
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'token';
    }

    public function generateToken($expire)
    {
        $this->expire_at = $expire;
        $this->token = \Yii::$app->security->generateRandomString();
    }

    public function fields()
    {
        return [
            'token' => 'token',
            'expired' => function () {
                return date(DATE_RFC3339, $this->expire_at);
            },
        ];
    }
    /**
     * {@inheritdoc}
     */
//    public function rules()
//    {
//        return [
//            [['user_id', 'token', 'expire_at'], 'required'],
//            [['user_id', 'expire_at'], 'integer'],
//            [['token'], 'string', 'max' => 255],
//            [['token'], 'unique'],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
//        ];
//    }

    /**
     * {@inheritdoc}
     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'user_id' => 'User ID',
//            'token' => 'Token',
//            'expire_at' => 'Expire At',
//        ];
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
//    public function getUser()
//    {
//        return $this->hasOne(User::className(), ['id' => 'user_id']);
//    }
}
