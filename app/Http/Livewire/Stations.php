<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Stationcode;

use Carbon\Carbon;

class Stations extends Component
{
    public $stationTitle, $station_id, $station_code, $station_name, $updateStation = false, $addStation = false,$stations;


    public function render()
    {
        $this->stations = Stationcode::all();
        return view('livewire.stations');
    }

    public function addNewStation(){
        $this->updateStation = false;
        $this->addStation = true;
        $this->station_code = '';
        $this->station_name = '';
        $this->station_id = null;
        $this->stationTitle = 'Add New Station';
        $this->dispatchBrowserEvent('showStationModel');
    }

    public function editStation($id)
    {
        $stationSingle = Stationcode::find($id);
        $this->station_code = $stationSingle->station_code;
        $this->station_name = $stationSingle->station_name;
        $this->station_id = $stationSingle->id;
        $this->addStation = true;
        $this->stationTitle = 'Update '.$stationSingle->station_name;
        $this->dispatchBrowserEvent('showStationModel');
    }

    public function manageStation()
    {
        if($this->station_id!=null){
            Stationcode::find($this->station_id)->update([
                'station_code'=>$this->station_code,
                'station_name'=>$this->station_name,
            ]);
            session()->flash('success', 'Station updated successfully !');
        }
        else
        {
            Stationcode::create([
                'station_code'=>$this->station_code,
                'station_name'=>$this->station_name,
            ]);
            session()->flash('success', 'Station added successfully !');
        }
        $this->stations = Stationcode::all();
        $this->dispatchBrowserEvent('hideStationModel');
    }
}
