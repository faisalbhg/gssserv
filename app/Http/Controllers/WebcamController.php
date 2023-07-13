<?php

namespace App\Http\Controllers;
    
use thiagoalessio\TesseractOCR\TesseractOCR; 

use Illuminate\Http\Request;
use Storage;
use File;
  
class WebcamController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('webcam');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {

        $img = $request->image;
        dd($img);
        $folderPath = "uploads/";
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        

        
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);
        
        $ocr = new TesseractOCR();
        $ocr->image(storage_path().'/app/uploads/'.$fileName);
        dd($ocr->run());
        $this->platenumber=$ocr->run();
        
        dd('Image uploaded successfully: '.$fileName);
    }
}