<?php

namespace App\Http\Controllers;

use App\Models\Chalet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChaletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chalets = Chalet::paginate(10);
        return response()->view('dashboard.chalets.index', ['chalets' => $chalets]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chalet  $chalet
     * @return \Illuminate\Http\Response
     */
    public function show(Chalet $chalet)
    {
        return response()->view('dashboard.chalets.index', ['chalets' => [$chalet]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chalet  $chalet
     * @return \Illuminate\Http\Response
     */
    public function edit(Chalet $chalet)
    {
        return response()->view('dashboard.chalets.edit', ['chalet' => $chalet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chalet  $chalet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chalet $chalet)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:75',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'location' => 'required|string|min:3|max:255',
            'latitude' => 'required|numeric|min:-90|max:90|regex:/^[+-]?+(\d{1,2})+\.+(\d{1,8})$/',
            'longitude' => 'required|numeric|min:-180|max:180|regex:/^[+-]?+(\d{1,3})+\.+(\d{1,8})$/',
            'country' => 'required|string|max:10',
            'city' => 'required|string|max:50',
            'description' => 'required|string|min:10|max:255',
            'space' => 'required|numeric|between:0,9999.99',
        ]);

        if (!$validator->fails()) {
            if ($request->hasFile('logo')) {
                $image = $request->file('logo');
                $logo = time() . '_' . $chalet->first_name . '_' . $chalet->last_name . '.' . $image->getClientOriginalExtension();
                $request->file('logo')->storePubliclyAs('chalets/logos', $logo, ['disk' => 'public']);
                $chalet->logo = $logo;
            }
            $chalet->name = $request->get('name');
            $chalet->location = $request->get('location');
            $chalet->latitude = $request->get('latitude');
            $chalet->longitude = $request->get('longitude');
            $chalet->country = $request->get('country');
            $chalet->city = $request->get('city');
            $chalet->description = $request->get('description');
            $chalet->space = $request->get('space');

            $isUpdated = $chalet->update();

            if ($isUpdated) {
                return response()->json(['message' => 'Chalet Updated Successfully'], Response::HTTP_CREATED);
            } else {
                return response()->json(['message' => 'Failed to Update Chalet'], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chalet  $chalet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chalet $chalet)
    {
        $isDeleted = $chalet->delete();
        if ($isDeleted) {
            return response()->json(
                ['title' => 'Chalet Deleted Successfully', 'icon' => 'success'],
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(
                ['title' => 'Failed to Delete Chalet', 'icon' => 'danger'],
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
