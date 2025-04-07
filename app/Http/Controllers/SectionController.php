<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Services\SectionService;
use App\Swagger\SectionSwagger;

class SectionController extends Controller
{

    public function index()
    {
        return SectionService::index();
    }


    public function store(SectionRequest $request)
    {
        $section = SectionService::store($request);
        return response()->json(['data' => $section], 201);
        
    }


    public function update(SectionRequest $request, $id)
    {
        return SectionService::update($request, $id);
    }

    public function destroy($id)
    {
        $section = SectionService::destroy($id);
        return response()->json([$section]);
    }

   

}

