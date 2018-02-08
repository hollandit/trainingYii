<?php

namespace app\models;

use app\models\query\QuestionsQuery;
use Yii;

/**
 * This is the model class for table "{{%questions}}".
 *
 * @property int $id
 * @property string $name
 * @property string $answear
 * @property string $correct
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
            [['name', 'answear', 'correct'], 'string'],
            [['id_theme'], 'integer'],
            [['id_theme'], 'exist', 'skipOnError' => true, 'targetClass' => Thema::className(), 'targetAttribute' => ['id_theme' => 'id']],
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
            'answear' => 'Answear',
            'correct' => 'Correct',
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
    public function getIdThemeQuestion()
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

    public function afterFind()
    {
        $this->answear = json_decode($this->answear, true);
        $this->correct = json_decode($this->correct, true);
    }
}
