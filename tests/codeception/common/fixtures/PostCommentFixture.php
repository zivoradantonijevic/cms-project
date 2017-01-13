<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * Class PostCommentFixture
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.2
 */
class PostCommentFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $modelClass = 'cms\models\PostComment';

    /**
     * @var string
     */
    public $dataFile = '@tests/codeception/common/fixtures/data/init_post_comment.php';
}
