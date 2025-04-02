<?php

namespace app\helpers;

use yii\base\BaseObject;

class QrBankHelper extends BaseObject
{
    public $amount;
    public $accountNoName;
    public $note;

    public function generate(): string
    {
        $template = "00020101021238520010A000000727012200069704160108{{stk}}0208QRIBFTTA53037045405{{amount}}5802VN{{additional_data}}6304";
        $content = str_replace(["{{stk}}", "{{amount}}", "{{additional_data}}"], [
            $this->accountNoName,
            $this->amount,
            $this->getAdditionalDataByNote($this->note)
        ], $template);
        $crc = dechex(CrcHelper::crc16_ibm_3740($content));
        $content .= $crc;
        return $content;
    }

    public function getAdditionalDataByNote($note): string
    {
        $idNote = "08";
        $lengthNote = str_pad(strlen($note), 2, "0", STR_PAD_LEFT);
        $dataNote = $idNote . $lengthNote . $note;
        $idAdditionalData = "62";
        $lengthAdditionalData = str_pad(strlen($dataNote), 2, "0", STR_PAD_LEFT);
        return $idAdditionalData . $lengthAdditionalData . $dataNote;
    }
}
