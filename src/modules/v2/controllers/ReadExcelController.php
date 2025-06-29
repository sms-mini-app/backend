<?php

namespace app\modules\v2\controllers;

use app\components\http\ApiConstant;
use app\helpers\ArrayHelper;
use app\helpers\StringHelper;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\UploadedFile;
use Ramsey\Uuid\Uuid;

class ReadExcelController extends Controller
{
    /**
     * @return array
     * @throws Exception
     */
    public function actionCreate()
    {
        $file = UploadedFile::getInstanceByName("file");
        try {
            $listColumnExistData = [];
            $sheetIndex = Yii::$app->request->post("sheet-index");
            $sheetIndex = intval($sheetIndex);
            if (empty($file)) {
                return $this->responseBuilder->json(false, [], "File not found", ApiConstant::STATUS_BAD_REQUEST);
            }
            $reason = [];
            /** Load $inputFileName to a Spreadsheet Object **/
            $spreadsheet = IOFactory::load($file->tempName);
            if ($sheetIndex < 0 || $sheetIndex >= $spreadsheet->getSheetCount()) {
                $worksheet = $spreadsheet->getActiveSheet();
            } else {
                $worksheet = $spreadsheet->getSheet($sheetIndex);
            }
            $result = [];
            $time = time();
            $ordinalNumbers = 0;
            $worksheet->toArray();
            foreach ($worksheet->toArray(null, true, false) as $index => $row) {
                if ($index == 0) {
                    continue;
                }
                if (!isset($row[0], $row[2])) {
                    continue;
                }
                $column = $index + 1;
                $fullName = $row[0];
                $phones = preg_split("/[., ;|]/", $row[2], -1, PREG_SPLIT_NO_EMPTY);
                foreach ($phones as $phone) {
                    if (preg_match("/^\d{9,20}$/", $phone)) {
                        $phone = StringHelper::filterPhone($this->handleText($phone));
                        $ordinalNumbers++;
                        $columnReplaces = $this->getColumnsReplace($row, ["c" => $phone]);
                        foreach ($columnReplaces as $column => $replace) {
                            if (empty($replace) === false) {
                                $listColumnExistData[$column] = $column;
                            }
                        }
                        $result[] = [
                            "id" => Uuid::uuid4(),
                            "fullname" => $this->handleText($fullName),
                            "phone" => $phone,
                            "address" => $row[3] ?? "",
                            "" => $row[3] ?? "",
                            "option_1" => $row[4] ?? "",
                            "option_2" => $row[5] ?? "",
                            "option_3" => $row[6] ?? "",
                            "column_replaces" => $columnReplaces,
                            "ordinal_numbers" => $ordinalNumbers
                        ];
                    } else {
                        $reason[] = "Ô C$column không hợp lệ";
                        break;
                    }
                }
            }
            if (!empty($_POST["remove_duplicate"])) {
                $result = ArrayHelper::uniqueColumn($result, "phone");
            }
            return $this->responseBuilder->json(true, $result, "Success", ApiConstant::STATUS_OK, [
                "has_error" => !empty($reason),
                "reason" => join(PHP_EOL, $reason),
                "document" => "Đảm bảo cột C là kiểu Text, có thể sử dụng: ;|,. để phân tách nhiều SĐT",
                "list_columns_exist_data" => $listColumnExistData
            ]);
        } catch (Exception $exception) {
            $folderPath = Yii::getAlias("@webroot/excel");
            if (is_dir($folderPath) === false) {
                mkdir($folderPath, 0777, true);
            }
            $filePath = $folderPath . "/" . $file->getBaseName() . "_" . time() . ".xlsx";
            $file->saveAs($filePath);
            throw $exception;
        }
    }

    /**
     * @param array $row
     * @param $valueCompulsory
     * @return array
     */
    public function getColumnsReplace($row, $valueCompulsory)
    {
        $columnsReplace = [];
        $alphabets = range("a", "z");
        $rowMax = count($row);
        for ($i = 0; $i < $rowMax; $i++) {
            // get maximum is column z
            if (empty($alphabets[$i])) {
                break;
            }
            $column = $alphabets[$i];
            $key = "//$column";
            if (isset($valueCompulsory[$column])) {
                $columnsReplace[$key] = $valueCompulsory[$column];
            } else {
                $columnsReplace[$key] = $row[$i];
            }
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
