<?php

namespace App\Http\Controllers;

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
                $filePath = $publicPath . $fileName;

                if(!file_exists($filePath)) {
                    $request->csvFile->move($publicPath, $fileName);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            dd($e);
        }
    }
}
