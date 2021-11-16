<?php
 
namespace Duamaleek\UnzipToS3;
 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Exception;
use ZipArchive;
/**
 * Basic Calculator.
 * 
 */
class Unzip
{
    /**
     * Menjumlahkan semua data dalam sebuah array.
     *
     * @param array $data
     * @return integer
     */
    public static function uploadIntoOnePath($file, $path="")
    {
        try {
            $imageFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $failed = 0;
            $success = 0;
            if(!File::isDirectory(storage_path('temp_unzip_to_s3/files'))){
                File::makeDirectory(storage_path('temp_unzip_to_s3/files'), 0777, true, true);
            }
    
            // save to storage
            $file->move(storage_path('temp_unzip_to_s3/files/'), $imageFileName);

            $zip = new ZipArchive;
            if ($zip->open(storage_path('temp_unzip_to_s3/files/'). $imageFileName) === TRUE) {
                if(!File::isDirectory(storage_path('temp_unzip_to_s3/images'))){
                    File::makeDirectory(storage_path('temp_unzip_to_s3/images'), 0777, true, true);
                }
                $zip->extractTo(storage_path('temp_unzip_to_s3/images/'));

                // unzip and upload to s3
                $za = new ZipArchive(); 
                $za->open(storage_path('temp_unzip_to_s3/files/'). $imageFileName); 

                $di = new \RecursiveDirectoryIterator(storage_path('temp_unzip_to_s3/images'));
                foreach (new \RecursiveIteratorIterator($di) as $filename => $file) {
                    if(!is_dir($file)){
                        $info = explode("/", $filename);
                        $only_filename = $info[count($info) - 1];

                        if($path !== ""){
                            $only_filename = $path . $only_filename;
                        }
                        // echo $only_filename . ' - ' . $file->getSize() . ' bytes <br/>';
                        if(Storage::disk('s3')->put($only_filename, $file, 'public')){
                            $success++;
                        }else{
                            $failed++;
                        }

                    }else{
                    }
                    // echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
                    File::delete($filename);
                }
                File::delete(storage_path('temp_unzip_to_s3/files/'). $imageFileName);
                
                
                $zip->close();
                $response = [
                    'status' => true,
                    'message' => "Success",
                    'success' => $success,
                    'failed' => $failed,
                ];
            } else {
                File::delete(storage_path('temp_unzip_to_s3/files/'). $imageFileName);
                $response = [
                    'status' => false,
                    'message' => "Failed to open zip",
                    'success' => $success,
                    'failed' => $failed,
                ];
            }
            return $response;

        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'success' => $success,
                'failed' => $failed,
            ];

            return $response;
        }
    }
    
    public static function upload($file, $path="")
    {
        try {
            $imageFileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $failed = 0;
            $success = 0;
            if(!File::isDirectory(storage_path('temp_unzip_to_s3/files'))){
                File::makeDirectory(storage_path('temp_unzip_to_s3/files'), 0777, true, true);
            }
    
            // save to storage
            $file->move(storage_path('temp_unzip_to_s3/files/'), $imageFileName);

            $zip = new ZipArchive;
            if ($zip->open(storage_path('temp_unzip_to_s3/files/'). $imageFileName) === TRUE) {
                if(!File::isDirectory(storage_path('temp_unzip_to_s3/images'))){
                    File::makeDirectory(storage_path('temp_unzip_to_s3/images'), 0777, true, true);
                }
                $zip->extractTo(storage_path('temp_unzip_to_s3/images/'));

                // unzip and upload to s3
                $za = new ZipArchive(); 
                $za->open(storage_path('temp_unzip_to_s3/files/'). $imageFileName); 

                $di = new \RecursiveDirectoryIterator(storage_path('temp_unzip_to_s3/images'));
                foreach (new \RecursiveIteratorIterator($di) as $filename => $file) {
                    if(!is_dir($file)){
                        $info = explode("/", $filename);

                        if($path !== ""){
                            $filename = $path . $filename;
                        }
                        // echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
                        if(Storage::disk('s3')->put($filename, $file, 'public')){
                            $success++;
                        }else{
                            $failed++;
                        }

                    }else{
                    }
                    // echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
                    File::delete($filename);
                }
                File::delete(storage_path('temp_unzip_to_s3/files/'). $imageFileName);
                
                
                $zip->close();
                $response = [
                    'status' => true,
                    'message' => "Success",
                    'success' => $success,
                    'failed' => $failed,
                ];
            } else {
                File::delete(storage_path('temp_unzip_to_s3/files/'). $imageFileName);
                $response = [
                    'status' => false,
                    'message' => "Failed to open zip",
                    'success' => $success,
                    'failed' => $failed,
                ];
            }
            return $response;

        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'success' => $success,
                'failed' => $failed,
            ];

            return $response;
        }
    }
    
        /**
     * Mengalikan semua data dalam sebuah array.
     *
     * @param array $data
     * @return integer
     */
}