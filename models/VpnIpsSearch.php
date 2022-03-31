<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VpnIps;

/**
 * VpnIpsSearch represents the model behind the search form of `app\models\VpnIps`.
 */
class VpnIpsSearch extends VpnIps
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','load_serv'], 'integer'],
            [['ip', 'status', 'country', 'city', 'cert', 'host', 'login', 'password','expire'], 'safe'],
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
        $query = VpnIps::find();

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
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'load_serv', $this->login])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'expire', $this->expire])
            ->andFilterWhere(['like', 'cert', $this->cert]);

        return $dataProvider;
    }
}
