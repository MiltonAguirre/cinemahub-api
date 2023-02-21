<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\Category;
use App\Models\Director;
use App\Models\Episode;
use App\Models\Season;
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
    public function storeSeason(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year' => 'required|date_format:Y',
            'tv_show_id' => 'required|integer|min:1',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()],400);
        }
        try {    
            DB::beginTransaction();
            $tvShow = TvShow::findOrFail($request->tv_show_id);
            $season = Season::create($request->all('year', 'tv_show_id'));
            DB::commit();
            return response()->json($season,200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
    public function storeEpisode(Request $request, $season_number)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
            'description' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s]+$/u',
            'duration' => 'required|string|min:2|max:255|regex:/^[a-zA-Z0-9\s:]+$/u',
            'director_id' => 'required|integer|min:1',
            'tv_show_id' => 'required|integer|min:1',
        ]);
        if ($validator->fails()){
            return response()->json(['errors' => $validator->errors()],400);
        }
        try {
            DB::beginTransaction();
            $director = Director::findOrFail($request->director_id);
            $tvShow = TvShow::findOrFail($request->tv_show_id);
            $season = $tvShow->seasons()->skip($season_number-1)->take(1)->get()->first();
            if(!$season){
                return response()->json(['errors' => 'Season not found'], 400);
            }
            $episode = Episode::create(
                array_merge($request->all(
                    'title',
                    'description',
                    'duration',
                    'director_id',
                    ),
                    ['season_id' => $season->id]
                )
            );
            DB::commit();
            return response()->json($episode,200);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
    public function getEpisode($tv_id, $season_number, $episode_number)
    {
        try {
            $tvShows = TvShow::findOrFail($tv_id);
            $season = $tvShows->seasons()->skip($season_number-1)->take(1)->get()->first();
            if(!$season){
                return response()->json(['errors' => 'Season not found'], 400);
            }
            $episode = $season->episodes()->skip($episode_number-1)->take(1)->get()->first();
            $director = $episode->director;
            return response()->json(compact('episode', 'director'),200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message'=> 'Ups, something is wrong'],400);
        }
    }
}
