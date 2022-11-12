<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Events\UserAuthentication;
use Modules\Core\Http\Resources\AuthResource;
use Modules\Core\Repositories\Api\AuthRepository;


class AuthController extends BaseController
{

  public $authRepository;
  public $guard = USER_GUARD;
  public $model = User::class;
  public $resource = AuthResource::class;

  /**
   * @param AuthRepository $authRepository
   * @author BaRaa
   * AuthController constructor.
   */
  public function __construct(AuthRepository $authRepository)
  {
    $this->authRepository = $authRepository;
    $this->authRepository->setGuard($this->guard);
    $this->authRepository->setModelPath($this->model);
  }



  /**
   * @param Request $request
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function login(Request $request)
  {
    $token = $this->authRepository->login($this->credentials($request));

    if (!$token)
      return $this->unauthenticated();
    else
      $this->authenticated($token);

    return response()->api(SUCCESS_RESPONSE, trans('core::messages.successfully_logged_in'), [
      'access_token' => $token,
      'expires_in' => $this->guard()->factory()->getTTL() * 60,
      'token_type' => 'Bearer',
      'auth' => (new $this->resource(auth($this->guard)->user()))->serializeForEdit($request),
    ]);
  }

  /**
   * @param Request $request
   * @return array
   * @author BaRaa
   */
  public function credentials(Request $request)
  {
    return array($this->username() => $request->get($this->username()), 'password' => $request->get('password') ??'');
  }


  /**
   * @return string
   * @author BaRaa
   */
  public function username()
  {
    return 'username';
  }

  /**
   * @param string $auth
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   */
  public function logout($auth = 'api')
  {
    if (auth($auth)->check()) {
      $user = auth($auth)->user();
      auth($auth)->logout();
    } else if (auth(ADMIN_GUARD)->check()) {
      $user = auth(ADMIN_GUARD)->user();
      auth(ADMIN_GUARD)->logout();
    } else if (auth(USER_GUARD)->check()) {
      $user = auth(USER_GUARD)->user();
      auth(USER_GUARD)->logout();
    }
    event(new UserAuthentication(LOGOUT_TRANSACTION, $user));                       // register user's logout transaction @author BaRaa
    return response()->api(SUCCESS_RESPONSE, trans('Auth::lang.logged_out_successfully'));
  }


  /**
   * @param string $auth
   * @throws \Modules\Core\Exceptions\AuthenticationException
   */
  public function refresh($auth = 'api')
  {
    $data = null;
    $token = null;
    if (auth($auth)->check()) {
      $token = auth($auth)->refresh();
    } elseif (auth(ADMIN_GUARD)->check()) {
      $token = auth($auth)->refresh();
    } elseif (auth(USER_GUARD)->check()) {
      $token = auth($auth)->refresh();
    }
    if (is_null($data))
      return response()->api(ERROR_RESPONSE, trans('Auth::lang.token_refreshed_error'));
    event(new UserAuthentication(3));                       // register user's logout transaction @author BaRaa
    return $this->authenticated($token);
  }

  /**
   * @param $token
   * @author BaRaa
   */
  protected function authenticated($token)
  {

  }
  /**
   * call on unauthenticated
   */
  protected function unauthenticated()
  {
    return response()->api(false, trans('core::messages.user_not_found'),null,null);
  }
  /**
   * @return mixed
   * @author BaRaa
   */
  public function guard()
  {
    return Auth::guard($this->authRepository->getGuard());
  }

}
