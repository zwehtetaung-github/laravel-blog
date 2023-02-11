<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryApiController;

#GET /categories -> index()
#GET /categories/{id} -> show()
#POST /categories -> store()
#PUT /categories/{id} -> update()
#DELETE /categories/{id} -> destory()

Route::apiResource('/categories', CategoryApiController::class)->middleware('auth:sanctum');

// 1|ygGIptW3IitAKkEnSmZETN7ZOcsvcR3CosJ7j8ep
Route::post('/login', function(){
    $email = request()->email;
    $password = request()->password;

    $user = App\Models\User::where("email", $email)->first();

    if(!$user) return response("Incorrect email", 403);

    if(password_verify($password, $user->password)){
        return $user->createToken("Firefox")->plainTextToken;
    }
    return response("Incorrect password", 403);
});

Route::delete('/logout', function(){
    request()->user()->tokens()->delete();

    return "Logout successfully";

})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
