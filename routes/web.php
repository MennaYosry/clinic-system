<?php
namespace App\Http\Middleware;

// use App\Http\Controllers\PatientController;
// use Illuminate\Support\Facades\Route;
 
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
 
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '*',
    ];
}
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
