<?php

namespace app\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    static function combineData($pluginOld, $pluginNew): array
    {
        $result = [];
        foreach ($pluginNew as $fieldNew => $valueNew) {
            if (!isset($pluginOld[$fieldNew])) {
                $result[$fieldNew] = $valueNew;
                continue;
            }
            if (is_array($valueNew)) {
                if (!empty($valueNew[0])) {
                    if (empty($pluginOld[$fieldNew][0])) {
                        $result[$fieldNew] = $valueNew;
                    }
                    foreach ($valueNew as $indexSubNew => $subValueNew) {
                        if (empty($pluginOld[$fieldNew][$indexSubNew])) {
                            $result[$fieldNew] = $valueNew;
                            break;
                        }
                        $result[$fieldNew][] = self::combineData($pluginOld[$fieldNew][$indexSubNew], $subValueNew);
                    }
                    continue;
                }
                $result[$fieldNew] = self::combineData($pluginOld[$fieldNew], $valueNew);
                continue;
            }
            $result[$fieldNew] = $pluginOld[$fieldNew];
        }
        return $result;
    }

    /**
     * @param $columnCheck
     * @param array $arrayFirst
     * @param array $arrayLast
     * @return array
     */
    public static function getDiffByColumnCheckStr($columnCheck, array $arrayFirst, array $arrayLast): array
    {
        return array_udiff(
            $arrayFirst,
            $arrayLast,
            function ($a, $b) use ($columnCheck) {
                return strcmp($a[$columnCheck], $b[$columnCheck]);
            }
        );
    }

    /**
     * @param $array
     * @param $column
     * @param $value
     * @return array
     */
    public static function find($array, $column, $value): array
    {
        foreach ($array as $item) {
            if (isset($item[$column]) && $item[$column] === $value) {
                return $item;
            }
        }
        return [];
    }
}
