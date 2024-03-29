<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\VpnUserSettings;
use Yii;
/**
 * VpnUserSettingsSearch represents the model behind the search form of `app\models\VpnUserSettings`.
 */
class VpnUserSettingsSearch extends VpnUserSettings
{
    public $email;
    public $status;
    public $datecreate;
    public $untildate;
    public $tariff;
    public $expire;
    public $visit_count;
    public $last_date_visit;
    public $use;
    public $source;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['op','datecreate','source','use','visit_count','last_date_visit','expire','untildate'], 'safe'],
            [['value','username','tariff','attribute', 'op','email','status'], 'string', 'max' => 255],
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
        $query = VpnUserSettings::find();
        if(!Yii::$app->user->identity->isAdmin()){
            $query->andWhere(['radcheck.id' => (Accs::getAccs()->vpnid ?? 0)]);
        }
        $query->joinWith('accs');
        $query->joinWith('stat');


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $query->orderBy('id desc');
        $this->load($params);
        $query->andWhere(['!=','accs.email', '']);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'username',
                'pass',
                'email' => [
                    'asc' => ['accs.email' => SORT_ASC],
                    'desc' => ['accs.email' => SORT_DESC],
                ],
                'status' => [
                    'asc' => ['accs.status' => SORT_ASC],
                    'desc' => ['accs.status' => SORT_DESC],
                ],
                'untildate' => [
                    'asc' => ['accs.untildate' => SORT_ASC],
                    'desc' => ['accs.untildate' => SORT_DESC],
                ],
                'expire' => [
                    'asc' => ['accs.untildate' => SORT_ASC],
                    'desc' => ['accs.untildate' => SORT_DESC],
                ],
                'tariff' => [
                    'asc' => ['accs.tariff' => SORT_ASC],
                    'desc' => ['accs.tariff' => SORT_DESC],
                ],
                'datecreate' => [
                    'asc' => ['accs.datecreate' => SORT_ASC],
                    'desc' => ['accs.datecreate' => SORT_DESC],
                ],
                'last_date_visit' => [
                    'asc' => ['user_useage_stat.last_usage_date' => SORT_ASC],
                    'desc' => ['user_useage_stat.last_usage_date' => SORT_DESC],
                ],
                'visit_count' => [
                    'asc' => ['user_useage_stat.usage_count' => SORT_ASC],
                    'desc' => ['user_useage_stat.usage_count' => SORT_DESC],
                ],
                'source' => [
                    'asc' => ['accs.source' => SORT_ASC],
                    'desc' => ['accs.source' => SORT_DESC],
                ],

        ]]);

        if(isset($params['sort']) && $params['sort'] == '-email') {
            $query->orderBy('accs.email asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'email') {
            $query->orderBy('accs.email desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-tariff') {
            $query->orderBy('accs.tariff asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'tariff') {
            $query->orderBy('accs.tariff desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-source') {
            $query->orderBy('accs.source asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'source') {
            $query->orderBy('accs.source desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-untildate') {
            $query->orderBy('accs.untildate asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'untildate') {
            $query->orderBy('accs.untildate desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-expire') {
            $query->orderBy('accs.untildate asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'expire') {
            $query->orderBy('accs.untildate desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-datecreate') {
            $query->orderBy('accs.datecreate asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'datecreate') {
            $query->orderBy('accs.datecreate desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-status') {
            $query->orderBy('accs.status asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'status') {
            $query->orderBy('accs.status desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-visit_count') {
            $query->orderBy('user_useage_stat.usage_count asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'visit_count') {
            $query->orderBy('user_useage_stat.usage_count desc');
        }

        if(isset($params['sort']) && $params['sort'] == '-last_date_visit') {
            $query->orderBy('user_useage_stat.last_usage_date asc');
        } elseif (isset($params['sort']) && $params['sort'] == 'last_date_visit') {
            $query->orderBy('user_useage_stat.last_usage_date desc');
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'username' => $this->username,
            'pass' => $this->pass,
//            'accs.email' => $this->email,
        ]);
        if(!empty($this->datecreate)){
            $query->andWhere("from_unixtime(`accs`.`datecreate`, '%Y-%m-%d') = '". date("Y-m-d",strtotime(str_replace(".","-",$this->datecreate)))."'");
        }
        if(!empty($this->untildate)){
            $query->andWhere("from_unixtime(`accs`.`untildate`, '%Y-%m-%d') = '". date("Y-m-d",strtotime(str_replace(".","-",$this->untildate)))."'");
        }
        if(!empty($this->use) && $this->use == 'да' || $this->use == 'Да') {
            $query->andFilterWhere(['>', 'user_useage_stat.usage_count', 0]);
        } elseif (!empty($this->use)){
            $query->andFilterWhere(['<=', 'user_useage_stat.usage_count', 0]);
        }

        if($this->source == 'telegram') {
            $query->andWhere(['>','accs.chatId',0]);
        } else {
            $query->andFilterWhere(['like', 'accs.source', $this->source]);
        }

        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'accs.email', $this->email])
            ->andFilterWhere(['like', 'accs.status', $this->status])
//            ->andFilterWhere(['like', 'accs.datecreate', ])
            ->andFilterWhere(['like', 'accs.tariff', $this->tariff])
            ->andFilterWhere(['like', 'accs.untildate', $this->expire])
            ->andFilterWhere(['like', 'user_useage_stat.usage_count', $this->visit_count])
            ->andFilterWhere(['like', 'user_useage_stat.last_usage_date', $this->last_date_visit])
            ->andFilterWhere(['like', 'value', $this->value]);


        return $dataProvider;
    }
}
