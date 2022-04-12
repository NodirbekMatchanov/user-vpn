<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Promocodes;

/**
 * PromocodesSearch represents the model behind the search form of `app\models\Promocodes`.
 */
class PromocodesSearch extends Promocodes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_limit', 'free_day'], 'integer'],
            [['promocode', 'expire', 'status', 'description', 'comment', 'author', 'country', 'created_at', 'updated_at'], 'safe'],
            [['discount'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Promocodes::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'expire' => $this->expire,
            'user_limit' => $this->user_limit,
            'discount' => $this->discount,
            'free_day' => $this->free_day,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'promocode', $this->promocode])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
