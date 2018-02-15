<?php

namespace App\Http\Controllers\Image;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ImageController extends ApiController
{
    public function index()
    {
        $images = Image::all();

        return $this->showAll($images, 200); // using trait
    }

    public function show($id)
    {
        $image = Image::findOrFail($id);

        return $this->showOne($image, 200); // using trait
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        // $image->forceDelete(); to delete premanently

        return $this->showOne($image, 200); // using trait
    }
}
