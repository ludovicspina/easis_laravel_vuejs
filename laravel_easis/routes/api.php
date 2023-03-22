<?php

use App\Http\Controllers\API\CdgController;
use App\Http\Controllers\API\DonjonsController;
use App\Http\Controllers\API\InstancesController;
use App\Http\Controllers\API\JoueursController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\HasApiTokens;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;



    // Sanctum
    Route::post('/login', function (Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = App\Models\User::where('email', '=', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth');
        return response()->json(['token' => $token->plainTextToken]);

    });



// Route::apiResource("cdg", CdgController::class);

Route::get('/cdg', [CdgController::class, 'index']);
Route::put('/cdg/add-one-item/{id}', [CdgController::class, 'addOneItem']);
Route::put('/cdg/remove-one-item/{id}', [CdgController::class, 'removeOneItem']);

Route::get('/joueurs', [JoueursController::class, 'index']);
Route::put('/joueurs/add-one-item/{id}', [JoueursController::class, 'addOneItem']);
Route::put('/joueurs/remove-one-item/{id}', [JoueursController::class, 'removeOneItem']);

Route::get('/users', [UserController::class, 'index']);

Route::get('/donjons/objets', [DonjonsController::class, 'objets']);
Route::get('/donjons/objets-joueurs', [DonjonsController::class, 'objetsJoueurs']);
Route::get('/donjons/count', [DonjonsController::class, 'objetsDonjonsJoueursCount']);
Route::post('/donjons/createItem', [DonjonsController::class, 'createItem']);

Route::get('/instances/all', [InstancesController::class, 'getAll']);
Route::get('/instances', [InstancesController::class, 'getInstances']);
Route::get('/instances/objets', [InstancesController::class, 'getInstancesObjets']);
Route::get('/instances/participants', [InstancesController::class, 'getInstancesParticipants']);
Route::get('/objets', [InstancesController::class, 'getBase']);
Route::post('/instance/add', [InstancesController::class, 'addInstance']);

Route::get('/instance/items', [InstancesController::class, 'getDungeonsItems']);
