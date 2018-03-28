<?php

namespace app\models\query;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Testing]].
 *
 * @see Testing
 */
class TestingQuery extends ActiveQuery
{
    public function testing($idUser)
    {
        return $this->where(['id_user' => $idUser])->andWhere(['>', 'beginning', date('Y-m-d 00:00:00', strtotime('-2 week'))]);
    }

    public function reload($id)
    {
        return $this->andWhere(['=', 'id_user', Yii::$app->user->id])->andWhere(['in', 'id_theme', $id]);
    }

    public function user($theme, $user)
    {
        return $this->where(['id_theme' => $theme, 'id_user' => $user]);
    }

    /**
     * @inheritdoc
     * @return Testing[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Testing|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
