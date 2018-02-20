<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    public $nameEmployee;
    public $date_from;
    public $date_to;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_position', 'status'], 'integer'],
            [['username', 'last_name', 'name', 'patronymic', 'nameEmployee','auth_key', 'password_hash', 'password_reset_token', 'email', 'date_birth'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:d.m.Y']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->where(['active' => User::WORK]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'date_birth',
                'id_position',
                'created_at',
                'nameEmployee' => [
                    'asc' => ['last_name' =>SORT_ASC, 'name' => SORT_ASC, 'patronymic' => SORT_ASC],
                    'desc' => ['last_name' =>SORT_DESC, 'name' => SORT_DESC, 'patronymic' => SORT_DESC],
                    'default' => SORT_ASC
                ]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'id_position' => $this->id_position,
            'date_birth' => $this->date_birth,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'last_name', $this->nameEmployee])
            ->orFilterWhere(['like', 'name', $this->nameEmployee])
            ->orFilterWhere(['like', 'patronymic', $this->nameEmployee])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'date_birth', $this->date_birth])
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from.' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to.' 23:59:59') : null]);

        return $dataProvider;
    }
}
