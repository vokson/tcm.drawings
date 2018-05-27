<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Tecnimont\Json;
use App\Doc;
use App\MaxRev;
use App\Tecnimont\DocumentNameCreator;
use Illuminate\Support\Facades\DB;
use App\Tecnimont\Revision;

class ServiceController extends Controller
{

    public function getDatabaseBackup()
    {
        return response()->file(database_path('database.sqlite'));
    }

    public function importAllJson()
    {
        $files = Storage::files(config('filesystems.jsonFolder'));

        foreach ($files as $filename) {
            Json::import($filename);
        }

    }

    public function countOfAvailableJsonFiles()
    {
        return count(Storage::files(config('filesystems.jsonFolder')));
    }

    public function maxRevUpdate()
    {
        set_time_limit(300);

        DB::table('max_revs')->truncate();

        $docs = Doc::all();
        $revArray = [];
        $nameCreator = new DocumentNameCreator();


        foreach ($docs as $doc) {
            if (isset($revArray[$doc->nipigaz_code])) {




                $revArray[$doc->nipigaz_code] =
                    Revision::max($doc->id, $nameCreator->cleanRevisionFromR($doc->revision), $revArray[$doc->nipigaz_code]);

            } else {
                $revArray[$doc->nipigaz_code] = $nameCreator->cleanRevisionFromR($doc->revision);
            }
        }

        foreach ($revArray as $nipigaz_code => $revision) {
            $doc = new MaxRev;
            $doc->nipi_code = $nipigaz_code;
            $doc->rev = $revision;
            $doc->save();

            $doc = new MaxRev;
            $doc->nipi_code = $nipigaz_code;
            $doc->rev = $nameCreator->makeRevisionWithR($revision);
            $doc->save();
        }

echo count($revArray) . " maximum revisions have been chosen.";
}
}
