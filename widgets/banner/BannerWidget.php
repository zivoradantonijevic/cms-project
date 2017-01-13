<?php
/**
 * @link      http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license   http://www.writesdown.com/license/
 */

namespace widgets\banner;

use cms\models\Option;
use common\components\BaseWidget;
use modules\banner\models\Banner;
use Yii;

/**
 * Class BannerWidget
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since  0.1.1
 */
class BannerWidget extends BaseWidget
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
        $view = Yii::getAlias('@themes/' . $theme . '/widgets/banner.php');

        if (is_file($view)) {
            $this->view = $view;
        } else {
            $this->view = __DIR__ . '/views/banner.php';
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
           // echo $this->beforeTitle . $this->title . $this->afterTitle;
        }
        $query = Banner::find()->where("start_time < NOW() AND (end_time IS NULL OR end_time > NOW())")
            ->andWhere("group_id={$this->group}");
        $query->limit(max(1, $this->count));
        $banners = $query->all();
        foreach ($banners as $banner){
            $banner->impressions++;
            $banner->save();
        }
        echo Yii::$app->view->renderFile($this->view, ['banners' => $banners]);
        echo $this->afterWidget;
    }
}
