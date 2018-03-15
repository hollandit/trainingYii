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
 * @property string $create_at
 *
 * @property User $user
 */
class Depreming extends \yii\db\ActiveRecord
{
    const BONUS = 0;
    const FINE = 1;
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
            [['id_user'], 'required'],
            [['type', 'amount', 'id_user'], 'integer'],
            [['comment'], 'string'],
            [['create_at'], 'safe'],
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
            'create_at' => 'Create At',
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
