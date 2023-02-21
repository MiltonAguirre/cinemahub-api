<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class TvShowController extends Controller
{
    public function index()
    {
        try {
            $tvShows = TvShow::with('categories')->with('actors')->distinct()->get();
            return response()->json($tvShows,200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
            'description' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
            'year' => 'required|date_format:Y',
            'categories_id' => 'required|array',
            'categories_id.*' => 'integer',
            'actors_id' => 'required|array',
            'actors_id.*' => 'integer',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()],400);
        }
        try {    
            DB::beginTransaction();
            $actors = Actor::whereIn('id', $request->categories_id)->get();
            $categories = Category::whereIn('id', $request->categories_id)->get();
            $tvShow = TvShow::create($request->all(
                'title',
                'description',
                'year',
            ));
            $tvShow->categories()->attach($categories);
            $tvShow->actors()->attach($actors);
            DB::commit();
            return response()->json($tvShow,200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
}
