<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    public $address;
    public $phone_number;
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['name', 'trim'],
            ['name', 'required'],
            ['name', 'string', 'max' => 75],

            ['address', 'trim'],
            ['address', 'required'],
            ['address', 'string', 'max' => 100],

            ['phone_number', 'trim'],
            ['phone_number', 'required'],
            ['phone_number', 'integer'],
            ['phone_number', 'string', 'max' => 9],

            ['role', 'trim'],
            ['role', 'required'],
            ['role', 'string', 'max' => 75],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $profile = new Profile();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);
            $profile->name = $this->name;
            $profile->address = $this->address;
            $profile->phone_number = $this->phone_number;
            $profile->user_role = $this->role;
            $profile->user_id = $user->id;
            $profile->save(false);

            // the following three lines were added:
            $auth = \Yii::$app->authManager;
            $theRole = $auth->getRole($this->role);
            $auth->assign($theRole, $user->getId());

            return $user;
        }

        return null;
    }

    public function signupInstrutor()
    {
        if ($this->validate()) {
            $user = new User();
            $profile = new Profile();

            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save(false);
            $profile->name = $this->name;
            $profile->address = $this->address;
            $profile->phone_number = $this->phone_number;
            $profile->user_role = $this->role;
            $profile->user_id = $user->id;
            $profile->save(false);

            // the following three lines were added:
            $auth = \Yii::$app->authManager;
            $theRole = $auth->getRole("instrutor");
            $auth->assign($theRole, $user->getId());

            return $user;
        }

        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
}
