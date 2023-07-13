<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    
    public function index()
    {
        return view('customers.index');

    }

    public function store(Request $request)
    {
        //$this->validate(['mobile'=>'required|numeric|min:10','platenumber'=>'required|numeric']);
        
        $img = $request->image;
        dd($img);
        $folderPath = "storage/";
        
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];
        
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';
        
        $file = $folderPath . $fileName;
        Storage::put($file, $image_base64);
        
        dd('Image uploaded successfully: '.$fileName);
        

        $ocr = new TesseractOCR();
        $ocr->image('assets/img/logos/visa.png');
        echo $ocr->run();
        $this->platenumber=$ocr->run();
    }
}
