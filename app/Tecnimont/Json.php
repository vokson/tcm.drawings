<?php

namespace App\Tecnimont;

use App\Doc;
use App\Transmittal;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Json
{
    private static function removeUtf8ByteOrderMark($text)
    {
        $bom = pack('H*', 'EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }

    private static function deleteTransmittalFromDatabase($name)
    {
        $transmittals = Transmittal::where('name', $name)->get();

        foreach ($transmittals as $t) {
            Doc::where('trans_id', $t->id)->delete();
        }

        Transmittal::where('name', $name)->delete();
    }

    private static function insertInDatabase($assocArray)
    {

        try {
            DB::transaction(function () use ($assocArray) {

                $trans = new Transmittal;
                $trans->name = $assocArray['TRANSMITTAL'];
                $trans->summary = $assocArray['SUMMARY'];
                $trans->purpose = $assocArray['PURPOSE'];
                $trans->count = $assocArray['COUNT'];
                $trans->issued_at = Carbon::createFromFormat('d.m.Y H:i:s',
                    $assocArray['DATE'] . ' 00:00:00', 'UTC')->timestamp;


                if ($assocArray['IS_REPLY_REQUESTED'] == "YES") {
                    $trans->reply_by = Carbon::createFromFormat('d.m.Y H:i:s',
                        $assocArray['REPLY_BY'] . ' 00:00:00', 'UTC')->timestamp;
                }

                $trans->save();

                foreach ($assocArray['DOCS'] as $docArray) {

                    $doc = new Doc;

                    $doc->trans_id = $trans->id;
                    $doc->nipigaz_code = $docArray["NIPIGAZ_CODE"];
                    $doc->tcm_code = $docArray["TCM_CODE"];
                    $doc->revision = $docArray["REVISION"];
                    $doc->class = $docArray["CLASS"];
                    $doc->reason = $docArray["REASON"];
                    $doc->english_title = $docArray["ENGLISH_TITLE"];
                    $doc->russian_title = $docArray["RUSSIAN_TITLE"];

                    $doc->pdf_file = basename(File::pdf($doc));
                    $doc->native_file = basename(File::native($doc));

                    $doc->save();

                }
            });


        } catch (Exception $e) {
            return false;
        }

        return true;


    }

    public static function import($filename)
    {
        $json = Storage::get($filename);
        $json = self::removeUtf8ByteOrderMark($json);
        $arr = json_decode($json, true);

        if (isset($arr['TRANSMITTAL'])) {

            self::deleteTransmittalFromDatabase($arr['TRANSMITTAL']);
            $success = self::insertInDatabase($arr);

        } else {
            $success = False;
        }


        if ($success === True) {
            echo $filename . ' - <font color="green">OK</font><br/>';
            Storage::delete($filename);
        } else {
            echo $filename . ' - <font color="red">ERROR</font><br/>';
        }

    }
}
