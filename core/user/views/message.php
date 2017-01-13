<?php

/*
 * This file is part of the Sport project.
 *
 * (c) Zivorad Antonijevic <http://github.com/zantonijevic/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var yii\web\View            $this
 * @var core\user\Module    $module
 */

$this->title = $title;

?>

<?= $this->render('/_alert', [
    'module' => $module,
]);
