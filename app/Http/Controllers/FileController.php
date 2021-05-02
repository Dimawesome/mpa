<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\File as FileTool;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class FileController
 *
 * @package App\Http\Controllers
 */
class FileController extends Controller
{
    /**
     * Get file
     *
     * @param Request $request
     * @param string $name
     * @param string $id
     * @return BinaryFileResponse
     */
    public function getFile(Request $request, string $id, string $name): BinaryFileResponse
    {
        $path = storage_path("app/users/$id/home/files/$name");

        $mime_type = FileTool::getFileType($path);

        return File::exists($path) && $request->open
            ? response()->file($path, ['Content-Type' => $mime_type])
            : response()->download($path);
    }

    /**
     * Get thumb
     *
     * @param string $id
     * @param string $name
     * @return BinaryFileResponse
     */
    public function getThumb(string $id, string $name): BinaryFileResponse
    {
        $path = storage_path("app/users/$id/home/thumbs/$name");

        $mime_type = FileTool::getFileType($path);

        if (File::exists($path)) {
            return response()->file($path, ['Content-Type' => $mime_type]);
        }
    }
}
