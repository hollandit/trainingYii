<?php

namespace app\models;

use app\models\query\AccessQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%access}}".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_theme
 * @property string $create_at
 *
 * @property User $user
 * @property Thema $theme
 */
class Access extends ActiveRecord
{
    const DONE = 1;
    const NOT_DONE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%access}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_theme'], 'required'],
            [['id_user', 'id_theme'], 'integer'],
            ['create_at', 'safe'],
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
            'id_theme' => 'Id Theme',
            'create_at' => 'Create At'
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
     * @return AccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AccessQuery(get_called_class());
    }

    public function saveAccess($idUser, $idTheme)
    {
        $this->id_user = $idUser;
        $this->id_theme = $idTheme;
        return $this;
    }
}
