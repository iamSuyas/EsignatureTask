<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    // http://localhost:8000/api/users [get]



    public function index(){
        $users=User::with('detail')->get();
        if($users->isEmpty()) {
            return response()->json(['message' => 'No users found']);
        }

        return response()->json($users);
    }



    // http://localhost:8000/api/users [post]




    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'address' => 'required',
            'company_name' => 'required',
            'other_info' => 'nullable|array'
        ]);

        $user = User::create($request->only('name', 'email', 'address'));

        $userDetail=UserDetails::create([
            'user_id' => $user->id,
            'company_name' => $request->company_name,
            'other_info' => $request->other_info,
        ]);

        return response()->json(['message' => 'User created']);
    }


    // http://localhost:8000/api/users/{id} [get]



    public function show($id)
    {
        $user = User::with('detail')->findOrFail($id);
        if (!$user) {
            return response()->json(['message' => 'User not found']);
        }
        return response()->json($user);
    }

    // http://localhost:8000/api/users/{id} [put]


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if($user){
            $user->update($request->only('name', 'email', 'address'));
    
            $user->detail()->update([
                'company_name' => $request->company_name,
                'other_info' => $request->other_info,
            ]);
    
            return response()->json(['message'=>'User updated']);
        }
         return response()->json(['message' => 'User not found']);
    }

    // http://localhost:8000/api/users/{id} [delete]

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user){
            $user->delete();
            return response()->json(['message' => 'User deleted']);
        }
        return response()->json(['message' => 'User not found']);
    }
}
