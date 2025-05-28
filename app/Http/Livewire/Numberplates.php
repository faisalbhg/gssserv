<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Numberplates extends Component
{
    public function render()
    {
        /*dd(PlateCode::where(['plateEmiratesId'=>5,'is_active'=>1])->get());
        $availableCode =[];
        foreach(PlateCode::where(['plateEmiratesId'=>4,'is_active'=>1])->get() as $plateStateCode){
            array_push($availableCode, $plateStateCode->plateColorTitle);
        }
        $numberplateCodes = ["A","B","C","D","E","H","F","K"];
        foreach($numberplateCodes as $numberplateCode){
            if(in_array($numberplateCode, $availableCode))
            {
                echo 'YES - '.$numberplateCode;
                echo '<br>';
            }
            else{
                PlateCode::create([
                    "plateCategoryId" => "1",
                    "plateEmiratesId" => "4",
                    "plateColorTitle" => $numberplateCode,
                    "plateColorDescription" => $numberplateCode,
                    "is_active"=>1
                ]);
                echo 'NO - '.$numberplateCode;
                echo '<br>';
            }
        }
        dd();*/
        
        return view('livewire.numberplates');
    }
}
