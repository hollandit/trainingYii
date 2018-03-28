<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[Choice]].
 *
 * @see Choice
 */
class ChoiceQuery extends \yii\db\ActiveQuery
{
    public function pass($id, $done)
    {
        return $this->where(['id_user' => $id, 'done' => $done]);
    }

    public function theme($acc, $idTheme)
    {
        return $this->andWhere(['id_user' => $acc->id_user])->andWhere(['id_theme' => $idTheme])->andWhere(['>=', 'date', $acc->create_at]);
    }

    /**
     * @inheritdoc
     * @return Choice[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Choice|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
