<?php

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

use App\Category;
use App\Http\Controllers\AccountingFlowController;
use App\Http\Controllers\ActiveClientsController;
use App\Http\Controllers\AgreementsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClientPlanController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\VirtualTrainingsController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SesionClienteController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TyCController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\WellBeingController;
use App\Http\Controllers\AccountingCloseController;
use App\Http\Controllers\WellBeignStatusController;
use App\Http\Services\ProcessPaymentWompi;
use App\Model\Cliente;
use App\Model\ClientPlan;
use App\PaymentMethod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AchievementController;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/{branch}/user/{user}/home', 'HomeController@index')->name('home');
    Route::put('/user/{user}/home', [ProfileController::class, 'actualizarPerfil'])->name('actualizarPerfil');
    Route::get('/visitar/{user}', [HomeController::class, 'visitar'])->name('visitarPerfil');

    Route::get('/user/{user}', 'ProfileController@index')->name('profile');

    Route::get('/{branch}/eventos/{event}/{date}/{hour}/{isEdited}', [EventController::class, 'show'])->name('eventos.show');
    //TODO: crear, actualizar y borrar evento
    Route::get('/eventos/crear', [EventController::class, 'create'])->name('eventos.create');
    Route::post('/eventos/crear', [EventController::class, 'save'])->name('eventos.store');
    //Route::get('/eventos', [SesionEventoController::class, 'fullcalendar'])->name('eventos');

    Route::post('/agendar', [SesionClienteController::class, 'save'])->name('agendar');

    Route::get('/response_payment', [PagosController::class, 'responsePayment']);
    Route::get('/wompiSignature', [ProcessPaymentWompi::class, 'ajaxSignature'])->name('wompiSignature');

    Route::post('/scheduleEvent', [SesionClienteController::class, 'scheduleEvent'])->name('scheduleEvent');
    Route::post('/dar_review_entrenamiento/', [SesionClienteController::class, 'darReview'])->name('darReviewEntrenamiento');
    Route::delete('/cancelar_entrenamiento', [SesionClienteController::class, 'cancelTraining'])->name('cancelarEntrenamiento');
    Route::get('/planes/{plan}', [PlanController::class, 'show'])->name('plan');

    Route::get('/clientLastPlanWithRemainingClasses', [ClientPlan::class, 'clientLastPlanWithRemainingClasses'])->name('clientLastPlanWithRemainingClasses');


    Route::get('/{branch}/nextSessions', [EventController::class, 'nextSessions'])->name('nextSessions');

    Route::post('/admin/checkAttendee', [SesionClienteController::class, 'checkAttendee'])->name('checkAttendee');

    Route::post('{user}/comment/', [UserCommentController::class, 'comment'])->name('commentUser');
    Route::post('{comment}/reply/', [UserCommentController::class, 'reply'])->name('replyUserComment');

    Route::post('/reorderKangoos', [EventController::class, 'reorderKangoos'])->name('reorderKangoos');

    Route::post('/paymentSubscription',[PagosController::class, 'paymentSubscription'])->name('paymentSubscription');

    Route::post('/signTyC',[TyCController::class, 'signTyC'])->name('signTyC');

    Route::get('/agreements', [AgreementsController::class, 'index'])->name('agreements');
    Route::post('/generate-qr', [AgreementsController::class, 'generateQr'])->name('generate.qr');

    Route::get('/virtualTrainings', [VirtualTrainingsController::class, 'index'])->name('virtualTrainings');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/{branch}/statistics', [StatisticsController::class, 'index'])->name('statistics');

    Route::get('/admin/saveActiveClients/{date}', [ActiveClientsController::class, 'saveActiveClientByDate']);//TODO: add logic for branch
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' .\App\Utils\FeaturesEnum::MAKE_WELLBEING_TEST->value])->group(function () {
    Route::get('/user/{user}/wellBeingTest', [WellBeingController::class, 'index'])->name('healthTest');
    Route::post('/user/{user}/wellBeingTest', [WellBeingController::class, 'processWellBeingTest'])->name('wellBeingTest');
    Route::post('/physicalTest', [WellBeingController::class, 'savePhysicalTest'])->name('savePhysicalTest');
    Route::post('/foodTest', [WellBeingController::class, 'saveFoodTest'])->name('saveFoodTest');
    Route::post('/trainingTest', [WellBeingController::class, 'saveTrainingTest'])->name('saveTrainingTest');
    Route::post('/wellbeingTest', [WellBeingController::class, 'saveWellBeingTest'])->name('saveWellBeingTest');
    Route::post('/wheelOfLifeTest', [WellBeingController::class, 'saveWheelOfLifeTest'])->name('saveWheelOfLifeTest');
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' .\App\Utils\FeaturesEnum::CHANGE_CLIENT_FOLLOWER->value])->group(function () {
    Route::post('/users/assigned', [UserController::class, 'updateAssigned'])->name('assigned.update');
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' .\App\Utils\FeaturesEnum::LOAD_CLIENT_PLAN->value])->group(function () {
    Route::get('/admin/loadPlan', [ClientPlanController::class, 'showLoadClientPlan'])->name('loadPlan');
    Route::post('/admin/loadPlan', [ClientPlanController::class, 'saveClientPlan'])->name('saveClientPlan');
    Route::get('/admin/freezePlan', [ClientPlanController::class, 'showFreezeClientPlan'])->name('freezePlan.index');
    Route::post('/admin/freezePlan', [ClientPlanController::class, 'freezePlan'])->name('freezePlan');
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' . \App\Utils\FeaturesEnum::SEE_MAYOR_CASH->value])->group(function () {
    Route::get('/AccountingClose', [AccountingCloseController::class, 'AccountingClose'])->name('AccountingClose');//TODO: add logic for branch
    Route::get('/AccountingDetails', [AccountingCloseController::class, 'AccountingDetails'])->name('AccountingDetails');//TODO: add logic for branch
    Route::get('/transactions/search', [AccountingCloseController::class, 'search'])->name('transactions.search');
});
Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' .\App\Utils\FeaturesEnum::CHANGE_TRANSACTION_CATEGORY->value])->group(function () {
    Route::post('/transactions/category', [AccountingCloseController::class, 'updateCategory'])->name('transactions.category.update');
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' . \App\Utils\FeaturesEnum::SEE_MAYOR_CASH->value . ',' . \App\Utils\FeaturesEnum::class . '-' . \App\Utils\FeaturesEnum::SEE_PETTY_CASH->value])->group(function () {
    Route::get('/AccountingFlow', [AccountingFlowController::class, 'AccountingFlow'])->name('AccountingFlow');//TODO: add logic for branch
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' .\App\Utils\FeaturesEnum::SAVE_PETTY_CASH->value])->group(function () {
    Route::get('/savePettyCash', function () {//TODO: add logic for branch
        $clients = Cliente::all();
        $paymentMethods = PaymentMethod::where('enabled', true)->get();
        $categories = Category::all();
        return view('admin.savePettyCash', compact('clients', 'paymentMethods', 'categories'));
    })->name('pettyCash.index');
    Route::post('/savePettyCash', [PagosController::class, 'savePettyCash'])->name('pettyCash.save');
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' . \App\Utils\FeaturesEnum::SEE_USERS->value])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/update-physical-photo-status/{user}', [UserController::class, 'updatePhysicalPhotoStatus']);
    Route::post('/updateWaGroupStatus/{user}', [UserController::class, 'updateWaGroupStatus']);
});

Route::middleware(['auth', 'check.feature:' . \App\Utils\FeaturesEnum::class . '-' . \App\Utils\FeaturesEnum::SEE_ACHIEVEMENTS_WEEKS_RANK->value])->group(function () {
    Route::get('/achievementsWeeksRank', [AchievementController::class, 'showAchievements'])->name('achievementsWeeksRank');
});

/*Open routes*/
    Auth::routes();

    Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

    Route::get('/planes', [PlanController::class, 'index'])->name('plans');

    Route::post('notification/get', 'NotificationController@get');
    Route::post('/notification/read', 'NotificationController@read');

    Route::get('auth/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.auth');
    Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');

    Route::get('/blogs', 'BlogsController@allBlogs')->name('blogs');
    Route::get('/{user}/blog', 'BlogsController@blogUsuario')->name('blogsUsuario');
    Route::get('/blog/{blog}', 'BlogsController@verBlog')->name('blog');
    Route::post('/comentar/{blog}', 'BlogsController@comentarBlog')->name('comentarblog');
    Route::post('/reply/{comentario}', 'BlogsController@replyComentario')->name('replyComentario');

    Route::get('/loadSessions',[EventController::class, 'ajaxNextSessions'])->name('loadSessions');

    Route::post('/scheduleCourtesy',[SesionClienteController::class, 'scheduleCourtesy'])->name('scheduleCourtesy');
    Route::post('/scheduleGuest',[SesionClienteController::class, 'scheduleGuest'])->name('scheduleGuest');

    Route::get('/TyC', function () {
        return view('termsAndConditionsPage');
    });

    Route::post('/webhook_payment', [PagosController::class, 'responsePayment']);

    Route::post('/change-branch', [BranchController::class, 'changeBranch'])->name('change-branch');
/*End Open routes*/
