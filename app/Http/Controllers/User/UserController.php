<?php

namespace App\Http\Controllers\User;

use App\Traits\TraitCache;
use App\Mail\UserCreated;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UserController extends ApiController
{

    use TraitCache;

    // GET http://127.0.0.1:8000/api/users
    public function index()
    {

        $data = User::all();
        // create cache for data
        $users = $this->cacheIfNotCachedAndGetCollection($this->getCacheKey(), $data);

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
        // this comes from filesystems.php, first argument is path which is default from filesystem images-avatar
        $data['avatar'] = $request->avatar->store('', 'images-avatar');

        $data['password'] = bcrypt($request->password);
        $data['verified'] = User::UNVERIFIED_USER; // user is unverified for start
        // generate Verification Token and store it with user
        // this token will be then send to user by email to get verification
        $data['verification_token'] = User::generateVerificationCode();
        $data['admin'] = User::REGULAR_USER; // not an admin user

        // now save data to db
        $user = User::create($data);

        // Cache - user added - remove cache for this cacheKey
        $this->forgetCache($this->getCacheKey());

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

        // When you update you need to check if field has been passed
        // and you override field by field

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

        if ($request->has('city')) {
            $user->city = $request->city;
        }

        if ($request->has('country')) {
            $user->country = $request->country;
        }

        // if avatar is sent to update that we have to take it
        if ($request->hasFile('avatar')) {

            // remove old image
            $fileExists = Storage::disk('images-avatar')->exists($user->avatar);
            if($fileExists) {
                Storage::disk('images-avatar')->delete($user->avatar);
            }

            // update db and save in storage new file
            $user->avatar = $request->avatar->store('', 'images-avatar');

        }

        // if isDirty doesn't return true it means nothing has changed (not even one field)
        // so return 422
        if (!$user->isDirty()) {

            return $this->errorResponse('No changes passed for the user - specify values you would like to update', 422);
        }
        // something has been changed e.g name or town or city so save on model
        $user->save();

        // Cache - User updated - remove cache flush cache for that key
        $this->forgetCache($this->getCacheKey());

        return $this->showOne($user, 200);

    }

    // PUT http://127.0.0.1:8000/api/users/1 - will be softDeleted()
    public function destroy(User $user) // implicit model binding
    {

        $user->delete();

        $fileExists = Storage::disk('images-avatar')->exists($user->avatar);
        if($fileExists) {
            Storage::disk('images-avatar')->delete($user->avatar);
        }

        // Cache - User deleted - remove cache flush cache for that key
        $this->forgetCache($this->getCacheKey());

        return $this->showOne($user, 200);
    }


    // GET http://127.0.0.1:8000/api/users/verify/tCiQW0mD0x6Xm8U9RsqmmSpoemFhEb6bhnxGH0l4
    public function verify($token) {

        // find user coresponding to passed token
        $user = User::where('verification_token', $token)->firstOrFail();

        // make him verified
        $user->verified = User::VERIFIED_USER;

        // remove token
        $user->verification_token = null;

        // save on user update
        $user->save();

        // send message
        return $this->showMessage('The account has been verified successuly', 200);
    }

    public function resend(User $user) {

        if($user->isVerified()) {

            return $this->errorResponse('This user is alredy verified', 409);
        }

        User::created(function($user) {
            // Retry 5 times doing that is in function() and try every 100 milisecond
            retry(5, function() use ($user) {
                Mail::to($user->email)->send(new UserCreated($user));
            },100);
        });

        return $this->showMessage('The verification email has been resend', 409);
    }
}
