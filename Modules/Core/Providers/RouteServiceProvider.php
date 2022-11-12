<?php

namespace Modules\Core\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
  /**
   * The module namespace to assume when generating URLs to actions.
   *
   * @var string
   */
  protected $moduleNamespace = 'Modules\Core\Http\Controllers';


  /**
   * Register any application services.
   *
   * @return void
   * @author BaRaa
   */
  public function register()
  {
    /**
     * call authApiRoutes Macro
     *
     * @author BaRaa
     */
    $this->authApiRoutes();

    /**
     * call resourceRoutes Macro
     *
     * @author BaRaa
     */
    $this->resourceRoutes();

    /**
     * call callAppendsRoutes Macro
     *
     * @author BaRaa
     */
    $this->callAppendsRoutes();

    /**
     * call uploadingRoutes Macro
     *
     * @author BaRaa
     */
    $this->uploadingRoutes();

    $this->resourceRoutesWithPermission();
  }

  /**
   * call resourceRoutes Macro
   *
   * @author BaRaa
   */
  public function resourceRoutes()
  {
    Route::macro('resourceRoutes', function ($resource, $controller, $function = null) {
      /**
       * Generate resource default rest-full routes
       *
       * @param $resource
       * @param string $controller
       * @return string
       * @author BaRaa
       */
      Route::resource($resource, $controller);
      Route::patch($resource . '/delete/group', $controller . '@deleteGroup');
      Route::match(["put", "patch"], "$resource/{id}/status", "$controller@updateStatus");
      Route::match(["put", "patch"], "$resource/order/list", "$controller@order");
      Route::match(["post", "patch"], "$resource/import", "$controller@import");

      if (is_callable($function))
        Route::group(['prefix' => $resource], function () use ($function, $controller, $resource) {
          call_user_func($function, $controller, $resource);
        });
      return $this;
    });
  }
  public function resourceRoutesWithPermission()
  {
    Route::macro('resourceRoutesWithPermission', function ($resource, $controller, $function = null) {
      /**
       * Generate resource default rest-full routes
       *
       * @param $resource
       * @param string $controller
       * @return string
       * @author BaRaa
       */
      Route::group(['prefix' => $resource, 'as' => "$resource."], function () use ($function, $controller, $resource) {
        Route::get('/', ['as' => 'index', 'uses' => $controller . '@index'])->middleware('permission:' . $resource . '.show');
        Route::get('/{id}', ['as' => 'index', 'uses' => $controller . '@show'])->middleware('permission:' . $resource . '.show');

        Route::get('/create', ['as' => 'create', 'uses' => $controller . '@create'])->middleware('permission:' . $resource . '.create');
        Route::post('/', ['as' => 'store', 'uses' => $controller . '@store'])->middleware('permission:' . $resource . '.create');

        Route::get('/edit', ['as' => 'edit', 'uses' => $controller . '@edit'])->middleware('permission:' . $resource . '.edit');
        Route::put('/{id}', ['as' => 'update', 'uses' => $controller . '@update'])->middleware('permission:' . $resource . '.edit');

        Route::delete('/{id}', ['as' => 'delete', 'uses' => $controller . '@delete'])->middleware('permission:' . $resource . '.delete');

        Route::patch('/delete/group', ['as' => 'delete-group', 'uses' => $controller . '@deleteGroup'])->middleware('permission:' . $resource . '.destroy');
        Route::match(["put", "patch"], "/{id}/status", ['as' => 'status', 'uses' => $controller . '@updateStatus'])->middleware('permission:' . $resource . '.edit');
        Route::match(["put", "patch"], "/order/list", ['as' => 'ordering', 'uses' => $controller . '@order'])->middleware('permission:' . $resource . '.edit');
      });

      if (is_callable($function))
        Route::group(['prefix' => $resource, 'as' => "$resource."], function () use ($function, $controller, $resource) {
          call_user_func($function, $controller, $resource);
        });
      return $this;
    });
  }

  /**
   * call authApiRoutes Macro
   *
   * @author BaRaa
   */
  public function authApiRoutes()
  {
    Route::macro('authApiRoutes', function ($controller = "AuthController") {
      /**
       * Generate module authentication routes
       * Default controller AuthController
       *
       * @param string $controller
       * @return string
       * @author BaRaa
       */
      Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () use ($controller) {
        Route::post('login', ['as' => 'login', 'uses' => "$controller@login"]);
        Route::get('logout', ['as' => 'logout', 'uses' => "$controller@logout"]);
        Route::get('refresh', ['as' => 'refresh', 'uses' => "$controller@refresh"]);
      });
      return $this;
    });
  }


  /**
   * call uploadingRoutes Macro
   *
   * @author BaRaa
   */
  public function uploadingRoutes()
  {
    Route::macro('uploadingRoutes', function ($middleware = "", $controller = "AttachmentController") {
      /**
       * Generate module uploading routes
       * Default controller AttachmentController
       *
       * @param string $controller
       * @return string
       * @author BaRaa
       */
      Route::group(['prefix' => 'upload', 'as' => 'upload.', 'middleware' => $middleware], function () use ($controller) {
        Route::post('image', ['as' => 'image_', 'uses' => "$controller@imageUpload"]);
        Route::post('imageUploadBase64', ['as' => 'image', 'uses' => "$controller@imageUploadBase64"]);
        Route::post('file', ['as' => 'file', 'uses' => "$controller@fileUpload"]);
      });
    });
  }

  /**
   * call appends Method
   *
   * @author BaRaa
   */
  public function callAppendsRoutes()
  {
    Route::macro('appends', function ($resource, $controller, $function) {

      if (!is_callable($function))
        return;

      Route::group(['prefix' => $resource], function () use ($function, $controller, $resource) {
        call_user_func($function, $controller, $resource);
      });

    });
  }

  /**
   * Called before routes are registered.
   *
   * Register any model bindings or pattern based filters.
   *
   * @return void
   */
  public function boot()
  {
    parent::boot();
  }

  /**
   * Define the routes for the application.
   *
   * @return void
   */
  public function map()
  {
    $this->mapApiRoutes();

    $this->mapWebRoutes();
  }

  /**
   * Define the "web" routes for the application.
   *
   * These routes all receive session state, CSRF protection, etc.
   *
   * @return void
   */
  protected function mapWebRoutes()
  {
    Route::middleware('web')
      ->namespace($this->moduleNamespace)
      ->group(module_path('Core', '/Routes/web.php'));
  }

  /**
   * Define the "api" routes for the application.
   *
   * These routes are typically stateless.
   *
   * @return void
   */
  protected function mapApiRoutes()
  {
    Route::prefix('api')
      ->middleware('api')
      ->namespace($this->moduleNamespace)
      ->group(module_path('Core', '/Routes/api.php'));
  }
}
