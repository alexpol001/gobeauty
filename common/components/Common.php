<?php
namespace common\components;


use common\models\swp\Field;
use common\models\swp\Group;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class Common extends \yii\base\Component
{

    /**
     * @param $array ActiveQuery|array
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteAll($array)
    {
        /** @var $item ActiveRecord */
        foreach ($array as $item) {
            $item->delete();
        }
        return true;
    }

    public static function plural_form($number, $after) {
        $cases = array(2,0,1,1,1,2);
        return $number.' '.$after[($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)]];
    }

    public static function mb_ucfirst($text) {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }

    public static function getUserPortfolioFileArray($photos)
    {
        $arr = [];
        foreach ($photos as $photo) {
            $arr[] = ['caption' => $photo, 'url' => Url::to('delete-portfolio'), 'extra' => ['file' => $photo]];
        }
        return $arr;
    }

    public static function translit($str)
    {
        $rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
        $lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
        return str_replace($rus, $lat, $str);
    }
}
