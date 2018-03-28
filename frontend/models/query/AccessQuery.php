<?php

namespace app\models\query;

use app\models\Access;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Access]].
 *
 * @see Access
 */
class AccessQuery extends ActiveQuery
{
    public function notdone($idUser)
    {
        return $this->where(['id_user' => $idUser, 'done' => Access::NOT_DONE])->groupBy('id_theme');
    }

    public function user($thema, $user)
    {
        return $this->where(['id_theme' => $thema, 'id_user' => $user]);
    }

    /**
     * @inheritdoc
     * @return Access[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Access|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
