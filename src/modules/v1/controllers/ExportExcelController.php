<?php

namespace app\modules\v1\controllers;

use app\components\http\ApiConstant;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Html;
use Yii;

class ExportExcelController extends Controller
{
    public function actionIndex()
    {
        $contacts = Yii::$app->request->post();
        if (!is_array($contacts)) {
            return $this->responseBuilder->json(false, [], "Invalid data", ApiConstant::STATUS_BAD_REQUEST);
        }
        $pattern = "/^col_+/";
        $htmlString = '<table>';
        foreach ($contacts as $contact) {
            $htmlString .= "<tr>";
            if (!is_array($contact)) {
                return $this->responseBuilder->json(false, [], "Invalid data", ApiConstant::STATUS_BAD_REQUEST);
            }
            foreach ($contact as $column => $value) {
                if (preg_match($pattern, $column)) {
                    $htmlString .= "<td>$value</td>";
                }
            }
            $htmlString .= "</tr>";
        }
        $htmlString .= "</table>";
        $this->addHeaders();
        $reader = new Html();
        $spreadsheet = $reader->loadFromString($htmlString);
        $reader->setSheetIndex(1);
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save("php://output");
        exit();
    }

    public function addHeaders()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Origin, X-Requested-With, accept, Authorization');
        header("Content-Transfer-Encoding: UTF-8");
        header('Content-Description: File Transfer');
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment;filename=\"dev.xlsx\"");
    }

}