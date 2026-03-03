<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ImageKit\ImageKit;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::latest()->get();
        return view('upload-image', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();

        $imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );

        try {
            $uploadFile = $imageKit->uploadFile([
                'file' => base64_encode(file_get_contents($file)),
                'fileName' => $fileName
            ]);

            Image::create([
                'image_url' => $uploadFile->result->url
            ]);

           return redirect('/upload-image')->with('success', 'Image uploaded');
        } catch (\Exception $e) {
            return back()->with('error', 'ImageKit upload failed: ' . $e->getMessage());
        }
    }
}
