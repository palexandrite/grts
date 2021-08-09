<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Organization,
    Receiver,
    User
};

class SearchController extends Controller
{
    /**
     * Find a searchable getting from an organization
     */
    public function organizations(Request $request)
    {
        $searchable = $request->input('search');
        $org = Organization::where('name', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($org);
    }

    /**
     * Find a searchable getting from an provider
     */
    public function receivers(Request $request)
    {
        $searchable = $request->input('search');
        $receivers = Receiver::where('first_name', 'like', "%$searchable%")
            ->orWhere('last_name', 'like', "%$searchable%")
            ->orWhere('email', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($receivers);
    }

    /**
     * Find a searchable getting from an user
     */
    public function users(Request $request)
    {
        $searchable = $request->input('search');
        $users = User::where('first_name', 'like', "%$searchable%")
            ->orWhere('last_name', 'like', "%$searchable%")
            ->orWhere('email', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($users);
    }
}