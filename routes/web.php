<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Web\Admin\Dashboard;
use App\Http\Controllers\Web\Admin\Services\Index as ServicesIndex;
use App\Http\Controllers\Web\Admin\Portfolio\Index as PortfolioIndex;
use App\Http\Controllers\Web\Admin\Testimonials\Index as TestimonialsIndex;
use App\Http\Controllers\Web\Admin\ProcessSteps\Index as ProcessStepsIndex;
use App\Http\Controllers\Web\Admin\Leads\Index as LeadsIndex;
use App\Http\Controllers\Web\Admin\Settings\Index as SettingsIndex;
use App\Http\Controllers\Web\Admin\HomeContent\Index as HomeContentIndex;
use App\Http\Controllers\Web\Admin\Blog\Index as BlogIndex;
use App\Http\Controllers\Web\Auth\Login;

Route::get('/license/activate', \App\Http\Controllers\Web\License\Activate::class)->name('license.activate');
Route::get('/install', \App\Http\Controllers\Web\Installer::class)->name('install');

// ─── Public ────────────────────────────────────────────────────────────────
Route::get('/', \App\Http\Controllers\Web\Landing::class)->name('home');
Route::get('/sitemap.xml', [\App\Http\Controllers\Web\SitemapController::class, 'index'])->name('sitemap');
Route::get('/services', \App\Http\Controllers\Web\Services::class)->name('services.index');
Route::get('/services/{slug}', [\App\Http\Controllers\Web\ServiceController::class, 'show'])->name('services.show');
Route::get('/projects', \App\Http\Controllers\Web\Projects::class)->name('projects.index');
Route::get('/projects/{slug}', [\App\Http\Controllers\Web\ProjectController::class, 'show'])->name('projects.show');
Route::get('/blog', \App\Http\Controllers\Web\Blog::class)->name('blog.index');
Route::get('/blog/{slug}', \App\Http\Controllers\Web\BlogShow::class)->name('blog.show');
Route::get('/contact', \App\Http\Controllers\Web\Contact::class)->name('contact');
Route::get('/privacy-policy', \App\Http\Controllers\Web\Legal::class)->name('legal.privacy');
Route::get('/terms-of-service', \App\Http\Controllers\Web\Legal::class)->name('legal.terms');
Route::post('/portfolio/{item}/like', \App\Http\Controllers\Web\PortfolioLikeController::class)->name('portfolio.like');

// ─── Auth ───────────────────────────────────────────────────────────────────
Route::get('/login', Login::class)->name('login');

Route::get('/lang/{locale}/{scope?}', function ($locale, $scope = null) {
    if (!in_array($locale, ['ar', 'en'])) {
        return redirect()->back();
    }

    // Default scope detection
    if (!$scope) {
        $referer = request()->header('referer');
        if ($referer && (str_contains($referer, '/admin') || str_contains($referer, '/login'))) {
            $scope = 'admin';
        } else {
            $scope = 'frontend';
        }
    }

    if ($scope === 'admin') {
        session()->put('locale_dashboard', $locale);
        $cookie = cookie()->forever('locale_dashboard', $locale);
    } else {
        session()->put('locale_landing', $locale);
        $cookie = cookie()->forever('locale_landing', $locale);
    }

    session()->save();

    return redirect()->back()->withCookie($cookie);
})->name('lang');

// ─── Admin ──────────────────────────────────────────────────────────────────
Route::get('/debug-lang', function() {
    return [
        'locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'test_translation' => __('Dashboard'),
        'all_sessions' => session()->all(),
    ];
});

Route::middleware(['auth', 'role:super-admin', 'license'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/home-content', HomeContentIndex::class)->name('admin.home_content');
    Route::get('/home-content/hero', \App\Http\Controllers\Web\Admin\HomeContent\Hero::class)->name('admin.home_content.hero');
    Route::get('/home-content/stats', \App\Http\Controllers\Web\Admin\HomeContent\Stats::class)->name('admin.home_content.stats');
    Route::get('/home-content/cta', \App\Http\Controllers\Web\Admin\HomeContent\Cta::class)->name('admin.home_content.cta');
    Route::get('/services', ServicesIndex::class)->name('admin.services');
    Route::get('/portfolio', PortfolioIndex::class)->name('admin.portfolio');
    Route::get('/testimonials', TestimonialsIndex::class)->name('admin.testimonials');
    Route::get('/process-steps', ProcessStepsIndex::class)->name('admin.process_steps');
    Route::get('/leads', LeadsIndex::class)->name('admin.leads');
    Route::get('/blog', BlogIndex::class)->name('admin.blog');
    Route::get('/pages', \App\Http\Controllers\Web\Admin\Pages\Index::class)->name('admin.pages');
    Route::get('/pages/create', \App\Http\Controllers\Web\Admin\Pages\Form::class)->name('admin.pages.create');
    Route::get('/pages/{id}/edit', \App\Http\Controllers\Web\Admin\Pages\Form::class)->name('admin.pages.edit');
    Route::get('/blog/categories', \App\Http\Controllers\Web\Admin\Blog\Categories::class)->name('admin.blog.categories');
    Route::get('/blog/create', \App\Http\Controllers\Web\Admin\Blog\Form::class)->name('admin.blog.create');
    Route::get('/blog/{id}/edit', \App\Http\Controllers\Web\Admin\Blog\Form::class)->name('admin.blog.edit');
    Route::get('/settings', SettingsIndex::class)->name('admin.settings');
    Route::get('/settings/license', \App\Http\Controllers\Web\Admin\Settings\License::class)->name('admin.settings.license');
    Route::get('/visitor-logs', \App\Http\Controllers\Web\Admin\VisitorLogs\Index::class)->name('admin.visitor_logs');
    Route::get('/profile', \App\Http\Controllers\Web\Common\Profile::class)->name('admin.profile');
    Route::post('/editor/upload-image', \App\Http\Controllers\Web\Admin\EditorImageUpload::class)->name('admin.editor.upload_image');
});

Route::get('/{slug}', \App\Http\Controllers\Web\PageShow::class)->name('pages.show');

Route::middleware('auth')->post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
