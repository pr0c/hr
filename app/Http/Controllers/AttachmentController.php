<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller {
    public function getAttachment($file_id) {
        $file = File::find($file_id);
        return asset('uploads/' . $file->src);
    }

    public function getAttachments($id) {

    }

    public function addAttachment() {

    }

    public function removeAttachment($file_id) {
        $file = File::find($file_id);
        Storage::disk('uploads')->delete($file->src);
        $file->delete();
    }

    public function upload() {
        $uploadedFile = request()->file('file');
        $filename = time().$uploadedFile->getClientOriginalName();
        $file_content = file_get_contents($uploadedFile->getRealPath());
        Storage::disk('uploads')->put(
            $filename,
            $file_content
        );

        $file = new File();
        $file->src = $filename;
        $file->save();

        return $file;
    }
}