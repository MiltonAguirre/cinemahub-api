<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class MovieController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $category_id = $request->input('category_id');
            $year = $request->input('year');
            $moviesQuery = Movie::query()
                                ->with('director')
                                ->with('categories')
                                ->with('actors');
            if ($category_id) {
                $moviesQuery->whereHas('categories', function ($query) use ($category_id) {
                    $query->where('category_id', $category_id);
                });
            }
            if ($year){
                $moviesQuery->where('year', $year);
            }
            $movies = $moviesQuery->distinct()->get();
            return response()->json($movies,200); 
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
            'duration' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s:]+$/u',
            'year' => 'required|date_format:Y',
            'director_id' => 'required|integer|min:1',
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
            $director = Director::findOrFail($request->director_id);
            $movie = Movie::create($request->all(
                'title',
                'description',
                'year',
                'duration',
                'director_id'
            ));
            $movie->categories()->attach($categories);
            $movie->actors()->attach($actors);
            DB::commit();
            return response()->json($movie,200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }


}
