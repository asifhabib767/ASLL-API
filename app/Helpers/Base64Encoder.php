<?php

namespace App\Helpers;

use Image;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Base64Encoder
{

    /**
     * Upload Base64 As Image
     *
     * @param string $requestImage Image file as Base 64 format
     * @param string $targetPath
     * @param string $fileName
     * @param string $subName  like for profiling, param data will be profile
     * @return string $imageOutput as output image name
     */
    public static function uploadBase64AsImage($requestImage, $targetPath, $fileName = null, $subName = null)
    {
        $folderPath = public_path() . $targetPath;
        $image_parts = explode(";base64,", $requestImage);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $fileName = trim(Str::substr(Str::slug($fileName), 0, 20));
        $image_base64 = base64_decode($image_parts[1]);

        if (is_null($fileName)) {
            $fileName = $subName . '-' . uniqid() . '-' . time();
        } else {
            $fileName = $subName . '-' . $fileName . '-' . time();
        }

        $imageOutput = $folderPath . $fileName . '.' . $image_type;
        file_put_contents($imageOutput, $image_base64);
        return $fileName. '.' . $image_type;
    }


    /**
     * Upload Base64 As Image
     *
     * @param string $requestImage Image file as Base 64 format
     * @param string $targetPath
     * @param string $fileName
     * @param string $subName  like for profiling, param data will be profile
     * @return string $imageOutput as output image name
     */
    public static function uploadBase64File($requestImage, $targetPath, $fileName = null, $subName = null)
    {
        $folderPath = public_path() . $targetPath;
        $image_parts = explode(";base64,", $requestImage);
        $type = explode(";", $requestImage);
        $extension = explode("/", $type[0])[1];
        $fileName = trim(Str::substr(Str::slug($fileName), 0, 20));
        $image_base64 = base64_decode($image_parts[1]);

        if (is_null($fileName)) {
            $fileName = $subName . '-' . uniqid() . '-' . time();
        } else {
            $fileName = $subName . '-' . $fileName . '-' . time();
        }

        $imageOutput = $folderPath . $fileName . '.' . $extension;
        file_put_contents($imageOutput, $image_base64);
        return $fileName. '.' . $extension;
    }
}
