<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{GeneralController, HasManyController, RequestController, Dashboard\UserAPIController, ResponseController, CollectionController, Dashboard\UserInvokableController, Dashboard\PhoneNumberRuleController};

Route::apiResource('userApi', UserAPIController::class);

// Invokable controller allows you to call on magic method `__invoke` once you call the controller
Route::get('userI', UserInvokableController::class);

// `redirect` method redirects you from one URI to other
Route::redirect('redirectHome', '/home');

Route::get('convert', function () {
    return htmlentities('<h1>welcome</h1>');
});

Route::get('hasMany', [HasManyController::class, 'index']);

Route::view('template', 'book',  [
    'normalEcho' => 'Normal',
    'directiveEcho' => 'Directive',
    'lettersArray' =>  ['a', 'b', 'c']
]);

Route::view('component', 'includes.passed_data');

Route::get('collection', [CollectionController::class, 'index']);

Route::get('helpers', [GeneralController::class, 'helper']);
Route::get('locale', [GeneralController::class, 'localization']);

Route::get('requestView', [RequestController::class, 'requestView']);
Route::post('requestPost', [RequestController::class, 'indexPost']);
Route::post('requestPostFile', [RequestController::class, 'indexPostFile']);
Route::post('requestGet/{first}/{last}', [RequestController::class, 'indexGet'])->name('requestGET');
Route::post('requestMethods', [RequestController::class, 'userRequestAndState']);
Route::post('persistenceRequest', [RequestController::class, 'persistenceRequest']);

// You can pass a parameter to the middleware like `custom-middleware`
Route::middleware('custom-middleware:admin, home.blade.php')->group(function () {
    Route::get('response', [ResponseController::class, 'index']);
    Route::get('responseView/{user}', [ResponseController::class, 'indexView']);
    Route::get('responseDownload', [ResponseController::class, 'indexDownload']);
    Route::get('responseFile', [ResponseController::class, 'indexFile']);
    Route::get('responseJSON', [ResponseController::class, 'indexJSON']);
    Route::get('responseMacro', [ResponseController::class, 'indexCustom']);
});

Route::get('custom-rule', [PhoneNumberRuleController::class, 'create']);
Route::get('custom-rule-custom-request', [PhoneNumberRuleController::class, 'storeWithCustomRequest']);

Route::get('auth-info', function () {
    $user = User::first();

    // Check out `Illuminate\Contracts\Auth\Authenticatable` for more info
    return $user->getAuthIdentifierName();
    return $user->getAuthIdentifier();
    return $user->getAuthPassword();
});

// Laravel will resolve this function if your URL not match any route
Route::fallback(function () {
    abort(404);
});
