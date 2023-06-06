<?php
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Interface\BusServiceInterface;
use App\Models\Bus;

class BusServices implements BusServiceInterface
{
    //for dependency injection
    protected $bus;
    public function __construct(Bus $bus)
    {
        $this->bus = $bus;
    }
    
    public function busIndex()
    {
        $busCount=$this->bus->count();
        if($busCount==0) {
            return null;
        }
        $bus=Bus::with('appointments')->get();
        return $bus;
    }

    public function busShow($id)
    {
        $bus=$this->bus->with('appointments')->find($id);
        if(!$bus)
        {
            return null;
        }
        return $bus;
    }

    public function busStore($data)
    {
        $bus=$this->bus->create($data);
        return $bus;  
    }

    public function busUpdate($id,$data)
    {
        $bus = $this->bus->find($id);
        if (!$bus) {
            return null;
        }
        $bus->update($data);
        $bus->save();

        return $bus;
    }

    public function busDelete($id)
    {
        $bus=$this->bus->find($id);
        if(!$bus)
        {
            return null;
        }
        else{
            $bus->delete($id);
            return 1;
        }
    }
}