<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Candidate;
use App\Http\Controllers\User;
use App\Http\Controllers\MidtransController;
use App\Http\Middleware\isCandidate;
use App\Http\Middleware\isCreator;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isLogin;
use App\Http\Middleware\isAdmin;

// User-side
Route::name('user.')->group(function () {
    Route::get('/', [User\Controller::class, 'index'])->name('index');
    Route::get('/profile', [User\Controller::class, 'profile'])->name('profile');
    Route::get('/about', [User\Controller::class, 'about'])->name('about');
    Route::get('/visi-misi', [User\Controller::class, 'visiMisi'])->name('visi-misi');
    Route::get('/galleries', [User\Controller::class, 'galleries'])->name('galleries');
    Route::get('/facilities', [User\Controller::class, 'facilities'])->name('facilities');

    Route::get('/news', [User\NewsController::class, 'news'])->name('news');
    Route::get('/news/{article}', [User\NewsController::class, 'newsDetail'])->name('news-detail');
    Route::get('/news/{article}/content', [User\NewsController::class, 'newsContent'])->name('news-content');

    Route::controller(User\MajorsController::class)->prefix('majors')->name('majors.')->group(function () {
        Route::get('/animation', 'animation')->name('animation');
        Route::get('/broadcasting', 'broadcasting')->name('broadcasting');
        Route::get('/visual-communication-design', 'visualCommunicationDesign')->name('visual-communication-design');
        Route::get('/software-engineering', 'softwareEngineering')->name('software-engineering');
        Route::get('/network-engineering', 'networkEngineering')->name('network-engineering');
        Route::get('/game-development', 'gameDevelopment')->name('game-development');
    });

    Route::controller(User\ProgramsController::class)->prefix('programs')->name('programs.')->group(function () {
        Route::get('/program-silang', 'programSilang')->name('program-silang');
        Route::get('/baca-tulis-quran', 'bacaTulisQuran')->name('baca-tulis-quran');
        Route::get('/bimbingan-konseling', 'bimbinganKonseling')->name('bimbingan-konseling');
        Route::get('/program-kecakapan-hidup', 'programKecakapanHidup')->name('program-kecakapan-hidup');
        Route::get('/project-works', 'projectWorks')->name('project-works');
        Route::get('/bi-channel', 'biChannel')->name('bi-channel');

        Route::controller(User\ExtracurricularsController::class)->prefix('extracurriculars')->name('extracurriculars.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/merpati-putih', 'merpatiPutih')->name('merpati-putih');
            Route::get('/futsal', 'futsal')->name('futsal');
            Route::get('/basketball', 'basketball')->name('basketball');
            Route::get('/paduan-suara', 'paduanSuara')->name('paduan-suara');
            Route::get('/bicoustic', 'bicoustic')->name('bicoustic');
            Route::get('/tari-tradisional', 'tariTradisional')->name('tari-tradisional');
            Route::get('/english-club', 'englishClub')->name('english-club');
            Route::get('/paskibra', 'paskibra')->name('paskibra');
        });
    });

});

// Candidate-side
Route::name('candidate.')->prefix('candidate')->middleware([isLogin::class, isCandidate::class])->group(function () {
    Route::withoutMiddleware([isLogin::class, isCandidate::class])->group(function () {
        Route::get('/', [Candidate\Controller::class, 'index'])->name('index');

        Route::get('/signup', [Candidate\AuthController::class, 'signupPage'])->name('signup-page');
        Route::post('/signup', [Candidate\AuthController::class, 'signup'])->name('signup');
        Route::get('/login', [Candidate\AuthController::class, 'loginPage'])->name('login-page');
        Route::post('/login', [Candidate\AuthController::class, 'login'])->name('login');
        Route::post('/logout', [Candidate\AuthController::class, 'logout'])->name('logout');
    });

    Route::get('/dashboard', [Candidate\Controller::class, 'dashboard'])->name('dashboard');
    Route::get('/schedule', [Candidate\Controller::class, 'schedule'])->name('schedule');
    Route::get('/contact', [Candidate\Controller::class, 'contact'])->name('contact');
    Route::get('/learning-materials', [Candidate\Controller::class, 'learningMaterials'])->name('learning-materials');

    Route::controller(Candidate\StageController::class)->prefix('stage')->name('satge.')->group(function () {
        Route::get('/stage-1', 'stage1')->name('stage1');
        Route::put('/stage-1', 'saveStage1')->name('save-stage1');

        Route::get('/stage-2', 'stage2')->name('stage2');
        Route::put('/stage-2', 'saveStage2')->name('save-stage2');

        Route::get('/stage-3', 'stage3')->name('stage3');
        Route::put('/start-transaction', 'startTransaction')->name('start-transaction');
        Route::get('/transaction-status', 'transactionStatus')->name('transaction-status');

        Route::get('/stage-4', 'stage4')->name('stage4');
        Route::put('/stage-4', 'saveStage4')->name('save-stage4');

        Route::get('/stage-5', 'stage5')->name('stage5');
        Route::put('/stage-5', 'saveStage5')->name('save-stage5');
    });
});

// Admin-side
Route::name('admin.')->prefix('admin')->middleware([isLogin::class, isAdmin::class])->group(function () {
    Route::withoutMiddleware([isLogin::class, isAdmin::class])->group(function () {
        Route::get('/login', [Admin\AuthController::class, 'loginPage'])->name('login-page');
        Route::post('/login', [Admin\AuthController::class, 'login'])->name('login');
        Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');
    });

    Route::get('/settings', [Admin\Controller::class, 'settings'])->name('settings');
    Route::put('/settings', [Admin\Controller::class, 'updateSettings'])->name('update-settings');

    Route::get('/transactions', [Admin\TransactionController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/{transaction}', [Admin\TransactionController::class, 'detailTransaction'])->name('detail-transaction');
    Route::get('/transactions-add', [Admin\TransactionController::class, 'storeTransactionPage'])->name('add-transaction');
    Route::post('/transactions', [Admin\TransactionController::class, 'storeTransaction'])->name('store-transaction');
    Route::put('/transactions/{transaction}', [Admin\TransactionController::class, 'updateTransaction'])->name('update-transaction');
    Route::delete('/transactions/{transaction}', [Admin\TransactionController::class, 'deleteTransaction'])->name('delete-transaction');
    
    Route::get('/accounts', [Admin\AccountController::class, 'accounts'])->name('accounts');
    Route::get('/accounts-create', [Admin\AccountController::class, 'createAccount'])->name('create-account');
    Route::post('/accounts-create', [Admin\AccountController::class, 'storeAccount'])->name('store-account');
    Route::delete('/accounts/{account}', [Admin\AccountController::class, 'deleteAccount'])->name('delete-account');
    Route::patch('/account/reset-password/{account}', [Admin\AccountController::class, 'resetPassword'])->name('reset-password-account');

    Route::get('/students', [Admin\AccountController::class, 'student'])->name('students');
    Route::get('/students-create', [Admin\AccountController::class, 'createStudent'])->name('create-student');
    Route::post('/students-create', [Admin\AccountController::class, 'storeStudent'])->name('store-student');
    Route::get('/students/{student}', [Admin\AccountController::class, 'detailStudent'])->name('detail-student');
    Route::put('/students/{student}', [Admin\AccountController::class, 'updateStudent'])->name('update-student');
    Route::delete('/student/{student}', [Admin\AccountController::class, 'deleteStudent'])->name('delete-student');
    
    Route::get('/students', [Admin\StudentController::class, 'students'])->name('students');
    Route::get('/students-create', [Admin\StudentController::class, 'createStudent'])->name('create-student');
    Route::post('/students-create', [Admin\StudentController::class, 'storeStudent'])->name('store-student');
    Route::get('/students/{student}', [Admin\StudentController::class, 'detailStudent'])->name('detail-student');
    Route::put('/students/{student}', [Admin\StudentController::class, 'updateStudent'])->name('update-student');
    Route::delete('/students/{student}', [Admin\StudentController::class, 'deleteStudent'])->name('delete-student');
    
    Route::withoutMiddleware([isAdmin::class])->middleware([isCreator::class])->group(function () {
        Route::get('/dashboard', [Admin\Controller::class, 'dashboard'])->name('dashboard');
        Route::get('/accounts/{account}', [Admin\AccountController::class, 'detailAccount'])->name('detail-account');
        Route::put('/accounts/{account}', [Admin\AccountController::class, 'updateAccount'])->name('update-account');
        Route::get('/news', [Admin\NewsController::class, 'news'])->name('news');
        Route::get('/news-create', [Admin\NewsController::class, 'createNews'])->name('create-news');
        Route::post('/news-create', [Admin\NewsController::class, 'storeNews'])->name('store-news');
        Route::get('/news/{news}', [Admin\NewsController::class, 'detailNews'])->name('detail-news');
        Route::put('/news/{news}', [Admin\NewsController::class, 'updateNews'])->name('update-news');
        Route::delete('/news/{news}', [Admin\NewsController::class, 'deleteNews'])->name('delete-news');
    });

    Route::get('/medias', [Admin\MediaController::class, 'media'])->name('media');
    Route::get('/medias-create', [Admin\MediaController::class, 'createMedia'])->name('create-media');
    Route::post('/medias-create', [Admin\MediaController::class, 'storeMedia'])->name('store-media');
    Route::get('/medias/{media}', [Admin\MediaController::class, 'detailMedia'])->name('detail-media');
    Route::put('/medias/{media}', [Admin\MediaController::class, 'updateMedia'])->name('update-media');
    Route::delete('/medias/{media}', [Admin\MediaController::class, 'deleteMedia'])->name('delete-media');

    Route::get('/achievements', [Admin\AchievementController::class, 'achievement'])->name('achievement');
    Route::get('/achievements-create', [Admin\AchievementController::class, 'createAchievement'])->name('create-achievement');
    Route::post('/achievements-create', [Admin\AchievementController::class, 'storeAchievement'])->name('store-achievement');
    Route::get('/achievements/{achievement}', [Admin\AchievementController::class, 'detailAchievement'])->name('detail-achievement');
    Route::put('/achievements/{achievement}', [Admin\AchievementController::class, 'updateAchievement'])->name('update-achievement');
    Route::delete('/achievements/{achievement}', [Admin\AchievementController::class, 'deleteAchievement'])->name('delete-achievement');

    Route::get('/portfolios', [Admin\PortfolioController::class, 'portfolio'])->name('portfolio');
    Route::get('/portfolios-create', [Admin\PortfolioController::class, 'createPortfolio'])->name('create-portfolio');
    Route::post('/portfolios-create', [Admin\PortfolioController::class, 'storePortfolio'])->name('store-portfolio');
    Route::get('/portfolios/{portfolio}', [Admin\PortfolioController::class, 'detailPortfolio'])->name('detail-portfolio');
    Route::put('/portfolios/{portfolio}', [Admin\PortfolioController::class, 'updatePortfolio'])->name('update-portfolio');
    Route::delete('/portfolios/{portfolio}', [Admin\PortfolioController::class, 'deletePortfolio'])->name('delete-portfolio');

    Route::get('/facilities', [Admin\FacilityController::class, 'facility'])->name('facility');
    Route::get('/facilities-create', [Admin\FacilityController::class, 'createFacility'])->name('create-facility');
    Route::post('/facilities-create', [Admin\FacilityController::class, 'storeFacility'])->name('store-facility');
    Route::get('/facilities/{facility}', [Admin\FacilityController::class, 'detailFacility'])->name('detail-facility');
    Route::put('/facilities/{facility}', [Admin\FacilityController::class, 'updateFacility'])->name('update-facility');
    Route::delete('/facilities/{facility}', [Admin\FacilityController::class, 'deleteFacility'])->name('delete-facility');
});


Route::name('midtrans.')->prefix('midtrans')->middleware([isLogin::class])->group(function () {
    // URL ==> http://127.0.0.1:8000/midtrans/payment-notification
    Route::post('/payment-notification', [MidtransController::class, 'paymentNotification'])->name('payment-notification');
});

