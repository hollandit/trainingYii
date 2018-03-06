<?php

namespace app\models;

use app\models\query\UserQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $username
 * @property string $last_name
 * @property string $name
 * @property string $patronymic
 * @property string $phone
 * @property string $city
 * @property string $city_name
 * @property string $street
 * @property string $street_name
 * @property string $build
 * @property string $build_name
 * @property string $appartament
 * @property int $id_position
 * @property string $date_birth
 * @property int $salary
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $active
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Access[] $accesses
 * @property Choice[] $choices
 * @property Depreming[] $depremings
 * @property Testing[] $testings
 * @property Position $position
 */
class User extends ActiveRecord
{
    const WORK = 1;
    const DISMISSED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'last_name', 'name', 'patronymic', 'id_position', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'salary'], 'required'],
            [['id_position', 'status', 'salary','created_at', 'updated_at', 'active'], 'integer'],
            [['date_birth'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['last_name', 'name', 'patronymic', 'city', 'street', 'build', 'appartament'], 'string', 'max' => 86],
            [['city_name', 'street_name'], 'string', 'max' => 128],
            [['build_name'], 'string', 'max' => 36],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['id_position'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['id_position' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'last_name' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчетство',
            'city' => 'Город',
            'city_name' => 'City Name',
            'street' => 'Улица',
            'street_name' => 'Street_name',
            'build' => 'Дом',
            'build_name' => 'Build Name',
            'appartament' => 'Квартира',
            'id_position' => 'Должность',
            'date_birth' => 'Дата рождение',
            'salary' => 'Оклад',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Дата содание',
            'updated_at' => 'Updated At',
            'active' => 'Active',
            'nameEmployee' => 'ФИО'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasMany(Access::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        return $this->hasMany(Choice::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepremings()
    {
        return $this->hasMany(Depreming::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestings()
    {
        return $this->hasMany(Testing::className(), ['id_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['id' => 'id_position']);
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function getNameEmployee()
    {
        return $this->last_name.' '.$this->name.' '.$this->patronymic;
    }

    public function getAddress()
    {
        return 'г.'.$this->city_name.' ул.'.$this->street_name.' д.'.$this->build_name.' кв.'.$this->appartament;
    }
}
