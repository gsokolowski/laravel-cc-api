<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{

    public function index()
    {
        $categories = Category::all();

        return $this->showAll($categories, 200); // using trait
    }


    public function store(Request $request)
    {
        $validationRules = [
            'name' => 'required',
            'description' => 'required',
        ];

        // validate request with validationRules
        $this->validate($request, $validationRules);

        $data = $request->all();

        $data['name'] = $request->name;
        $data['description'] = $request->description;

        $category = Category::create($data);
        //return response()->json(['data' => $category], 201);
        return $this->showOne($category, 201); // using trait
    }


    public function show($id)
    {
        $category = Category::findOrFail($id);
        return $this->showOne($category, 200); // using trait
    }


    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validationRules = [
            'name' => 'required',
            'description' => 'required',
        ];

        $this->validate($request, $validationRules);


        if ($request->has('name')) {
            $category->name = $request->name;
        }

        if ($request->has('description')) {
            $category->description = $request->description;
        }

        if ($category->isClean()) {

            return $this->errorResponse('No changes passed for the category - specify values you would like to update', 422);
        }

        // if is changed so you need to save changes
        $category->save();

        return $this->showOne($category, 200); // using trait
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        // $category->forceDelete(); to delete premanently

        return $this->showOne($category, 200); // using trait
    }
}
