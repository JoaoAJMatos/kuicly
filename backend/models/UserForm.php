<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Profile;
use yii\db\ActiveRecord;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;
    public $name;
    public $address;
    public $phone_number;



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


            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }


    public function createFormUser()
    {
        if ($this->validate()) {
            $user = new User();
            $profile = new Profile();

            $user->username = $this->username;

            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->save();
            $profile->name = $this->name;
            $profile->address = $this->address;
            $profile->phone_number = $this->phone_number;
            $profile->user_id = $user->getId();
            $this->id = $user->getId();

            // the following three lines were added:
            $auth = \Yii::$app->authManager;
            $theRole = $auth->getRole("admin");
            $auth->assign($theRole, $user->getId());

            return $profile->save();
        }

        return null;
    }

    public function updateFormUser($id)
    {
        $user = User::findOne($id);
        $profile = Profile::findOne(['user_id' => $id]);

        if ($user !== null && $profile !== null) {
            // Carregar dados do formulário nos modelos
            if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
                // Validar os modelos após o carregamento dos dados do formulário
                if ($user->validate() && $profile->validate()) {
                    // Atribuir valores diretamente aos modelos
                    $user->username = $user->username; // Atribua valores apropriados
                    $user->email = $user->email; // Atribua valores apropriados

                    $profile->name = $profile->name; // Atribua valores apropriados
                    $profile->address = $profile->address; // Atribua valores apropriados
                    $profile->phone_number = $profile->phone_number; // Atribua valores apropriados

                    // Salvar os modelos após as modificações
                    if ($user->save() && $profile->save()) {
                        return true; // Atualização bem-sucedida
                    }
                }
            }
        }

        return false;
    }


}
