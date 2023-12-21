<?php

namespace App\Http\Traits;

use App\Models\Photo;
use Illuminate\Http\Request;


trait UploadPhotoTrait
{
    public function UploadPhoto(Request $request, $folderName, $fileName)
    {
        $photo = time() . '.' . $request->file($fileName)->getClientOriginalName();
        $path = $request->file($fileName)->storeAs($folderName, $photo, 'Ican_images');
        return $path;
    }

    public function StorePhoto(Request $request ,$folderName){
        $path = $this->UploadPhoto($request,$folderName , 'photo');
        $photo = Photo::create([
            'photo' => $path,
        ]);
        return $photo;
    }
}
