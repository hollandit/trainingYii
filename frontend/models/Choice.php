<?php

namespace app\models;

use app\models\query\ChoiceQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%choice}}".
 *
 * @property int $id
 * @property int $id_user
 * @property string $answear
 * @property int $id_theme
 * @property int $done
 * @property int $number
 * @property int $result
 * @property string $date
 *
 * @property User $user
 * @property Thema $theme
 */
class Choice extends ActiveRecord
{
    const PASS = 1;
    const NOT_PASS = 0;
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
            [['id_user', 'answear', 'id_theme'], 'required'],
            [['id_user', 'id_theme', 'result', 'done', 'number'], 'integer'],
            [['answear'], 'string'],
            [['date'], 'safe'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_user' => 'id']],
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
            'id_user' => 'Id User',
            'answear' => 'Answear',
            'id_theme' => 'Id Theme',
            'done' => 'Выполнено',
            'result' => 'Result',
            'number' => 'Количество всего вопросов',
            'date' => 'Дата',
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
    public function getTheme()
    {
        return $this->hasOne(Thema::className(), ['id' => 'id_theme']);
    }

    /**
     * @inheritdoc
     * @return ChoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ChoiceQuery(get_called_class());
    }

    public function afterFind()
    {
        $this->answear = json_decode($this->answear, true);
    }

    public function saveDB($id, $model, $right, $answer)
    {
        $count = count($model);

        $this->id_user = $id;
        $this->id_theme = $model[0]->id_theme;
        $this->answear = json_encode($answer, JSON_UNESCAPED_UNICODE);
        $this->result = $right;
        $this->done = $right == $count ? Choice::PASS : Choice::NOT_PASS;
        $this->number = $count;
        if (!$this->save()){
            return json_encode($this->getErrors(), JSON_UNESCAPED_UNICODE);
        }
        return $this;
    }
}
