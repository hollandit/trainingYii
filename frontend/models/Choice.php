<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%choice}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_answear
 * @property string $date
 *
 * @property User $user
 * @property Answers $answear
 */
class Choice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%choice}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_user', 'id_answear', 'date'], 'required'],
            [['id', 'id_user', 'id_answear'], 'integer'],
            [['date'], 'safe'],
            [['id'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
            [['id_answear'], 'exist', 'skipOnError' => true, 'targetClass' => Answers::className(), 'targetAttribute' => ['id_answear' => 'id']],
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
            'id_answear' => 'Id Answear',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswear()
    {
        return $this->hasOne(Answers::className(), ['id' => 'id_answear']);
    }

    /**
     * @inheritdoc
     * @return ChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChoiceQuery(get_called_class());
    }
}
