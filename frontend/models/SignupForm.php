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
    public $phone;
    public $city;
    public $city_name;
    public $street;
    public $street_name;
    public $build;
    public $salary;
    public $build_name;
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

            [['last_name', 'name', 'patronymic', 'city', 'street', 'build','appartament'], 'string', 'max' => 86],
            [['city_name', 'street_name'], 'string', 'max' => 128],
            [['build_name'], 'string', 'max' => 36],
            ['phone', 'string', 'max' => 20],
            [['id_position', 'salary'], 'integer'],
            ['date_birth', 'safe']
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     * @throws \yii\base\Exception
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
        $user->phone = $this->phone;
        $user->city = $this->city;
        $user->city_name = $this->city_name;
        $user->street = $this->street;
        $user->street_name = $this->street_name;
        $user->build = $this->build;
        $user->build_name = $this->build_name;
        $user->appartament = $this->appartament;
        $user->id_position = $this->id_position;
        $user->salary = $this->salary;
        $user->date_birth = $this->date_birth;

        return $user->save() ? $user : null;
    }
}
