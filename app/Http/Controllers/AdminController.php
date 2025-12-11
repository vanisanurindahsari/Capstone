<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
        public function dashboard() {
        return view('admin.dashboard');
    }
            public function index() {
        return view('admin.viewdatakaryawan');
    }
}
