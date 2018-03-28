<?php

namespace app\models;

use app\models\query\ThemaQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%thema}}".
 *
 * @property int $id
 * @property string $name
 * @property int $id_possition
 * @property string $minute
 * @property string $second
 * @property string $conditions
 *
 * @property Access[] $accesses
 * @property Answers[] $answers
 * @property Choice[] $choices
 * @property Questions[] $questions
 * @property Testing[] $testings
 * @property Position $possition
 */
class Thema extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%thema}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id_possition'], 'integer'],
            [['name'], 'string', 'max' => 200],
            [['conditions'], 'string'],
            [['minute', 'second'], 'string', 'max' => 2],
            ['id_possition', 'default', 'value' => 5],
            [['id_possition'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['id_possition' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'id_possition' => 'Id Possition',
            'minute' => 'Minute',
            'second' => 'Second',
            'conditions' => 'Conditions',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccesses()
    {
        return $this->hasMany(Access::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswers()
    {
        return $this->hasMany(Answers::className(), ['id_thema' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChoices()
    {
        return $this->hasMany(Choice::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasOne(Questions::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTestings()
    {
        return $this->hasMany(Testing::className(), ['id_theme' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPossition()
    {
        return $this->hasOne(Position::className(), ['id' => 'id_possition']);
    }

    /**
     * @inheritdoc
     * @return ThemaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ThemaQuery(get_called_class());
    }

    public function getCreateTest($thema, $request)
    {
        $this->name = $thema;
        $this->minute = $request->post('minute');
        $this->second = $request->post('second');
        if (!$this->save()) {
            print_r($this->getErrors());
        }
        return $this;
    }
}
