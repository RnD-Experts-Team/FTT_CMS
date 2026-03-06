<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
     public function updateOrCreateUser($data, $userId)
    {
        try {
             $user = User::findOrFail($userId);
            if (isset($data['email']) && $data['email'] !== $user->email && User::where('email', $data['email'])->exists()) 
            {
                throw new Exception('The email address is already taken.');
            }


             if (isset($data['name'])) {
                $user->name = $data['name'];
            }

            if (isset($data['email'])) {
                $user->email = $data['email'];
            }

            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }

            $user->save();

            return $user;

        } catch (Exception $e) {
             throw new Exception('Error updating or creating the user: ' . $e->getMessage());
        }
    }
}