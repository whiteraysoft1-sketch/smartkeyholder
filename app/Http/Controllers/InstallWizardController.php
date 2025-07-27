<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class InstallWizardController extends Controller
{
    public function showForm()
    {
        return view('install-wizard.upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'zip_file' => 'required|file|mimes:zip|max:20480', // 20MB max
        ]);
        $file = $request->file('zip_file');
        $unique = 'upload_' . Str::random(10);
        $path = $file->storeAs('installer_uploads', $unique . '.zip');
        return redirect()->route('install-wizard.confirm', ['zip' => $unique]);
    }

    public function confirm($zip)
    {
        $zipPath = storage_path('app/installer_uploads/' . $zip . '.zip');
        $fileList = [];
        if (file_exists($zipPath)) {
            $zipArchive = new ZipArchive;
            if ($zipArchive->open($zipPath) === true) {
                for ($i = 0; $i < $zipArchive->numFiles; $i++) {
                    $fileList[] = $zipArchive->getNameIndex($i);
                }
                $zipArchive->close();
            }
        }
        return view('install-wizard.confirm', compact('zip', 'fileList'));
    }

    public function extract($zip)
    {
        $zipPath = storage_path('app/installer_uploads/' . $zip . '.zip');
        $extractDir = storage_path('app/installer_uploads/' . $zip . '_extracted');
        if (!file_exists($zipPath)) {
            return redirect()->route('install-wizard.form')->withErrors(['File not found.']);
        }
        $zipArchive = new ZipArchive;
        if ($zipArchive->open($zipPath) === true) {
            if (!file_exists($extractDir)) {
                mkdir($extractDir, 0775, true);
            }
            $zipArchive->extractTo($extractDir);
            $zipArchive->close();
        }
        // Optionally delete the zip after extraction
        // unlink($zipPath);
        $files = collect(Storage::allFiles('installer_uploads/' . $zip . '_extracted'));
        return view('install-wizard.success', [
            'extractDir' => 'storage/app/installer_uploads/' . $zip . '_extracted',
            'files' => $files,
        ]);
    }
}
