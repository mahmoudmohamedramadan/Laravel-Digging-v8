<?php

namespace App\Http\Controllers\Storage;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    public function storagePutManualFiles()
    {
        /* `get` function used to retrieve the passed file name from storage/public */
        // $file = Storage::disk('public')->get('test_02.png');

        /* `put` method allows you pass the file name in the first parameter and the content file in the second parameter */
        $requestFile = request()->file;

        return Storage::disk('public')->put(md5($requestFile->getClientOriginalName()) . '.' . $requestFile->getClientOriginalExtension(), file_get_contents($requestFile));

        if (Storage::exists('public/test_02.png')) {
            /* `getVisivbility` function allows you to get a visibility for a specific file in `app/storage` if public or private */
            if (Storage::getVisibility('public/test_02.png') == 'private') {
                /* `setVisibility` allows you to set specific file in `app/storage` to visibility value [public, private] */
                Storage::setVisibility('public/test_02.png', 'public');
            }
        }

        /* `copy` method allows you to copy file in `app/storage` into new place in `app/storage` also */
        // Storage::copy('public/test_02.png', 'copiedFiles/newCopiedFile.png');

        /* `move` method allows you to move file in `app/storage` into new place in `app/storage` also  */
        // Storage::move('public/test_02.png', 'movedFiles/newMovedFile.png');

        /* `size` method allows you to get size of file in kilobytes */
        // Storage::size('movedFiles/newMovedFile.png');

        /* `delete` method allows you to delete file in app/storage */
        // Storage::delete('movedFiles/newMovedFile.png');

        /* `files` method allows you to return an array of files in specific folder */
        // Storage::files('public');

        /* `lastModified` allows you to return Unix timestamp when passed file was last modified */
        // Storage::lastModified('copiedFiles/newCopiedFile.png');

        /* `allFiles` method allows you to return an array of files in specific folder with it's subfolders */
        // Storage::allFiles('public');

        /* `directories` allows you to return an array of folders names in passed directory */
        // Storage::directories('public');

        /* `allDirectories` allows you to return an array of folders names in passed directory and all sub folders */
        // Storage::allDirectories('public');

        /* `makeDirectory` allows you to create a new directory */
        // Storage::makeDirectory('newCreatedDirectory');

        /* `deleteDirectory` allows you to delete a directory */
        Storage::deleteDirectory('newCreatedDirectory');
    }

    public function storagePutUploadedFiles()
    {
        /* NOTE that `exists` method will always passes the request's file because this method check for passed file name and when you use `putFile` laravel will hash file name then save it So, every time will come with new hash value So will passes from `exists` method */
        if (!Storage::disk('public')->exists(request()->img)) {
            Storage::putFile('movedFiles', request()->file('img'));

            return 'uploaded...';
        }

        return 'NOT uploaded successfully or this file is already exists';
    }

    /* if you'd prefer injecting an instance instead of using the File facade, typehint or inject `Illuminate\Filesystem\Filesystem` and you'll have all the same methods available to you */

    public function updatePicture()
    {
        /* we use `put` method to put a file named `user_1` [do NOT forget THE extension], and we grab our contents from the uploaded file. Every uploaded file is a descendant of the `SplFileInfo` class, which provides a `getRealPath` method that returns the tmp file path like so `C:\xampp\tmp\phpD91C.tmp` */
        // Storage::put('user_1.png', file_get_contents(request()->file('img')->getRealPath()));
    }

    public function downloadImageFile()
    {
        if (request()->hasFile('img')) {
            /* `download` method does NOT exists */
            return Storage::download(request()->file('img'), 'welcome');
        }

        return 'there is no uploaded file';
    }
}
