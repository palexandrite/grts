<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the user resource.
     */
    public function index()
    {
        $users = User::offset(0)->limit(10)->get();
        $attributes = ['attrnames' => $this->getAttributeAsKeys($users)];
        $userArray = ['items' => $users->toArray()];
        return array_merge($userArray, $attributes);
    }

    /**
     * Create a new user
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Save a new user
     */
    public function store()
    {
        //
    }

    /**
     * Show the specified user
     */
    public function edit(Request $request)
    {
        $id = $request->post('item');
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Update the specified user
     */
    public function update(UserRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $response = [];

        $updateableFields = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'status' => User::setStatus($validated['status']),
        ];

        if (!empty($validated['password'])) {
            $updateableFields['password'] = Hash::make($validated['password']);
        }

        $user = User::where(['id' => $validated['id']])->update($updateableFields);

        if (! $user) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = ['serverError' => 'Something went wrong on my side. Mr. Server'];
        } else {
            $responseCode = Response::HTTP_OK;
            $response = ['success' => 'Passed data were successfully saved'];
        }

        return response()->json($response, $responseCode);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        //
    }

    private function getAttributeAsKeys(Collection $collection)
    {
        $model = $collection->first();
        return $model->getAttributeNames();
    }
}
