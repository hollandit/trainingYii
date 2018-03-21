<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Shifts]].
 *
 * @see Shifts
 */
class ShiftsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Shifts[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Shifts|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
