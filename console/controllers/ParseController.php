<?php
/**
 * Project: btool
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 26.10.16.
 */

namespace console\controllers;

use btool\components\Parser;


/**
 * ParseCommand
 **/
class ParseController extends BaseController
{

    public function actionLive($id = 0)
    {
        $parser = new Parser();
        $parser->fetchLive($id);
    }
}