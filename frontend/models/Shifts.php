<?php

namespace app\models;


/**
 * This is the model class for table "shifts".
 *
 * @property int $id
 * @property int $user_id
 * @property int $shop_id
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Shifts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shifts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'start_time', 'end_time', 'date'], 'required'],
            [['user_id', 'shop_id'], 'integer'],
            [['date', 'start_time', 'end_time', 'created_at', 'updated_at'], 'safe'],
            ['created_at', 'default', 'value' => date('Y-m-d H:i:s')],
            [['id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Сотрудник',
            'shop_id' => 'Магазин',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return ShiftsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShiftsQuery(get_called_class());
    }

    public function saveShifts($request, $arr, $key)
    {
        $this->user_id = $request->post('user');
        $this->shop_id = $request->post('shop');
        $this->date = $arr[3].'-'.$key.'-'.$arr[1];
        $this->start_time = date('H:i', strtotime($request->post('start')));
        $this->end_time = date('H:i', strtotime($request->post('end')));
    }
}
