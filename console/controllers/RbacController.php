<?php
/**
 * Created by PhpStorm.
 * User: Rus
 * Date: 02.02.2018
 * Time: 15:42
 */

namespace console\controllers;

use \Yii;
use yii\console\Controller;


class RbacController extends Controller

{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

//        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Создадим роли админа и редактора новостей
        $hr = $auth->createRole('hr');
        $employee = $auth->createRole('employee');

        // запишем их в БД
        $auth->add($hr);
        $auth->add($employee);

        // Создаем разрешения. Например, просмотр админки viewAdminPage и редактирование новости updateNews
        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админки';

        // Запишем эти разрешения в БД
//        $auth->add($viewAdminPage);
//        $auth->add($updateNews);

        // Теперь добавим наследования. Для роли editor мы добавим разрешение updateNews,
        // а для админа добавим наследование от роли editor и еще добавим собственное разрешение viewAdminPage

        // Роли «Редактор новостей» присваиваем разрешение «Редактирование новости»
//        $auth->addChild($editor,$updateNews);

        // админ наследует роль редактора новостей. Он же админ, должен уметь всё! :D
//        $auth->addChild($admin, $editor);

        // Еще админ имеет собственное разрешение - «Просмотр админки»
//        $auth->addChild($admin, $viewAdminPage);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($hr, 1);

        // Назначаем роль editor пользователю с ID 2
        $auth->assign($employee, 2);
    }
}