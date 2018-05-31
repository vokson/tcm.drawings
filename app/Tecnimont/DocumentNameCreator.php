<?php

namespace App\Tecnimont;

class DocumentNameCreator
{
    public function absolutePath($doc)
    {
        $path = config('filesystems.documentStoragePath') . DIRECTORY_SEPARATOR;
        $path .= $this->getProjectFromTcmNumber($doc->tcm_code) . DIRECTORY_SEPARATOR;

        $path .= $this->getDirectionOfTransmittal($doc->transmittal->name) . DIRECTORY_SEPARATOR;

        $transNumber = $this->getNumberOfTransmittal($doc->transmittal->name);
        $path .= $this->createFolderByNumber($transNumber) . DIRECTORY_SEPARATOR;

        $path .= $doc->transmittal->name . DIRECTORY_SEPARATOR;

//        echo $path . "<br/>";
        return $path;
    }

    public function relativePath($doc)
    {
//        $path = config('filesystems.documentStoragePath') . DIRECTORY_SEPARATOR;
        $path = $this->getProjectFromTcmNumber($doc->tcm_code) . DIRECTORY_SEPARATOR;

        $path .= $this->getDirectionOfTransmittal($doc->transmittal->name) . DIRECTORY_SEPARATOR;

        $transNumber = $this->getNumberOfTransmittal($doc->transmittal->name);
        $path .= $this->createFolderByNumber($transNumber) . DIRECTORY_SEPARATOR;

        $path .= $doc->transmittal->name . DIRECTORY_SEPARATOR;

        return $path;
    }

    // TODO - Надо здесь добавить TCM-NKK


    public function nameWithRevision($doc)
    {
        // Адаптируем nipigaz_code для имени файла
        $code = $doc->nipigaz_code;
        $left = substr($code, 0,5);
        $right = substr($code, 5);

        // Ищем последнюю точку в правой части
        $pos = strrpos($right, '.');
        // Меняем последнюю точку на тире
        $right[$pos] = '-';

        return $name = $left . 'TCM-NKK-' . $right . '_' . $this->cleanRevisionFromR($doc->revision);
    }

    protected function language()
    {
        return 'ER';
    }

    public function cleanRevisionFromR($rev)
    {
        if (strpos($rev, 'R1') !== False) {

            $revision = str_replace('R1', '', $rev);

            if ($revision == 'A' || $revision == 'B') {
                return $revision . '1';
            } else {
                return sprintf('%02d', $revision);
            }
        }

        if ($rev === 'SDR' || $rev === 'VDR') {
            $rev = substr($rev, 0, 2);
        }



        return $rev;
    }

    public function makeRevisionWithR($rev)
    {
        switch ($rev) {
            case 'A1':
                return 'AR1';
            case 'B1':
                return 'BR1';
            case 'SD':
                return 'SDR';
            case 'VD':
                return 'VDR';
            default :
                return intval($rev) . 'R1';
        }
    }

    protected function getProjectFromTcmNumber($tcmCode)
    {
        return substr($tcmCode, 0, 4);
    }

    protected function getDirectionOfTransmittal($transmittal)
    {
        return (strpos($transmittal, "NKK-TCM") === FALSE) ? "IN" : "OUT";
    }

    protected function getNumberOfTransmittal($transmittal)
    {
        $array = explode('-', $transmittal);
        return intval($array[count($array) - 1]);
    }

    protected function createFolderByNumber($number)
    {
        $min = intdiv($number, 100) * 100 + 1;
        $max = (intdiv($number, 100) + 1) * 100;

        if ($number % 100 == 0) {
            $min = $min - 100;
            $max = $max - 100;
        }

//        echo "MIN = " . $min . '<br/>';
//        echo "MAX = " . $max . '<br/>';

        return sprintf("%04d-%04d", $min, $max);
    }

}