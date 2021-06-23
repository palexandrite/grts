<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::offset(0)->limit(10)->get();
        $attributes = ['attr-names' => $this->getAttributeAsKeys($users)];
        $userArray = ['items' => $users->toArray()];
        return array_merge($userArray, $attributes);
    }

    public function get(Request $request)
    {
        $id = $request->post('item');
        $user = User::find($id);

        return response()->json($user);
    }

    public function edit(UserRequest $request)
    {
        // @todo Here is an error. It should respond with error messages when the form is not valid
        $validated = $request->validated();

        return response()->json(['item' => $validated]);

        // return response()->json(['message' => 'you can go home', 'isSaved' => true]);
        // if (!$validated) {
        //     return response()->json("something went wrong", Response::HTTP_INTERNAL_SERVER_ERROR);
        // } else {
        //     return response()->json("everything is valid");
        // }
        // $input = $request->post();
        // $updateableFields = [
        //     'name' => $input['name'] ?? '',
        //     'email' => $input['email'] ?? '',
        //     'password' => $input['password'] ?? '',
        //     'status' => User::STATUS_REGISTERED,
        // ];

        // if () {

        // }

        // if ( isset($input['status']) && $input['status'] === true ) {
        //     $updateableFields['status'] = User::STATUS_RESIDENT;
        // }
        
        // $response = User::where(['id' => $input['id']])->update($updateableFields);

        // return response()->json($input['status']);
        // return response()->json($validated);
    }

    private function getAttributeAsKeys(Collection $collection)
    {
        $model = $collection->first();
        return $model->getAttributeNames();
    }
}
