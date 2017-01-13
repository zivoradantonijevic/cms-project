<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace widgets\slider;

use cms\models\Option;
use common\components\BaseWidget;
use modules\slider\models\Slider;
use Yii;

/**
 * Class SliderWidget
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.1
 */
class SliderWidget extends BaseWidget
{
    /**
     * @var string
     */
    public $group = '';

    public $count = 1;
    public $view;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $theme = Option::get('theme');
        $view = Yii::getAlias('@themes/' . $theme . '/widgets/slider.php');

        if (is_file($view)) {
            $this->view = $view;
        } else {
            $this->view = __DIR__ . '/views/slider.php';
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->beforeWidget;

        if ($this->title) {
           //echo $this->beforeTitle . $this->title . $this->afterTitle;
        }
        $query = Slider::find()->where("is_published = 1")
            ->andWhere("group_id=" . (int)$this->group);
        $query->limit(max(1, $this->count));
        $sliders = $query->all();

        echo Yii::$app->view->renderFile($this->view, ['sliders' => $sliders]);
        echo $this->afterWidget;
    }
}
