<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserControllerBasic extends Controller
{

    // GET http://127.0.0.1:8000/api/users
    public function index()
    {
        $users = User::all();
        return response()->json([
            'data' => $users
        ], 200);
    }

    // POST http://127.0.0.1:8000/api/users + data for each fields
    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        // validate request with validationRules
        // if validate fails laravel will return exception and stop at this line
        $this->validate($request, $validationRules);

        // on this line $request is validated and you can build data array for mass assign
        // get all fields from request
        $data = $request->all();

        // now override these 5 fields
        $data['avatar'] = 'avatar.png';
        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER; // user is unverified for start
        // generate Verification Token and store it with user
        // this token will be then send to user by email to get verification
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER; // not an admin user

        // now save data to db
        $user = User::create($data);

        return response()->json(['data' => $user], 201);

    }

    // GET http://127.0.0.1:8000/api/users/2
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data' => $user
        ], 200);
    }

    // PUT http://127.0.0.1:8000/api/users/2
    public function update(Request $request, $id)
    {
        // get current user by id
        $user = User::findOrFail($id);


        $validationRules = [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
        ];

        $this->validate($request, $validationRules);

        // if name is sent to update that we have to take it
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        // if email is sent and is different than existing email
        if ($request->has('email') && $user->email != $request->email) {
            $user->verified = User::UNVERIFIED_USER;
            $user->verification_token = User::generateVerificationCode();
            $user->email = $request->email;
        }

        // user may update his password
        // if new password is sent
        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        // if request has field admin then only verified users can modify the admin field
        if ($request->has('admin')) {
            if (!$user->isVerified()) {
                return response()->json([
                    'error' => 'Only verified users can modify the admin field',
                    'code' => 409
                ], 409);
            }
            // otherwise assign the value. It is not admin
            $user->admin = $request->admin;
        }

        // if isDirty doesn't return true it means nothing has changed (not even one field)
        // so return 422
        if (!$user->isDirty()) {
            return response()->json([
                'error' => 'No changes passed for the user - specify values you would like to update',
                'code' => 422
            ], 422);
        }

        // something has been changed e.g name or town or city so save on model
        $user->save();
        return response()->json(['data' => $user], 200);
    }

    // PUT http://127.0.0.1:8000/api/users/1 - will be softDeleted()
    public function destroy($id)
    {
        // get current user by id
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['data' => $user], 200);
    }

}
