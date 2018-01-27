<?php

namespace App\Http\Controllers;

use App\Transmittal;
use Illuminate\Http\Request;
use App\Tecnimont\DocumentNameCreator;
use Illuminate\Support\Facades\View;

class TransmittalController extends Controller
{
    public function showTransmittalFolder($id)
    {
        $path = $this->getPathOfTransmittalFolder($id);

        if ($path <> "") {
            $data['trans_id'] = $id;
            $data['files'] = glob($path . "*");

            return View::make('folder')->with('data', $data);
        }
    }

    public function getFileFromFolder($trans_id, $file_id)
    {
        $path = $this->getPathOfTransmittalFolder($trans_id);

        if ($path <> "") {

            $files = glob($path . "*");

            if (isset($files[$file_id])) {
                $filename = basename($files[$file_id]);

                return response()->download($path . $filename,
                    $filename, ['Content-Type: application/octet-stream']);
            }

            return "Файл не найден !!!";

        }

    }

    private function getPathOfTransmittalFolder($id)
    {
        $trans = Transmittal::where('id', $id)->firstOrFail();
        $docs = $trans->docs;

        if (count($docs) > 0) {
            $docNameCreator = new DocumentNameCreator();
            return $docNameCreator->absolutePath($docs[0]);
        }

        return "";

    }

}
