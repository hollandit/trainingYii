<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%questions}}".
 *
 * @property int $id
 * @property string $name
 * @property int $id_theme
 *
 * @property Answers[] $answers
 * @property Thema $id0
 */
class Questions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%questions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'id_theme'], 'required'],
            [['name'], 'string'],
            [['id_theme'], 'integer'],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => Thema::className(), 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'id_theme' => 'Id Theme',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['id_question' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return QuestionsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionsQuery(get_called_class());
    }
}
