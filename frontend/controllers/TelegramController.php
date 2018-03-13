<?php

namespace frontend\controllers;

use frontend\models\Telegram;
use yii\filters\AccessControl;
use yii\web\Controller;

class TelegramController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['webhook'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ],
        ];
    }

    public function actionWebhook()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if(isset($data['message']['chat']['id']))
        {
            $chatId = $data['message']['chat']['id'];
            $sendText = $data['message']['text'];
            $name = $data['message']['from']['first_name'].' '.$data['message']['from']['last_name'];
            $date = $data['message']['date'];
            $text = '{date: '.date('Y-m-d H:i:s', $date).' chatId: '.$chatId.' message: '.$sendText.' name: '.$name.'}';
            file_put_contents('logs.txt', $text.PHP_EOL, FILE_APPEND);
            $message = isset($data['message']['text']) ? $data['message']['text'] : false;

            $send = false;

            if (strpos($message, '/start') !== false) {
                $explode = explode(' ', $message);
                $token = isset($explode[1]) ? $explode[1] : false;
                $data = [
                    'raw' => $token,
                    'chat_id' => $chatId,
                ];
                $send = Telegram::start($data);
            } else {
                $send = 'Комманда не найдена. Если Вы уверены в том, что ошибка, обратитесь в тех поддержку';
            }
            $send = $send ? '' : 'Что-то пошло не по плану. Обратитесь в тех.поддержку';
        }
    }

}
