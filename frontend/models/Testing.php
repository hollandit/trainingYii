<?php

namespace app\models;

use app\models\query\TestingQuery;


/**
 * This is the model class for table "testing".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_theme
 * @property string $beginning
 *
 * @property Thema $theme
 * @property User $user
 */
class Testing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'testing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_theme'], 'required'],
            [['id_user', 'id_theme'], 'integer'],
            [['beginning'], 'safe'],
            [['id_theme'], 'exist', 'skipOnError' => true, 'targetClass' => Thema::className(), 'targetAttribute' => ['id_theme' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_theme' => 'Id Theme',
            'beginning' => 'Beginning',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTheme()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id_theme']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @inheritdoc
     * @return TestingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestingQuery(get_called_class());
    }


    public function saveTesting($idUser, $id)
    {
        $this->id_user = $idUser;
        $this->id_theme = $id;
        $this->save();
    }
}
