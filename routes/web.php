<?php

use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\FooterController;
use App\Http\Controllers\Admin\LinkController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\WebsiteInfoController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PromotionController;

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\Admin\AdminRoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\SlideController;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IsbnRequestController;
use App\Http\Controllers\BookController;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PublisherController;

use App\Http\Controllers\Admin\OrderController;



/*
|--------------------------------------------------------------------------
*/

// Route::get('/fetch_book_cover', [HomeController::class, 'fetchAndSaveBookCover']);

Route::get('/expired', function () {
    return view('auth.expired');
})->name('expired');
Route::get('/in_review', function () {
    return view('auth.in_review');
})->name('in_review');

Route::get('/static', function () {
    return view('static');
});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'auth',
    'middleware' => 'check_user_status',
    'prefix' => 'admin',
    'as' => 'admin.'
], function() {



    Route::resource('bulletins', NewsController::class);
    Route::get('bulletins_types', [NewsController::class, 'types']);
    Route::get('bulletins_categories', [NewsController::class, 'categories']);
    Route::get('bulletins_sub_categories', [NewsController::class, 'sub_categories']);
    Route::get('bulletins_images/{id}', [NewsController::class, 'images']);

    Route::resource('promotions', PromotionController::class);

    Route::resource('permissions', AdminPermissionController::class);
    Route::resource('roles', AdminRoleController::class);
    Route::get('roles/{id}/give-permissions', [AdminRoleController::class, 'givePermissionsToRole']);
    Route::put('roles/{id}/give-permissions', [AdminRoleController::class, 'updatePermissionsToRole']);
    Route::resource('users', AdminUserController::class );
    Route::put('users/{user}/update_password', [AdminUserController::class, 'updateUserPassword']);

    Route::resource('settings/menus', MenuController::class );
    Route::resource('settings/slides', SlideController::class );
    Route::resource('settings/footer', FooterController::class );
    Route::get('settings/contact', [MenuController::class, 'contact'] );
    Route::get('settings/about', [MenuController::class, 'about'] );
    Route::resource('settings/features', FeatureController::class );
    Route::resource('settings/links', LinkController::class );
    Route::resource('settings/databases', DatabaseController::class );
    Route::resource('settings/website_infos', WebsiteInfoController::class );
});
/*
|--------------------------------------------------------------------------
| End Admin Routes
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Start Client Routes
|--------------------------------------------------------------------------
*/
Route::get('/switch-language/{locale}', function($locale){
    session(['locale' => $locale]);
    return redirect()->back();
})->name('switch-language');

Route::group([
    'middleware' => ['setLang', 'auth'],
    // 'middleware' => 'publsiher_auth',
    // 'middleware' => 'check_user_status',
], function () {
    Route::resource('isbn_requests', IsbnRequestController::class);
    Route::resource('admin/books', BookController::class);
     Route::resource('admin/orders', OrderController::class );
    Route::get('admin/categories', [BookController::class, 'categories']);
    Route::get('admin/sub_categories', [BookController::class, 'sub_categories']);

    Route::resource('admin/people/authors', AuthorController::class);
    Route::resource('admin/people/publishers', PublisherController::class);
});

Route::group([
    'middleware' => ['setLang', 'auth'],
], function () {
    Route::get('/', function () {
        // return redirect('/isbn_requests');
        return redirect('admin/books');
    });

});


Route::group([
    'middleware' => 'setLang',
], function () {
    Route::get('publisher/{id}', [IsbnRequestController::class, 'publisher']);
    Route::get('admin_login', [IsbnRequestController::class, 'admin_login']);
    Route::post('admin_login', [IsbnRequestController::class, 'store_admin_login']);
    // Route::get('publisher_register', [IsbnRequestController::class, 'publisher_register']);
    // Route::post('publisher_register', [IsbnRequestController::class, 'store_publisher_register']);
});

/*
|--------------------------------------------------------------------------
| End Client Routes
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Start Initial Project Route
|--------------------------------------------------------------------------
*/
Route::group([
    'middleware' => 'role:super-admin|admin'
], function() {
    Route::resource('permissions', PermissionController::class);
    Route::get('permissions/{id}/delete', [PermissionController::class, 'destroy']);

    Route::resource('roles', RoleController::class);
    Route::get('roles/{id}/delete', [RoleController::class, 'destroy']);
    Route::get('roles/{id}/give-permissions', [RoleController::class, 'givePermissionsToRole']);
    Route::put('roles/{id}/give-permissions', [RoleController::class, 'updatePermissionsToRole']);

    Route::resource('users', UserController::class);
    Route::put('users/{user}/update-password', [UserController::class, 'updateUserPassword']);
    Route::get('users/{user}/delete', [UserController::class, 'destroy']);
});

Route::get('ckeditor4-demo', function() {
    return view('ckeditor-demo.ckeditor4-demo');
})->name('ckeditor4');

Route::get('ckeditor5-demo', function() {
    return view('ckeditor-demo.ckeditor5-demo');
})->name('ckeditor5');

Route::get('slide-infinite-loop', function() {
    return view('slide-show.slide-infinite-loop');
})->name('slide-infinite-loop');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ============================================

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__ . '/auth.php';
