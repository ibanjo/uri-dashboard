<?php

namespace App\Http\Controllers;

use App\Attachment;
use Illuminate\Http\Request;
use Storage;

class FileController extends Controller
{
    use CreatesModels;

    public function attachFile(Request $request)
    {
        $data = $request->all();
        $file = $request->file('attachment');
        $path = $file->store('attachments');
        $attachment = $this->newAttachment(array_merge($data, [
            'type' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'path' => $path
        ]));
        return response([
            'file' => $attachment,
            'status' => 'success',
            'message' => 'Allegato inserito correttamente'
        ], 200);
    }

    public function retrieveAttachment(Request $request)
    {
        $data = $request->all();
        $file = Attachment::find($data['id']);
        return response([
            'url' => route('file.downloadattachment', ['id' => $file->id]),
            'status' => 'success',
            'message' => 'Download in corso'
        ], 200);
    }

    public function downloadAttachment($id)
    {
        $file = Attachment::find($id);
        return response()->download(storage_path('app/'.$file->path), $file->name);
    }
}
