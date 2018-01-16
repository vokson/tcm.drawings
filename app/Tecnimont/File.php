<?php

namespace App\Tecnimont;

class File
{
    public static function getListOfFilesWithExtensions($doc, $extensions)
    {
        $nameCreator = new DocumentNameCreator();

        $path = $nameCreator->path($doc);
        $name = $nameCreator->nameWithRevision($doc);

        $extExpression = '{' . implode(',', $extensions) . '}';

        return glob($path . $name . "*." . $extExpression, GLOB_BRACE);

    }

    public static function getFirstFileWithExtension($doc, $extensions) {
        $list = self::getListOfFilesWithExtensions($doc, $extensions);
        return (count($list) > 0) ? $list[0] : NULL;
    }

    public static function pdf($doc) {
        return self::getFirstFileWithExtension($doc, ['pdf', 'PDF']);
    }

    public static function native($doc) {
        return self::getFirstFileWithExtension($doc,
            [ 'dwg', 'DWG', 'doc', 'DOC', 'docx', 'DOCX', 'xls', 'XLS', 'xlsx', 'XLSX']);
    }
}
