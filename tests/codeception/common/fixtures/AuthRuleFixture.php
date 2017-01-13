<?php
/**
 * @link http://www.writesdown.com/
 * @copyright Copyright (c) 2015 WritesDown
 * @license http://www.writesdown.com/license/
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * Class AuthRuleFixture
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.2
 */
class AuthRuleFixture extends ActiveFixture
{
    /**
     * @var string
     */
    public $tableName = '{{%auth_rule}}';
}
