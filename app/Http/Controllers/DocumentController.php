<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Doc;
use App\Tecnimont\DocumentNameCreator;
use App\Tecnimont\File;
use App\Tecnimont\QueryCreator\DocumentWhereQueryCreator;
use Illuminate\Support\Facades\DB;
use App\Tecnimont\ArchiveStorage;

class DocumentController extends Controller
{
//    public function index()
//    {
//        return view('documents.index');
//    }

    public function search(Request $request)

    {
        $queryCreator = new DocumentWhereQueryCreator();

        if ($request->input('only_last_rev') == 1) {
            $docs = DB::table('docs')
                ->join('transmittals', function ($join) {
                    $join->on('docs.trans_id', '=', 'transmittals.id');
                })
                ->join('max_revs', function ($join) {
                    // nipi_code, rev are used to avoid SQL error
                    $join->on('docs.nipigaz_code', '=', 'max_revs.nipi_code');
                    $join->on('docs.revision', '=', 'max_revs.rev');
                })
                ->select('docs.*', 'transmittals.name as transmittal', 'transmittals.issued_at')
                ->where($queryCreator->make($request))
                ->get();
        } else {
            $docs = DB::table('docs')
                ->join('transmittals', function ($join) {
                    $join->on('docs.trans_id', '=', 'transmittals.id');
                })
                ->select('docs.*', 'transmittals.name as transmittal', 'transmittals.issued_at')
                ->where($queryCreator->make($request))
                ->get();
        }


        return json_encode($docs);
    }


    public function getListOfFiles($id)
    {
        $doc = self::getDocumentById($id);
        echo File::pdf($doc) . '<br/>';
        echo File::native($doc) . '<br/>';
    }

    public function getSinglePdfFile($id)
    {
        $doc = self::getDocumentById($id);
        $docNameCreator = new DocumentNameCreator();

        return response()
            ->make(file_get_contents($docNameCreator->absolutePath($doc) . $doc->pdf_file), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $doc->pdf_file . '"');
    }

    public function getSingleNativeFile($id)
    {
        $doc = self::getDocumentById($id);
        $docNameCreator = new DocumentNameCreator();

        return response()->download($docNameCreator->absolutePath($doc) . $doc->native_file,
            $doc->native_file, ['Content-Type: application/octet-stream']);
    }

    public static function getDocumentById($id)
    {
        return Doc::where('id', $id)->firstOrFail();
    }

    public function zipMany(Request $request)
    {
        $docNameCreator = new DocumentNameCreator();

        set_time_limit(config('filesystems.archiveCreationTime'));

        $zipStorage = new ArchiveStorage();

        $zipStorage->clean();

        $idList = json_decode($request->input('list'));

        $files = [];

        foreach ($idList as $id) {
            $doc = self::getDocumentById($id);

            if ($request->input('typeOfFiles') == "pdf") {
                if ($doc->pdf_file != '') {
                    $files[] = $docNameCreator->absolutePath($doc) . $doc->pdf_file;
                }
            }

            if ($request->input('typeOfFiles') == "native") {
                if ($doc->native_file != '') {
                    $files[] = $docNameCreator->absolutePath($doc) . $doc->native_file;
                }
            }
        }


        $zipPath = config('filesystems.archiveStoragePath') . DIRECTORY_SEPARATOR . 'drawings_' . uniqid() . '.zip';

        if ($zipStorage->createArchive($files, $zipPath) === TRUE) {
            return basename($zipPath);
        } else {
            return "";
        }
    }

}
