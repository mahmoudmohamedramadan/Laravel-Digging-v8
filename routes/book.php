<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{GeneralController, HasManyController, RequestController, Dashboard\UserApiController, ResponseController, CollectionController, Dashboard\UserInvokableController, Dashboard\PhoneNumberRuleController};

Route::apiResource('userApi', UserApiController::class);

/* invokable controller allows you to call on magic method `__invok` once you call the controller */
Route::get('userI', UserInvokableController::class);

/* `redirect` method allows you to redirect from one uri to other */
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

/* you can pass a parameter to the middleware like `custom-middleware` */
Route::middleware('custom-middleware:admin, home.blade.php')->group(function () {
    Route::get('response', [ResponseController::class, 'index']);
    Route::get('responseView/{user}', [ResponseController::class, 'indexView']);
    Route::get('responseDownload', [ResponseController::class, 'indexDownload']);
    Route::get('responseFile', [ResponseController::class, 'indexFile']);
    Route::get('responseJSON', [ResponseController::class, 'indexJSON']);
    Route::get('responseMacro', [ResponseController::class, 'indexCustom']);
});

Route::get('custome_rule', [PhoneNumberRuleController::class, 'create']);
Route::get('custome_rule_custome_request', [PhoneNumberRuleController::class, 'storeWithCustomeRequest']);

Route::get('authInfo', function () {
    $user = User::first();

    // goto Illuminate\Contracts\Auth\Authenticatable for more info
    return $user->getAuthIdentifierName();
    return $user->getAuthIdentifier();
    return $user->getAuthPassword();
});

/* laravel will resolve this function if your url NOT match any route */
Route::fallback(function () {
    abort(404);
});
