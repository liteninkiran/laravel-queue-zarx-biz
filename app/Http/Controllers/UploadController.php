<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmployees;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function index() {
        return view('upload');
    }

    /**
     * Upload file and store in database
     *
     * @param Request $request
     * @return void
     */
    public function uploadAndStore(Request $request) {
        try {
            if($request->has('csvFile')) {
                $publicPath = public_path('uploads');
                $fileName = $request->csvFile->getClientOriginalName();
                $filePath = $publicPath . '/' . $fileName;

                if(!file_exists($filePath)) {
                    $request->csvFile->move($publicPath, $fileName);
                }

                $header = null;
                $csvData = array();
                $records = array_map('str_getcsv', file($filePath));

                foreach($records as $record) {
                    if(!$header) {
                        $header = $record;
                    } else {
                        $csvData[] = $record;
                    }
                }

                $csvData = array_chunk($csvData, 20);

                foreach($csvData as $index => $record) {
                    foreach($record as $data) {
                        $employeeData[$index][] = array_combine($header, $data);
                    }
                    ProcessEmployees::dispatch($employeeData[$index]);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            dd($e);
        }
    }
}
