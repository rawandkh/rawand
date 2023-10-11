<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CollegeController;
use App\Http\Controllers\Api\ImportantQuestionController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\TermController;
use App\Http\Controllers\ChoiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});

Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'auth'], function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
});
/*
|--------------------------------------------------------------------------
| profiel Routes
|--------------------------------------------------------------------------
*/
Route::post('auth/profile/{user_id}', [ProfileController::class, 'update'])->name('profile.updaet');
Route::get('auth/profile/{user_id}', [ProfileController::class, 'userInfo'])->name('profile.user');


/*
|--------------------------------------------------------------------------
| Colleges Routes
|--------------------------------------------------------------------------
*/
Route::get('colleges/', [CollegeController::class, 'index'])->name('college.index');

/*
|--------------------------------------------------------------------------
| Categories Routes
|--------------------------------------------------------------------------
*/
Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');

/*
|--------------------------------------------------------------------------
| Subjects Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:sanctum'], function () {
});
Route::get('subjects/{college_id}', [SubjectController::class, 'index'])->name('subject.index');



/*
|--------------------------------------------------------------------------
| Terms Routes
|--------------------------------------------------------------------------
*/
Route::get('terms/{college_id}', [TermController::class, 'index'])->name('terms.index');

/*
|--------------------------------------------------------------------------
| Questions Routes
|--------------------------------------------------------------------------
*/

Route::get('questions/{id}', [QuestionController::class, 'index'])->name('questions.index');
Route::get('questions-answers/', [QuestionController::class, 'correctQuestions'])->name('questions.answres');
Route::get('subject-questions/{id}', [QuestionController::class, 'subjectQuestions'])->name('questions.subject.term');
Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('important-questions', [ImportantQuestionController::class, 'getImportantQuestions'])->name('important');
    Route::post('important-questions', [ImportantQuestionController::class, 'store'])->name('importants.store');
    Route::delete('important-questions', [ImportantQuestionController::class, 'destroy'])->name('importants.delete');
});
Route::post('questions/{subject_id}', [QuestionController::class, 'store'])->name('questions.store');



/*terms
|--------------------------------------------------------------------------
| Slider Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:sanctum'], function () {
});
Route::get('sliders/', [SliderController::class, 'index'])->name('questions.index');







/*
|--------------------------------------------------------------------------
| ------------------- Data Entry Routes ---------------------
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function () {
    /*
    |--------------------------------------------------------------------------
    | Categories Routes
    |--------------------------------------------------------------------------
    */
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('categories/{id}', [CategoryController::class, 'destroy'])->name('categories.delete');

    /*
    |--------------------------------------------------------------------------
    | Colleges Routes
    |--------------------------------------------------------------------------
    */
    Route::post('colleges/{id}', [CollegeController::class, 'store'])->name('college.store');
    Route::post('colleges/{id}', [CollegeController::class, 'update'])->name('college.update');

    /*
    |--------------------------------------------------------------------------
    | Subjects Routes
    |--------------------------------------------------------------------------
    */
    Route::post('subjects/{id}', [SubjectController::class, 'store'])->name('subject.store');
    Route::delete('subjects/{id}', [SubjectController::class, 'destroy'])->name('subject.delete');



    /*
    |--------------------------------------------------------------------------
    | Terms Routes
    |--------------------------------------------------------------------------
    */
    Route::post('terms/{college_id}', [TermController::class, 'store'])->name('terms.store');
    Route::delete('terms/{id}', [TermController::class, 'destroy'])->name('terms.delete');



    /*
    |--------------------------------------------------------------------------
    | Questions Routes
    |--------------------------------------------------------------------------
    */
    Route::post('questions/{subject_id}', [QuestionController::class, 'store'])->name('questions.store');
    Route::delete('questions/{id}', [QuestionController::class, 'destroy'])->name('questions.delete');

    /*
    |--------------------------------------------------------------------------
    | Choices Routes
    |--------------------------------------------------------------------------
    */

    Route::post('choices/{question_id}', [ChoiceController::class, 'store'])->name('choices.store');
    Route::delete('choices/{id}', [ChoiceController::class, 'destroy'])->name('choices.delete');



    /*
    |--------------------------------------------------------------------------
    | Slider Routes
    |--------------------------------------------------------------------------
    */
    Route::post('sliders/', [SliderController::class, 'store'])->name('sliders.store');
    Route::delete('sliders/{id}', [SliderController::class, 'destroy'])->name('sliders.delete');
});
// Route::get('sliders/', [SliderController::class, 'index'])->name('questions.index');