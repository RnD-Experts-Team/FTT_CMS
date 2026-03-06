<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Exception;
class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

   
    public function updateUser(UpdateUserRequest $request)
    {
        try {
             $user = auth()->user();
            if (!$user) {
                return response()->json(['message' => 'User not found']);
            }

             $updatedUser = $this->userService->updateOrCreateUser($request->validated(), $user->id);

            return response()->json(['message' => 'User updated successfully', 'user' => $updatedUser]);

        } catch (Exception $e) {
             return response()->json(['message' => 'An error occurred: ' . $e->getMessage()]);
        }
    }
}