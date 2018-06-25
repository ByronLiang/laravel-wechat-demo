<?php

namespace App\Http\Controllers\Admin;

use JSend;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $path;

    public function __construct()
    {
        $this->path = public_path('files');
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        if ($file) {
            $name = bin2hex(random_bytes(5)).'-'.time().'.'.$file->guessClientExtension();
            $file->move($this->path, $name);
            $fullPath = '/files/' . $name;

            return JSend::success(['file' => $fullPath]);
            // return JSend::success(['file' => $name, 'path' => '/files/']);
        }

        return JSend::error();
    }
}
