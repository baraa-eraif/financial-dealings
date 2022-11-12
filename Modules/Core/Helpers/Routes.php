<?php
/**
 * Created by PhpStorm.
 * User: BaRaa
 * Date: 24/3/2021
 * Time: 1:36 م
 */

namespace Modules\Core\Helpers;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Traits\Macroable;

class Routes
{

    /**
     * Because this class also defines a '__call' method, a new
     * name has to be given to the traits '__call' method. The new name in this case is 'macroCall'.
     * @author BaRaa
     */
    use Macroable {
        __call as macroCall;
    }

    /**
     * This will first check if a macro exists, and if it does
     * the '__call' function will return the value of the
     * 'macroCall' function (which is defined in the 'Macroable') trait.
     *
     * If no macro exists, continue with class-specific
     * implementation of '__call'.
     * @param $method
     * @param $parameters
     * @return mixed
     * @author BaRaa
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method))
            return $this->macroCall($method, $parameters);
    }

    /**
     * Generate module authentication routes
     * Default controller AuthController
     *
     * @param string $controller
     * @author BaRaa
     * @return string
     */
    public static function authRoutes($controller = 'AuthController')
    {
        Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () use ($controller) {
            Route::post('login', ['as' => 'login', 'uses' => "$controller@login"]);
            Route::get('logout', ['as' => 'logout', 'uses' => "$controller@logout"]);
            Route::get('refresh', ['as' => 'refresh', 'uses' => "$controller@refresh"]);
        });
//        return $this;
    }

    /**
     * Generate resource default rest-full routes
     *
     * @param $resource
     * @param string $controller
     * @author BaRaa
     * @return string
     */
    public function resource($resource, $controller)
    {
        Route::resource($resource, $controller);
        return $this;
    }

    public function appends()
    {
        dd('ff');
    }
}
