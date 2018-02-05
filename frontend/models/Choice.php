<?php

namespace app\models;

use app\models\query\ChoiceQuery;
use Yii;

/**
 * This is the model class for table "{{%choice}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $answear
 * @property string $date
 *
 * @property User $user
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
            [['id', 'id_user'], 'integer'],
            [['answear'], 'string'],
            ['id_user', 'default', 'value' => Yii::$app->user->id],
            [['date'], 'safe'],
            [['id'], 'unique'],
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
            'answear' => 'Answear',
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
     * @inheritdoc
     * @return ChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChoiceQuery(get_called_class());
    }
}
