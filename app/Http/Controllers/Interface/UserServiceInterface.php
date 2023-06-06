<?php 
namespace App\Http\Controllers\Interface;
interface UserServiceInterface
{
    public function userIndex();
    public function userShow(int $id);
    public function userStore(array $data);
    public function userUpdate(int $id, array $data);
    public function userDelete($id);
}