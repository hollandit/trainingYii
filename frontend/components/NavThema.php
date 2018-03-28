<?php

namespace frontend\components;

use app\models\Thema;
use yii\base\Widget;
use yii\bootstrap\Nav;

class NavThema extends Widget
{
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function run()
    {
        parent::init();
        $themaArr = [];
        foreach (Thema::find()->all() as $thema){
            $themaArr[] = ['label' => $thema->name.'<span class="buttonNavDelete glyphicon glyphicon-remove-sign" data-id="'.$thema->id.'"></span>', 'encode' => false, 'url' => ['test/test', 'id' => $thema->id], 'options' => ['class' => 'navigation-menu', 'data-id' => $thema->id]];
        }

        return Nav::widget([
            'options' => ['class' => 'nav nav-pills nav-stacked upperCase'],
            'items' => $themaArr
        ]);
    }
}