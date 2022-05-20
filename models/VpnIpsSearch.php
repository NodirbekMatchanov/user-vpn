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
    public $la;
    public $desc;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','load_serv','connection'], 'integer'],
            [['ip', 'status','la','type','ikev2','openvpn','provider','desc', 'country', 'city', 'cert', 'host', 'login', 'password','expire'], 'safe'],
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
    public function search($params, $status = null)
    {
        $query = VpnIps::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'ip' => [
                    'asc' => ['ip' => SORT_ASC],
                    'desc' => ['ip' => SORT_DESC],
                ],
                'status' => [
                    'asc' => ['status' => SORT_ASC],
                    'desc' => ['status' => SORT_DESC],
                ],
                'country' => [
                    'asc' => ['country' => SORT_ASC],
                    'desc' => ['country' => SORT_DESC],
                ],
                'city' => [
                    'asc' => ['city' => SORT_ASC],
                    'desc' => ['city' => SORT_DESC],
                ],
                'expire' => [
                    'asc' => ['expire' => SORT_ASC],
                    'desc' => ['expire' => SORT_DESC],
                ],
                'cert' => [
                    'asc' => ['cert' => SORT_ASC],
                    'desc' => ['cert' => SORT_DESC],
                ],
                'host' => [
                    'asc' => ['host' => SORT_ASC],
                    'desc' => ['host' => SORT_DESC],
                ],
                'provider' => [
                    'asc' => ['provider' => SORT_ASC],
                    'desc' => ['provider' => SORT_DESC],
                ],
                'password' => [
                    'asc' => ['password' => SORT_ASC],
                    'desc' => ['password' => SORT_DESC],
                ],
                'login' => [
                    'asc' => ['login' => SORT_ASC],
                    'desc' => ['login' => SORT_DESC],
                ],
                'la' => [
                    'asc' => ['ServerLoad.la' => SORT_ASC],
                    'desc' => ['ServerLoad.la' => SORT_DESC],
                ],
                'desc' => [
                    'asc' => ['ServerLoad.desc' => SORT_ASC],
                    'desc' => ['ServerLoad.desc' => SORT_DESC],
                ],
                'type' => [
                    'asc' => ['ServerLoad.type' => SORT_ASC],
                    'desc' => ['ServerLoad.type' => SORT_DESC],
                ],
                'ikev2' => [
                    'asc' => ['ServerLoad.ikev2' => SORT_ASC],
                    'desc' => ['ServerLoad.ikev2' => SORT_DESC],
                ],
                'openvpn' => [
                    'asc' => ['ServerLoad.openvpn' => SORT_ASC],
                    'desc' => ['ServerLoad.openvpn' => SORT_DESC],
                ],
                'connection' => [
                    'asc' => ['connection' => SORT_ASC],
                    'desc' => ['connection' => SORT_DESC],
                ],
            ]]);
        $this->load($params);
        $query->joinWith('serverLoad');
        if($status) {
            $query->andWhere(['status' => $status]);
        }
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
            ->andFilterWhere(['like', 'ServerLoad.la', $this->la])
            ->andFilterWhere(['like', 'ServerLoad.desc', $this->desc])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'connection', $this->connection])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'host', $this->host])
            ->andFilterWhere(['like', 'provider', $this->provider])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'load_serv', $this->login])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'expire', $this->expire])
            ->andFilterWhere(['like', 'openvpn', $this->openvpn])
            ->andFilterWhere(['like', 'ikev2', $this->ikev2])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'cert', $this->cert]);

        return $dataProvider;
    }
}
