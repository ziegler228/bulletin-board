<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegionRequest;
use App\Http\Resources\Region\RegionCollection;
use App\Http\Resources\Region\RegionResource;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $regions = Region::whereParentId(null)->orderBy('name')->get();

        return response()->json(['regions' => new RegionCollection($regions)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegionRequest  $request
     * @return JsonResponse
     */
    public function store(RegionRequest $request)
    {
        $data = [
            'name' => $name = $request->name,
            'slug' => Str::slug($name),
            'parent_id' => $request->parent
        ];

        $region = Region::create($data);

        return response()->json(['success' => true, 'region' => new RegionResource($region)], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return JsonResponse
     */
    public function show(Region $region)
    {
        $regions = $region->children()->orderBy('name')->get();

        return response()->json(['region' => $region, 'regions' => $regions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RegionRequest  $request
     * @param  \App\Models\Region  $region
     * @return JsonResponse
     */
    public function update(RegionRequest $request, Region $region)
    {
        $data = [
            'name' => $name = $request->name,
            'slug' => Str::slug($name),
            'parent_id' => $request->parent
        ];

        $region->update($data);

        return response()->json(['success' => true, 'region' => new RegionResource($region)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return JsonResponse
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return response()->json(['success' => true]);
    }
}
