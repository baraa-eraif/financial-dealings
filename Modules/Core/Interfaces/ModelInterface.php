<?php
/**
 * Created by PhpStorm.
 * User: BaRaa
 * Date: 28/05/2020
 * Time: 11:45 PM
 */

namespace Modules\Core\Interfaces;


use Illuminate\Http\Request;

interface ModelInterface
{

    /**
     * @author BaRaa
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request);


    /**
     * @author BaRaa
     * @param Request $request
     * @param mixed ...$args
     * @return mixed
     */
    public function update(Request $request, ...$args);


    /**
     * @author BaRaa
     * @param $id
     * @return mixed
     */
    public function find($id);

    /**
     * @author BaRaa
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @author BaRaa
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request);

}
