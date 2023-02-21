<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return response()->json($categories,200); 
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
}
