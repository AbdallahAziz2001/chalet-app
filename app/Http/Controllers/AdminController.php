<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::get();
        return response()->view('dashboard.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('dashboard.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:3|max:50|unique:admins,username',
            'account_picture' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'password' => 'required|min:6|regex:/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*.!@$%^&(){}]).{8,}$/',
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->username = $request->get('username');
            $admin->password = Hash::make($request->get('password'));
            if ($request->hasFile('account_picture')) {
                $image = $request->file('account_picture');
                $account_picture = time() . '_' . $admin->first_name . '_' . $admin->last_name . '.' . $image->getClientOriginalExtension();
                $request->file('account_picture')->storePubliclyAs('admins', $account_picture, ['disk' => 'public']);
                $admin->account_picture = $account_picture;
            }

            $isSaved = $admin->save();

            return response()->json(['message' => $isSaved ? 'Admin Saved Successfully' : 'Failed to Save Admin'], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        return response()->view('dashboard.admins.index', ['admins' => $admin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return response()->view('dashboard.admins.edit', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = Validator($request->all(), [
            'first_name' => 'required|string|min:3|max:50',
            'last_name' => 'required|string|min:3|max:50',
            'username' => 'required|string|min:3|max:50|unique:admins,username,' . $admin->id,
            'account_picture' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        if (!$validator->fails()) {
            $admin->first_name = $request->get('first_name');
            $admin->last_name = $request->get('last_name');
            $admin->username = $request->get('username');
            if ($request->hasFile('account_picture')) {
                $image = $request->file('account_picture');
                $account_picture = time() . '_' . $admin->first_name . '_' . $admin->last_name . '.' . $image->getClientOriginalExtension();
                $request->file('account_picture')->storePubliclyAs('admins', $account_picture, ['disk' => 'public']);
                $admin->account_picture = $account_picture;
            }

            $isUpdated = $admin->update();

            return response()->json(['message' => $isUpdated ? 'Admin Updated Successfully' : 'Failed to Update Admin'], $isUpdated ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $isDeleted = $admin->delete();
        if ($isDeleted) {
            return response()->json(['title' => 'Admin Deleted Successfully', 'icon' => 'success']);
        } else {
            return response()->json(['title' => 'Failed to Delete Admin', 'icon' => 'danger']);
        }
    }
}
