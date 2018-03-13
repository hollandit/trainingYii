<?php
namespace frontend\models;

use common\models\User;
use Yii;

class Telegram
{
    public static function start($data){
        return self::login($data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function login($data)
    {
        $token = $data['raw'];
        if ($token && $user = User::findOne(['token' => $token])) {
            /** @var $user \app\models\User */
            $user->telegram_chat_id = $data['chat_id'];
            $user->save();
            return "Добро пожаловать, $user->name. Вы успешно авторизовались!";
        } else {
            return "Извините, не удалось найти данный токен!";
        }
    }

    /**
     * @param $id
     *
     */
    public function message($message)
    {
        /** @var $user \app\models\User */
        Yii::$app->bot->sendMessage('119296878', $message);
    }
}