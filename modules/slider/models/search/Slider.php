<?php

namespace modules\slider\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\slider\models\Slider as SliderModel;

/**
 * Slider represents the model behind the search form of `modules\slider\models\Slider`.
 *
 */
class Slider extends SliderModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'group_id', 'author', 'sortorder', 'is_published'], 'integer'],
            [['name', 'code', 'image', 'url'], 'safe'],
            [['name', 'url', 'title_en', 'title_tr', 'subtitle_en', 'subtitle_tr'], 'string', 'max' => 255],
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
        $query = SliderModel::find();

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
            'group_id' => $this->group_id,
            'author' => $this->author,
            'sortorder' => $this->sortorder,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
