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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['op','datecreate','untildate'], 'safe'],
            [['value','username','attribute', 'op','email','status'], 'string', 'max' => 255],
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
                'datecreate' => [
                    'asc' => ['accs.datecreate' => SORT_ASC],
                    'desc' => ['accs.datecreate' => SORT_DESC],
                ],
        ]]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'username' => $this->username,
            'pass' => $this->pass,
            'accs.email' => $this->email,
        ]);

        $query
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'accs.email', $this->email])
            ->andFilterWhere(['like', 'accs.status', $this->status])
            ->andFilterWhere(['like', 'accs.datecreate', $this->datecreate])
            ->andFilterWhere(['like', 'accs.untildate', $this->untildate])
            ->andFilterWhere(['like', 'value', $this->value]);


        return $dataProvider;
    }
}
