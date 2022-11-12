<?php

namespace Modules\Core\Interfaces;

use Illuminate\Http\Request;

interface BaseInterface
{
    /**
     * get specific resources' columns
     *
     * @param array $cols
     * @return mixed
     * @author BaRaa
     */
    public function get($cols = ['*']);

    /**
     * get single resource according to
     * the given id
     *
     * @param $id
     * @return mixed
     * @author BaRaa
     */
    public function find($id);

    /**
     * get all resources
     *
     * @return mixed
     * @author BaRaa
     */
    public function all();

    /**
     * take $limit no from query
     * this function accepts passing custom query
     * default $query is null
     *
     * @param int $limit
     * @param  $q
     * @return mixed
     * @author BaRaa
     */
    public function take($limit = 10, $q = null);

    /**
     * take $limit no from query
     * this function accepts passing custom query
     * default $query is null
     *
     * @param int $limit
     * @param  $q
     * @return mixed
     * @author BaRaa
     */
    public function takeWithResource($limit = 10, $q = null);

    /**
     * delete resource according
     * to the given id
     *
     * @param $id
     * @return mixed
     *
     * @author BaRaa
     */
    public function delete($id);

    /**
     * create new resource
     *
     * @param Request $request
     * @return mixed
     *
     * @author BaRaa
     */
    public function store(Request $request);

    /**
     * update resource
     *
     * @param Request $request
     * @param $id
     * @return mixed
     *
     * @author BaRaa
     */
    public function update(Request $request, $id);
}
