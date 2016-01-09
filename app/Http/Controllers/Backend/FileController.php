<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Service\FileWorkerInterface;
use App\Droit\Service\UploadInterface;

class FileController extends Controller
{
    protected $file;
    protected $upload;

    public function __construct(FileWorkerInterface $file, UploadInterface $upload)
    {
        $this->file   = $file;
        $this->upload = $upload;
    }

    public function files(Request $request)
    {
        $images = ['jpg','jpeg','JPG','JPEG','png','gif'];
        $files  = $this->file->listDirectoryFiles($request->input('path'));

        echo view('manager.partials.files', ['path' => $request->input('path') ,'files' => $files, 'images' => $images]);
    }

    public function tree()
    {
        $files = $this->file->manager();

        echo view('manager.partials.folders', ['files' => $files]);
    }

    public function delete(Request $request)
    {
        $file = $request->input('src');

        if (\File::exists($file))
        {
            \File::delete($file);

            echo true;
        }

        echo false;
    }

    public function crop(Request $request)
    {

        // imgW  => your new scaled image width
        // imgH  => your new scaled image height
        // imgX1  => top left corner of the cropped image in relation to scaled image
        // imgY1  => top left corner of the cropped image in relation to scaled image

        $image    = $request->input('imgUrl');
        $width    = $request->input('imgW');
        $height   = $request->input('imgH');
        $x        = $request->input('imgX1');
        $y        = $request->input('imgY1');
        $rotation = $request->input('rotation');

        $this->upload->crop($image, (int) $width, (int) $height, (int) $x, (int) $y, $rotation);

        echo json_encode(['status' => 'success', 'url' => $image]);

    }

}
