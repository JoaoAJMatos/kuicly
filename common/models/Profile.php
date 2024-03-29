<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property resource|null $profile_picture
 * @property string|null $name
 * @property int|null $phone_number
 * @property string|null $address
 * @property int $user_id
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_picture'], 'string'],
            [['phone_number', 'user_id'], 'integer'],
            [['user_id'], 'required'],
            [['name'], 'string', 'max' => 75],
            [['address'], 'string', 'max' => 100],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_picture' => 'Profile Picture',
            'name' => 'Name',
            'phone_number' => 'Phone Number',
            'address' => 'Address',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
