<?php

namespace app\models\query;
use app\models\Questions;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Questions]].
 *
 * @see Questions
 */
class QuestionsQuery extends ActiveQuery
{
    public function active($id)
    {
        return $this->where(['id_theme' => $id, 'active' => Questions::ACTIVE]);
    }

    /**
     * @inheritdoc
     * @return Questions[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Questions|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
