<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{

    // GET http://127.0.0.1:8000/api/users
    public function index()
    {
        $users = User::all();

        // return using ApiController with TraitApiResponser
        return $this->showAll($users, 200);
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

        // return using ApiController with TraitApiResponser
        return $this->showOne($user, 201);

    }

    // GET http://127.0.0.1:8000/api/users/2
    public function show(User $user) // implicit model binding
    {
        // user data is available, no need for running $user = User::findOrFail($id);
        return $this->showOne($user, 200);
    }

    // PUT http://127.0.0.1:8000/api/users/2
    public function update(Request $request, User $user) // implicit model binding
    {

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

                return $this->errorResponse('Only verified users can modify the admin field', 409);
            }
            // otherwise assign the value. It is not admin
            $user->admin = $request->admin;
        }

        // if isDirty doesn't return true it means nothing has changed (not even one field)
        // so return 422
        if (!$user->isDirty()) {

            return $this->errorResponse('No changes passed for the user - specify values you would like to update', 422);
        }

        // something has been changed e.g name or town or city so save on model
        $user->save();

        return $this->showOne($user, 200);

    }

    // PUT http://127.0.0.1:8000/api/users/1 - will be softDeleted()
    public function destroy(User $user) // implicit model binding
    {

        $user->delete();

        return $this->showOne($user, 200);
    }
}
