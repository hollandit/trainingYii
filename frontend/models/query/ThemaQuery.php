<?php

namespace app\models\query;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Thema]].
 *
 * @see Thema
 */
class ThemaQuery extends ActiveQuery
{
    public function access($arr, $accessArr)
    {
        return $this->andWhere(['not in', 'id', $arr])->andWhere(['in', 'id', $accessArr])->limit(10);
    }

    /**
     * @inheritdoc
     * @return Thema[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Thema|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
