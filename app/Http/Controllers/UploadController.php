<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessEmployees;
use App\Models\JobBatch;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;

class UploadController extends Controller
{
    public function index() {
        return view('upload');
    }

    /**
     * Upload file and store in database
     *
     * @param Request $request
     * @return Redirector
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

                $batch = Bus::batch([])->dispatch();

                foreach($csvData as $index => $record) {
                    foreach($record as $data) {
                        $employeeData[$index][] = array_combine($header, $data);
                    }
                    $batch->add(new ProcessEmployees($employeeData[$index]));
                }

                session()->put('lastBatchId', $batch->id);

                return redirect('/progress?id=' . $batch->id);
            }
        } catch (Exception $e) {
            Log::error($e);
            dd($e);
        }
    }
}
