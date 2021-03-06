<?php

namespace app\models;

use app\models\query\KnowledgeQuery;

/**
 * This is the model class for table "{{%knowledge}}".
 *
 * @property int $id
 * @property string $title
 * @property string $create_At
 * @property string $text
 * @property string $video
 */
class Knowledge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%knowledge}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'required'],
            [['create_At'], 'safe'],
            [['text'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['video'], 'string', 'max' => 86],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'create_At' => 'Дата создания',
            'text' => 'Статья',
            'video' => 'Ссылка с youtube',
        ];
    }

    /**
     * @inheritdoc
     * @return KnowledgeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KnowledgeQuery(get_called_class());
    }
}
