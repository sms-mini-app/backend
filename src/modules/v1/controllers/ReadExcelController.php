<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
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
                    "phone" => $this->filterPhone($this->handleText($phone)),
                    "address" => $row[3] ?? "",
                    "" => $row[3] ?? "",
                    "option_1" => $row[4] ?? "",
                    "option_2" => $row[5] ?? "",
                    "option_3" => $row[6] ?? "",
                    "col_a" => $row[0],
                    "col_b" => $row[1] ?? "",
                    "col_c" => $row[2],
                    "col_d" => $row[3] ?? "",
                    "col_e" => $row[4] ?? "",
                    "col_f" => $row[5] ?? "",
                    "col_g" => $row[6] ?? "",
                    "column_replaces" => $columnReplaces
                ];
            }
        }
        if (!empty($_POST["remove_duplicate"])) {
            $result = $this->uniqueContacts($result, "phone");
        }
        return $this->responseBuilder->json(true, $result, "Success");
    }

    protected function getColumnsReplace($row = [])
    {
        $columnsReplace = [];
        $alphabets = range("a", "z");
        $rowMax = count($row);
        for ($i = 0; $i < $rowMax; $i++) {
            $key = "/$alphabets[$i]";
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
        return $this->slug($str);
    }

    /**
     * @param $phone
     * @return string
     */
    public function filterPhone($phone)
    {
        if (strlen($phone) < 10) {
            return "0" . $phone;
        }
        $cleanedCoutryCode = preg_replace('/^84/', '0', $phone);
        return $cleanedCoutryCode;
    }

    /**
     * @param $contacts
     * @param $fieldCheck
     * @return array
     */
    public function uniqueContacts($contacts, $fieldCheck)
    {
        $contactFiltered = [];
        foreach ($contacts as $contact) {
            $contactFiltered[$contact[$fieldCheck]] = $contact;
        }

        return array_values($contactFiltered);
    }

    /**
     * @param $str
     * @return array|string|string[]
     */
    public function slug($str)
    {
        return str_replace(
            array(
                'á', 'à', 'ả', 'ạ', 'ã', 'ă', 'ắ', 'ằ', 'ẳ', 'ẵ', 'ặ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ',
                'Á', 'À', 'Ả', 'Ạ', 'Ã', 'Ă', 'Ắ', 'Ằ', 'Ẳ', 'Ẵ', 'Ặ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ',
                'é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ',
                'É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ',
                'í', 'ì', 'ỉ', 'ĩ', 'ị',
                'Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị',
                'ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ',
                'Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ',
                'ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự',
                'Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự',
                'Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ',
                'ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ',
                'đ', 'Đ'
            ),
            array(
                'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a',
                'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A',
                'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e', 'e',
                'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E', 'E',
                'i', 'i', 'i', 'i', 'i',
                'I', 'I', 'I', 'I', 'I',
                'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'o',
                'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'O',
                'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u', 'u',
                'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U', 'U',
                'Y', 'Y', 'Y', 'Y', 'Y',
                'y', 'y', 'y', 'y', 'y',
                'd', 'D'
            ),
            $str
        );
    }

}