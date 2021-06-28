<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the user resource.
     */
    public function index()
    {
        /**
         * @return Illuminate\Pagination\LengthAwarePaginator
         */
        $pagination = User::paginate(15);

        return response()->json([
            'pagination' => $pagination,
            'attrnames' => $this->getAttributeAsKeys($pagination->getCollection())
        ]);
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
    public function store(UserRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => User::setStatus($validated['status']),
        ]);

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
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $deleted = User::destroy($id);

        $response = [];

        if ($deleted) {

            /**
             * @return Illuminate\Pagination\LengthAwarePaginator
             */
            $response['pagination'] = User::paginate(15);
            
            $response['success'] = 'It is successfully deleted';

        } else {
            $response['error'] = 'None of the items was deleted';
        }

        return response()->json($response);
    }

    /**
     * Find a searchable getting from an user
     */
    public function search(Request $request)
    {
        $searchable = $request->input('search');
        $users = User::where('first_name', 'like', "%$searchable%")
            ->orWhere('last_name', 'like', "%$searchable%")
            ->orWhere('email', 'like', "%$searchable%")
            ->orWhere('device_name', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($users);
    }

    /**
     * Select a first item from the collection and retrieve all attribute names of the User model
     */
    private function getAttributeAsKeys(Collection $collection)
    {
        $model = $collection->first();
        return $model->getAttributeNames();
    }
}
