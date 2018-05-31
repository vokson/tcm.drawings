<?php

namespace App\Tecnimont;

class File
{
    public static function getListOfFilesWithExtensions($doc, $extensions)
    {
        $nameCreator = new DocumentNameCreator();

        $path = $nameCreator->absolutePath($doc);
        $name_1 = $nameCreator->nameWithRevision_1($doc);
        $name_2 = $nameCreator->nameWithRevision_2($doc);

        $extExpression = '{' . implode(',', $extensions) . '}';

        return [
            glob($path . $name_1 . "*." . $extExpression, GLOB_BRACE),
            glob($path . $name_2 . "*." . $extExpression, GLOB_BRACE)
            ];

    }

    public static function getFirstFileWithExtension($doc, $extensions) {

        [$list1, $list2] = self::getListOfFilesWithExtensions($doc, $extensions);

        if (count($list2) > 0) {
            return $list2[0]; // Сначала проверяем файлы с -TCM-NKK-

        } else {
            if (count($list1) > 0) {
                return $list1[0]; // Потом проверяем файлы по старому

            } else {
                return NULL;
            }
        }

//        return (count($list1) > 0) ? $list1[0] : NULL;
    }

    public static function pdf($doc) {
        return self::getFirstFileWithExtension($doc, ['pdf', 'PDF']);
    }

    public static function native($doc) {
        return self::getFirstFileWithExtension($doc,
            [ 'dwg', 'DWG', 'doc', 'DOC', 'docx', 'DOCX', 'xls', 'XLS', 'xlsx', 'XLSX', 'zip', 'ZIP']);
    }
}
