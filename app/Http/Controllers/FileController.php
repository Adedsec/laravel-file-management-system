<?php

namespace App\Http\Controllers;

use App\File;
use App\Services\Uploader\Uploader;
use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
     * @var Uploader
     */
    private $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }


    public function create()
    {

        return view('file.create');
    }

    public function index()
    {
        $files = File::all();
        return view('file.index', compact('files'));
    }

    public function show(File $file)
    {
        return $file->download();
    }

    public function delete(File $file)
    {
        $file->delete();
        return redirect()->back();
    }

    public function new(Request $request)
    {
        try {
            $this->validateFile($request);
            $this->uploader->upload();
            return redirect()->back()->with('success', 'file has uploaded !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'something wrong !');
        }
    }

    public function validateFile(Request $request)
    {
        $request->validate([
            'file' => 'required | file | mimetypes:image/jpeg,video/mp4,application/zip'
        ]);
    }
}
