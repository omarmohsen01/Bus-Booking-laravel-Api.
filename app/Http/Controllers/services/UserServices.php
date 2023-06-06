<?php 
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Interface\UserServiceInterface;
use App\Models\User;

class UserServices implements UserServiceInterface
{
    //for dependency injection
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function userIndex()
    {
        $user=$this->user->where('status', '=', 'user')->get();
        if(!empty($user)){
            return $user;
        }
    }

    public function userShow(int $id)
    {
        $user=$this->user->find($id);
        return $user;
    }

    public function userStore(array $data)
    {
        $user=$this->user->create(array_merge(
            $data,
            ['password'=>bcrypt($data['password'])]
        ));
        return $user;    
    }
    
    public function userUpdate(int $id, array $data)
    {
        $user = $this->user->find($id);
        if (!$user) {
            return null;
        }
        $user->update(array_merge(
            $data,
            ['password' => bcrypt($data['password'] ?? '')]
        ));
        $user->save();

        return $user;
    }

    public function userDelete($id)
    {
        $user=$this->user->find($id);
        if(!$user)
        {
            return null;
        }
        else{
            $user->delete($id);
            return 1;
        }
    }
}