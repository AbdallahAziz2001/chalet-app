<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return response()->view('dashboard.users.index', ['users' => $users]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->view('dashboard.users.index', ['users' => [$user]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return response()->view('dashboard.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:3|max:50|unique:users,username,' . $user->id,
            'email' => 'nullable|email|string|min:10|max:191|unique:users,email,' . $user->id,
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:25|unique:users,mobile,' . $user->id,
            'gender' => 'nullable|in:Male,Female',
            'birthday' => 'nullable|date|date_format:Y-m-d',
            'balance' => 'required|numeric|between:0,999999.99',
            'account_picture' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if (!$validator->fails()) {
            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->username = $request->get('username');
            if ($request->has('email')) {
                $user->email = $request->get('email');
            }
            $user->mobile = $request->get('mobile');
            if ($request->has('gender')) {
                $user->gender = $request->get('gender');
            }
            if ($request->has('birthday')) {
                $user->birthday = $request->get('birthday');
            }
            $user->balance = $request->get('balance');
            if ($request->hasFile('account_picture')) {
                $image = $request->file('account_picture');
                $account_picture = time() . '_' . $user->first_name . '_' . $user->last_name . '.' . $image->getClientOriginalExtension();
                $request->file('account_picture')->storePubliclyAs('users', $account_picture, ['disk' => 'public']);
                $user->account_picture = $account_picture;
            }

            $isUpdated = $user->update();

            if ($isUpdated) {
                return response()->json(['message' => 'User Updated Successfully'], Response::HTTP_CREATED);
            } else {
                return response()->json(['message' => 'Failed to Update User'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'User Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed to Delete User', 'icon' => 'danger']);
        }
    }
}
