<?php

namespace Modules\Core\Providers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        Response::macro('api', function ($status, $message, $data = [], $extra = [], $error_code = 0, $statusCode = 200) {
            /*
             * This condition is set to unified the response of pagination according
             * to this format :
             * data => [],
             * paginator => links
             *
             * @author BaRaa
             *
             */
            if ($data instanceof LengthAwarePaginator) {
                $data = load_resource_pagination(null, $data);
                $payload = array_merge(['status' => $status, 'message' => $message, 'error_code' => $error_code], $data);
            } else {
                $payload = ['status' => $status, 'message' => $message, 'error_code' => $error_code, 'data' => $data];
            }
            if (isset($extra))
                $payload = array_merge($payload, ['extra' => $extra]);

            return Response::make($payload, $statusCode,
                ['Content-Type' => 'application/json']);
            // the unified response for all Webservices @author BaRaa
        });
    }
}
