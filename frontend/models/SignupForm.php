<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $last_name;
    public $name;
    public $patronymic;
    public $city;
    public $street;
    public $build;
    public $appartament;
    public $id_position;
    public $date_birth;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            [['last_name', 'name', 'patronymic', 'city', 'street', 'appartament'], 'string', 'max' => 86],
            ['id_position', 'integer'],
            ['date_birth', 'safe']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->last_name = $this->last_name;
        $user->name = $this->name;
        $user->patronymic = $this->patronymic;
        $user->city = $this->city;
        $user->street = $this->street;
        $user->build = $this->build;
        $user->appartament = $this->appartament;
        $user->id_position = $this->id_position;
        $user->date_birth = $this->date_birth;

        return $user->save() ? $user : null;
    }
}
