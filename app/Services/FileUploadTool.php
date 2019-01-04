<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileUploadTool
{
    /**
     * 多文件上传
     * @param array $files
     * @return array
     */
    public function uploadMulti(array $files){
        $paths = [];
        foreach($files as $file){
            $paths[] = $this->uploadOne($file);
        }
        return $paths;
    }

    /**
     * 单文件上传
     * @param UploadedFile $file
     * @param 目录 $directory
     * @param 文件名 $fileName
     * @return 路径 $path
     */
    public function uploadOne(UploadedFile $file,$directory='',$fileName=''){
        if($directory){
            $directory = $directory.'/'.date('Y-m-d');
        }else{
            $directory = date('Y-m-d');
        }
        if(!$fileName){
            $fileName = md5_file($file).'.'.$file->getClientOriginalExtension();
        }
        $relativePath = $directory.'/'.$fileName;
        $file->storeAs($directory,$fileName);
        return $relativePath;
    }
}