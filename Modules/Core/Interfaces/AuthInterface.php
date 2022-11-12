<?php

namespace Modules\Core\Interfaces;

/**
 * Created by PhpStorm.
 * User: BaRaa
 * Date: 05/04/2020
 * Time: 9:46 PM
 */
interface AuthInterface
{

    /**
     * @author BaRaa
     * @param $credentials
     * @return mixed
     */
    public function login($credentials);


    /**
     * @author BaRaa
     * @param string $auth
     * @return mixed
     */
    public function logout($auth = USER_GUARD);


    /**
     * @author BaRaa
     * @param string $auth
     * @return mixed
     */
    public function refresh($auth = USER_GUARD);


    /**
     * @author BaRaa
     * @return mixed
     */
    public function guard();
}
