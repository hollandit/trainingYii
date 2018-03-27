<?php

namespace app\models;

use DateTimeImmutable;
use Yii;

/**
 * ShiftsSearch represents the model behind the search form of `app\models\Shifts`.
 */
class ShiftsSearch extends Shifts
{
    public function rules()
    {
        return [
            [['shop_id'], 'integer'],
            ['date', 'safe']
        ];
    }

    /**
     * @return object
     */
    public function search()
    {
        $request = Yii::$app->request;
        $shifts = [];
        $shop = $request->get('ShiftsSearch')['shop_id'];

        $date = $request->get('ShiftsSearch')['date'] == null
            ? date('W')
            : preg_split('/-W/', $request->get('ShiftsSearch')['date'])[1];
        $date_start = new DateTimeImmutable($date.' week first monday of Jan this year - 1 week');
        $date_end = $date_start->modify('+6 days');

        $weekDay = [
            'Пн' => $date_start->format('Y-m-d'),
            'Вт' => $date_start->modify('+1 days')->format('Y-m-d'),
            'Ср' => $date_start->modify('+2 days')->format('Y-m-d'),
            'Чт' => $date_start->modify('+3 days')->format('Y-m-d'),
            'Пт' => $date_start->modify('+4 days')->format('Y-m-d'),
            'Сб' => $date_start->modify('+5 days')->format('Y-m-d'),
            'Вс' => $date_end->format('Y-m-d'),
        ];
        $shops = $shop == null ? Shop::find()->all() : Shop::findOne($shop);
        if ($request->get('ShiftsSearch')['shop_id'] == null){
            foreach ($shops as $shop){
                $shifts[$shop->name] = Shifts::find()->with('shop')->andWhere(['between', 'date', $date_start->format('Y-m-d'), $date_end->format('Y-m-d')])->andWhere(['shop_id' => $shop->id])->all();
            }
        } else {
            $shifts[$shops->name] = Shifts::find()->with('shop')->andWhere(['between', 'date', $date_start->format('Y-m-d'), $date_end->format('Y-m-d')])->andWhere(['shop_id' => $shop])->all();
        }

        return (object)compact('query', 'weekDay', 'shifts');
    }
}
