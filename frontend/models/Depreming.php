<?php

namespace app\models;

/**
 * This is the model class for table "{{%depreming}}".
 *
 * @property int $id
 * @property int $type
 * @property int $amount
 * @property int $id_user
 * @property string $comment
 *
 * @property User $user
 */
class Depreming extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%depreming}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'amount', 'id_user', 'comment'], 'required'],
            [['type', 'amount', 'id_user'], 'integer'],
            [['comment'], 'string'],
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
            'type' => 'Type',
            'amount' => 'Amount',
            'id_user' => 'Id User',
            'comment' => 'Comment',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
