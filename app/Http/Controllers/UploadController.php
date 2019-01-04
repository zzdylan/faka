<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FileUploadTool;

class UploadController extends BaseController
{

    public function store(Request $request, FileUploadTool $fileUploadTool)
    {
        {
            $requestFiles = $request->file('files');
            $pathArray = $fileUploadTool->uploadMulti($requestFiles);
            $paths = array_map(function ($value) {
                return \Storage::url($value);
            }, $pathArray);
            return ['errno' => 0, 'data' => $paths];
        }
    }

}
