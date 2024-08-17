<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function storagePutManualFiles()
    {
        // The `get` method used to retrieve the passed file name from `storage/public`
        // $file = Storage::disk('public')->get('test_02.png');

        /* The `put` method allows you pass the file name in the first parameter and the content file in the second parameter */
        $requestFile = request()->file;

        return Storage::disk('public')->put(md5($requestFile->getClientOriginalName()) . '.' . $requestFile->getClientOriginalExtension(), file_get_contents($requestFile));

        if (Storage::exists('public/test_02.png')) {
            /* The `getVisivbility` method allows you to get a visibility for a specific file in `app/storage` if public or private */
            if (Storage::getVisibility('public/test_02.png') == 'private') {
                /* The `setVisibility` method allows you to set specific file in `app/storage` to visibility value (public, private) */
                Storage::setVisibility('public/test_02.png', 'public');
            }
        }

        // The `copy` method allows you to copy a file
        // Storage::copy('public/test_02.png', 'copiedFiles/newCopiedFile.png');

        // The `move` method allows you to move a file
        // Storage::move('public/test_02.png', 'movedFiles/newMovedFile.png');

        // The `size` method allows you to get size of file in kilobytes
        // Storage::size('movedFiles/newMovedFile.png');

        // The `delete` method allows you to delete file
        // Storage::delete('movedFiles/newMovedFile.png');

        // The `files` method allows you to return an array of files in a specific path
        // Storage::files('public');

        // The `lastModified` allows you to return Unix timestamp when passed file was last modified
        // Storage::lastModified('copiedFiles/newCopiedFile.png');

        // The `allFiles` method allows you to return an array of files in specific folder with it's subfolders
        // Storage::allFiles('public');

        // The `directories` method allows you to return an array of folders names in passed directory
        // Storage::directories('public');

        /* The `allDirectories` method allows you to return an array of folders names in passed directory and all sub folders */
        // Storage::allDirectories('public');

        // The `makeDirectory` method allows you to create a new directory
        // Storage::makeDirectory('newCreatedDirectory');

        // The `deleteDirectory` method allows you to delete a directory
        Storage::deleteDirectory('newCreatedDirectory');
    }

    public function storagePutUploadedFiles()
    {
        /* NOTE: The `exists` method will always pass the request's file because this method checks for passed file name and when you use `putFile` Laravel will hash the file name and then save it so, every time, it will come with a new hash value */
        if (!Storage::disk('public')->exists(request()->img)) {
            Storage::putFile('movedFiles', request()->file('img'));

            return 'uploaded...';
        }

        return 'not uploaded successfully or this file is already exists';
    }

    /* If you'd prefer injecting an instance instead of using the File facade, typehint or inject `Illuminate\Filesystem\Filesystem` and you'll have all the same methods available to you */

    public function updatePicture()
    {
        /* We use `put` method to put a file named `user_1` (do not forget the extension), and grab our contents from the uploaded file. Every uploaded file is a descendant of the `SplFileInfo` class, which provides a `getRealPath` method that returns the tmp file path like so `C:\xampp\tmp\phpD91C.tmp` */
        Storage::put('user_1.png', file_get_contents(request()->file('img')->getRealPath()));
    }

    public function downloadImageFile()
    {
        if (request()->hasFile('img')) {
            // NOTE: The `download` method does not exists
            return Storage::download(request()->file('img'), 'welcome');
        }

        return 'there is no uploaded file';
    }
}
