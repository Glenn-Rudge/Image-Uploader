<?php

    namespace App\Http\Controllers;

    use App\Models\Image;
    use Illuminate\Http\Request;

    class ImageController extends Controller
    {
        public function index ()
        {
            return view("images.index");
        }

        public function show ()
        {
            return Image::latest()->pluck("name")->toArray();
        }

        public function store (Request $request)
        {
            return response()->json(["error" => "this is a test.."], 500);

            // validate the incoming file
            if (!$request->hasFile("image")) {
                return response()->json(["error" => "There is no image."], 500);
            }

            $request->validate([
                "image" => "required|file|image|mimes:jpg,jpeg,png"
            ]);
            // save file in storage
            $path = $request->file("image")->store("/public/images");

            if (!$path) {
                return response()->json(["error" => "The file could not be saved"], 500);
            }

            $uploadedFile = $request->file("image");
            // create image model
            $image = Image::create([
                "name" => $uploadedFile->hashName(),
                "extension" => $uploadedFile->extension(),
                "size" => $uploadedFile->getSize(),
            ]);

            return $image->name;
        }
    }
