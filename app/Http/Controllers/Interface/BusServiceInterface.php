<?php
namespace App\Http\Controllers\Interface;
interface BusServiceInterface{
    public function busIndex();
    public function busShow($id);
    public function busStore($data);
    public function busUpdate($id,$data);
    public function busDelete($id);
}