<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function index()
    {
        return "New Controller Working!";
    }

    public function create()
    {
        return "Create Form Here";
    }

    public function store(Request $request)
    {
        return "Stored!";
    }
}