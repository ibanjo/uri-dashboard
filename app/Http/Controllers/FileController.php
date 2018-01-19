<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Mobility;
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
            'url' => route('file.download', ['id' => $file->id]),
            'status' => 'success',
            'message' => 'Download in corso'
        ], 200);
    }

    public function downloadAttachment($id)
    {
        $file = Attachment::find($id);
        return response()->download(storage_path('app/' . $file->path), $file->name);
    }

    public function deleteAttachment($id)
    {
        Attachment::destroy($id);
        return response([
            'status' => 'success',
            'message' => 'Allegato eliminato correttamente'
        ], 200);
    }

    public function uploadDocument(Request $request)
    {
        $data = $request->all();
        $file = $request->file('document');
        $path = $file->store('documents');
        $document = $this->newMobilityDocument(array_merge($data, [
            'type' => $file->getMimeType(),
            'name' => $file->getClientOriginalName(),
            'path' => $path
        ]));

        return response([
            'file' => $document,
            'status' => 'success',
            'message' => 'Documento inserito correttamente'
        ], 200);
    }

    public function retrieveDocument(Request $request)
    {
        $data = $request->all();
        $class_name = 'App\\' . studly_case($data['document_type']);
        $document = $class_name::find($data['id']);
        return response([
            'url' => route('document.download', ['id' => $document->id, 'document_type' => $data['document_type']]),
            'status' => 'success',
            'message' => 'Download in corso'
        ], 200);
    }

    public function downloadDocument($document_type, $id)
    {
        $class_name = 'App\\' . studly_case($document_type);
        $file = $class_name::find($id);
        return response()->download(storage_path('app/' . $file->path), $file->name);
    }

    public function deleteDocument($document_type, $id)
    {
        $class_name = 'App\\' . studly_case($document_type);
        $class_name::destroy($id);
        return response([
            'status' => 'success',
            'message' => 'Documento eliminato correttamente'
        ], 200);
    }
}
