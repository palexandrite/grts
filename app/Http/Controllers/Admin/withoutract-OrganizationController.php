<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{
    Auth,
    Cookie
};

class OrganizationController extends Controller
{
    public function index()
    {
        return view('admin.organization.index');
    }

    public function store()
    {
        // return view();
    }

    public function edit()
    {
        // return view();
    }
}
