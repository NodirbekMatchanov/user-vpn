<?php

namespace app\models;

use app\models\Translations;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TranslationsSearch represents the model behind the search form of `app\models\Translations`.
 */
class TranslationsSearch extends Translations
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['device', 'page', 'element_type', 'description', 'country', 'date'], 'safe'],
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
        $query = Translations::find();

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
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'device', $this->device])
            ->andFilterWhere(['like', 'page', $this->page])
            ->andFilterWhere(['like', 'element_type', $this->element_type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }

    public static function getListBySort()
    {
        $query = Translations::find();
        $query->orderBy('country desc, device desc, page desc, element_type desc');
        $list = $query->all();
        return $list;
    }
}
