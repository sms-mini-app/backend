<?php

namespace app\modules\v2\controllers;

use app\components\http\ApiConstant;
use app\helpers\ArrayHelper;
use app\helpers\StringHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\UploadedFile;

class ReadExcelController extends Controller
{
    /**
     * @return array
     */
    public function actionCreate()
    {
        $file = UploadedFile::getInstanceByName("file");
        $sheetIndex = Yii::$app->request->post("sheet-index");
        $sheetIndex = intval($sheetIndex);
        if (empty($file)) {
            return $this->responseBuilder->json(false, [], "File not found", ApiConstant::STATUS_BAD_REQUEST);
        }
        /** Load $inputFileName to a Spreadsheet Object **/
        $spreadsheet = IOFactory::load($file->tempName);
        if ($sheetIndex < 0 || $sheetIndex >= $spreadsheet->getSheetCount()) {
            $worksheet = $spreadsheet->getActiveSheet();
        } else {
            $worksheet = $spreadsheet->getSheet($sheetIndex);
        }
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
            // get maximum is column z
            if (empty($alphabets[$i])) {
                break;
            }
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

    /**
     * @return array
     */
    public function actionSheet(): array
    {
        $file = UploadedFile::getInstanceByName("file");
        if ($file) {
            $spreadsheet = IOFactory::load($file->tempName);
            return $this->responseBuilder->json(true, $spreadsheet->getSheetNames(), "Success", ApiConstant::STATUS_OK);
        }
        return $this->responseBuilder->json(false, [], "Fail", ApiConstant::STATUS_BAD_REQUEST);
    }
}
