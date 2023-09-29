<?php

/*
TO READ

https://carbon.nesbot.com/docs/
*/
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Carbon;

class ResidentRepository
{
    public function getList()
    {
        return User::all()->sortBy('email');
    }

    public function getUserById($id): User|null
    {
        if (empty($id)) {
            return null;
        }
        // $user = User::where('id', $id)->get();//collection
        // $user = User::where('id', $id)->first();
        // $user = User::pluck('email');
        $user = User::find($id);
        if (empty($user)) {
            return null;
        }
        // echo "<pre>;" . print_r($user) . "</pre>";
        return $user;
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id);
        if ($user) {

            if (array_key_exists('verified', $data)) {
                unset($data['verified']);
                if ($user->email_verified_at == null) {
                    $user->email_verified_at = Carbon::now();
                }
            } else {
                $user->email_verified_at = null;
            }

            $user->update($data);
            $user->save();
        }
    }

    public function updateUserSimple($id, $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
            $user->save();
        }

    }
}