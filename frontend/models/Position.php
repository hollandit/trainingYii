<?php

namespace app\models;

use app\models\query\PositionQuery;
use Yii;

/**
 * This is the model class for table "{{%position}}".
 *
 * @property int $id
 * @property string $name
 *
 * @property Thema[] $themas
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%position}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 36],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThemas()
    {
        return $this->hasMany(Thema::className(), ['id_possition' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PositionQuery(get_called_class());
    }
}
