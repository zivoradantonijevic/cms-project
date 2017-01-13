<?php
/**
 * Project: carcraft
 * Author: Zivorad Antonijevic (zivoradantonijevic@gmail.com)
 * Date: 12.2.15.
 *

 */

/**
 * @param $object
 * @param $terminate
 */
function _p($object, $terminate = false)
{
    if (!isset(Yii::$app->controller) || Yii::$app->controller instanceof yii\console\Controller) {
        print_r($object);
        if ($terminate) {
            _p_trace();
        }
        echo "\n";
    } else {
        echo '<pre>';
        print_r($object);
        if ($terminate) {
            _p_trace();
        }
        echo '</pre>';
    }
    if ($terminate) {
        Yii::$app->end();
        exit;
    }
}

function _p_trace()
{
    echo "\n";
    $e = new Exception();
    $trace = $e->getTrace();
    if (isset($trace[2]['class'])) {
        print_r($trace[2]['class'] . $trace[2]['type'] . $trace[2]['function']);
    } else if (isset($trace[2]['function'])) {
        print_r($trace[2]['function']);
    }
}

function closure_dump(Closure $c)
{
    $str = 'function (';
    $r = new ReflectionFunction($c);
    $params = [];
    foreach ($r->getParameters() as $p) {
        $s = '';
        if ($p->isArray()) {
            $s .= 'array ';
        } else {
            if ($p->getClass()) {
                $s .= $p->getClass()->name . ' ';
            }
        }
        if ($p->isPassedByReference()) {
            $s .= '&';
        }
        $s .= '$' . $p->name;
        if ($p->isOptional()) {
            $s .= ' = ' . var_export($p->getDefaultValue(), true);
        }
        $params [] = $s;
    }
    $str .= implode(', ', $params);
    $str .= '){' . PHP_EOL;
    $lines = file($r->getFileName());
    for ($l = $r->getStartLine(); $l < $r->getEndLine(); $l++) {
        $str .= $lines[$l];
    }
    return $str;
}

/**
 * @param $array
 * @param $key
 *
 * @return bool
 */
function isset_numeric($array, $key)
{
    return array_key_exists($key, $array) && is_numeric($array[$key]);
}


/**
 * @param $array
 * @param $key
 *
 * @return bool
 */
function isset_any($array, $key)
{
    return array_key_exists($key, $array) && $array[$key];
}