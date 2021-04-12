<?php
namespace frontend\components;
use Yii;

class Frontend extends \yii\base\Component
{
    public static function checkController($controller, $view)
    {
        return $controller === $view->context->getUniqueId();
    }

    public static function checkAction($controller, $action, $view)
    {
        return self::checkController($controller, $view) && Yii::$app->controller->action->id == $action;
    }
}
