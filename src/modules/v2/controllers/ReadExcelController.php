<?php

namespace app\modules\v2\controllers;

use app\components\http\ApiConstant;
use app\helpers\ArrayHelper;
use app\helpers\StringHelper;
use app\controllers\Controller;
use yii\web\UploadedFile;

class ReadExcelController extends Controller
{
    /**
     * @return array
     */
    public function actionCreate()
    {
        $file = UploadedFile::getInstanceByName("file");
        if (!$file) {
            return $this->responseBuilder->json(false, [], "Fail", ApiConstant::STATUS_BAD_REQUEST);
        }
        /** Load $inputFileName to a Spreadsheet Object **/
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->tempName);
        $worksheet = $spreadsheet->getActiveSheet();
        $result = [];
        $time = time();

        $worksheet->toArray();
        foreach ($worksheet->toArray(null, true, false) as $index => $row) {
            if ($index == 0) {
                continue;
            }
            if (!isset($row[0], $row[2])) {
                continue;
            }
            $fullName = $row[0];
            $phones = preg_split("/[., ;|]/", $row[2], -1, PREG_SPLIT_NO_EMPTY);
            foreach ($phones as $phone) {
                $columnReplaces = $this->getColumnsReplace($row);
                $result[] = [
                    "id" => $time + $index,
                    "fullname" => $this->handleText($fullName),
                    "phone" => StringHelper::filterPhone($this->handleText($phone)),
                    "address" => $row[3] ?? "",
                    "" => $row[3] ?? "",
                    "option_1" => $row[4] ?? "",
                    "option_2" => $row[5] ?? "",
                    "option_3" => $row[6] ?? "",
                    "column_replaces" => $columnReplaces
                ];
            }
        }
        if (!empty($_POST["remove_duplicate"])) {
            $result = ArrayHelper::uniqueColumn($result, "phone");
        }
        return $this->responseBuilder->json(true, $result, "Success");
    }

    /**
     * @param $row
     * @return array
     */
    protected function getColumnsReplace($row = [])
    {
        $columnsReplace = [];
        $alphabets = range("a", "z");
        $rowMax = count($row);
        for ($i = 0; $i < $rowMax; $i++) {
            $key = "//$alphabets[$i]";
            $columnsReplace[$key] = $row[$i];
        }
        return $columnsReplace;
    }

    /**
     * @param $str
     * @return array|string|string[]
     */
    public function handleText($str)
    {
        if (empty($_POST["is_slug"])) {
            return $str;
        }
        return StringHelper::slugVn($str);
    }
}