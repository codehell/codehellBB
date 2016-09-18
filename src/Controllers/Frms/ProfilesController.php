<?php

namespace Codehell\Codehellbb\Controllers\Frms;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Codehell\Codehellbb\Entities\Profile;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $users = User::all();
        return view('codehellbb::profiles/index', ['users' => $users->sortBy('name')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user);
        $skills = config('codehellbb.skills');
        return view('codehellbb::profiles/edit', compact('user', 'skills'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $this->validate($request, [
            'name' => 'unique:users|required|max:63',
        ]);
        $user->update(['name' => $request->name]);
        Log::notice('The user '
            . $request->user()->name . ' updated the user name with id '
            . $user->id . ' to ' . $user->name);
        return redirect()->route('profiles.edit', $user)->with('success', trans('codehellbb::forum.alert.name_changed'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('updatePassword', $user);
        $v = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:6|confirmed|max:255',
        ]);

        $v->after(function($v) use ($request, $user) {

            if(! Hash::check($request->old_password, $user->password)) {
                $v->errors()->add('old_password', trans('codehellbb::site.alert.incorrect_password'));
            }
        });

        if($v->fails()) {
            return redirect()->back()->withErrors($v);
        }

        $user->password = bcrypt($request->password);
        $user->save();
        Log::info('The user ' . $request->user()->name . ' updated the user ' . $user->name . ' password');
        return redirect()->back()->with('success', trans('codehellbb::forum.alert.password_updated'));
    }
    
    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function updateEmail(Request $request, User $user)
    {
        $this->authorize('updateEmail', $user);
        $this->validate($request, [
            'email' => 'required|email|max:63|unique:users',
        ]);
        $profile = $user->profile;
        $profile->registration_token = str_random(60);
        $profile->new_email = $request->email;
        $user->save();
        $profile->save();
        Log::info('The user ' . $request->user()->name . ' updated the user ' . $user->name . ' email');
        hell_email_sender($user);

        return redirect()->route('profiles.edit', $user)
            ->with('info', trans('codehellbb::forum.alert.email_updated'));
    }
    /**
     * @param Request $request
     * @param User $user
     * @return string
     */
    public function updateRole(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);
        $profile = $user->profile;
        $skills = array_flip(config('codehellbb.skills'));
        $profile->skill = $skills[$request->skill];
        $profile->save();
        Log::notice('The user ' . $request->user()->name . ' updated the user ' . $user->name . ' role');
        return redirect()->back()->with('success', 'Role Updated');
    }

    public function getConfirmation($token)
    {
        $profile = Profile::where('registration_token', $token)->firstOrFail();
        $user = $profile->user;
        if ($profile->new_email != null) {
            $user->email = $profile->new_email;
            $profile->new_email = null;
        }
        else {
            $profile->skill = 'User';
        }

        $profile->registration_token = null;
        $user->save();
        $profile->save();
        Log::info('The user ' . $user->name . ' confirmed his email');
        return redirect('/login')->with('success', trans('codehellbb::forum.email.confirmed'));
    }

    public function askForConfirmationCode(User $user)
    {
        $this->authorize('updateEmail', $user);
        if (is_null($user->profile->registration_token)) {
            return redirect()->back()->with('warning', trans('codehellbb::forum.alert.confirmation_already'));
        }
        hell_email_sender($user);
        Log::info('The user ' . $user->name . ' ask for confirmation email');
        return redirect()->back()->with('success', trans('codehellbb::forum.alert.confirmation_sent'));
    }

    public function banUser(Request $request, User $user)
    {
        $this->authorize('banUser', $user);
        if ($request->unban_user === null) {
            $user->profile->banned = true;
            $user->profile->ban_reason = $request->ban_reason;
            $message = trans('codehellbb::forum.alert.user_banned');
        } else {
            $user->profile->banned = false;
            $user->profile->ban_reason = null;
            $message = trans('codehellbb::forum.alert.user_unbanned');
        }
        $user->profile->save();
        return redirect()->back()->with('success', $message);
    }
}
