<?php


namespace Modules\Core\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Meneses\LaravelMpdf\Facades\LaravelMpdf;
use Modules\Admin\Http\Resources\OrderResource;
use Modules\Core\Exports\BaseExport;
use Modules\Core\Http\Requests\BaseRequest;
use Modules\Core\Http\Resources\BaseResource;
use Modules\Core\Repositories\Api\BaseRepository;
use Modules\Core\Repositories\Api\PDFRepository;
use Modules\Core\Traits\HasSheet;
use Modules\Supervisor\Exports\OrderExport;
use Modules\Supervisor\Http\Resources\PdfResource;

class BaseController extends Controller
{
 use HasSheet;
  /**
   * endpoint's repo.
   * @author BaRaa
   */
  protected $repository;

  /**
   * endpoint's request.
   * @author BaRaa
   */
  protected $request;

  /**
   * repo. model
   * @author BaRaa
   * @var
   */
  public $model;

  /**
   * repo. model
   * @author BaRaa
   * @var
   */
  public $resource = BaseResource::class;

  /**
   * @var
   */
  public $export = BaseExport::class;

  /**
   * endpoint's $repository instance.
   * @author BaRaa
   */
  protected $repositoryInstance;

  /**
   * endpoint's $orderingAttribute.
   * @author BaRaa
   */
  public $orderingAttribute = "ordered";

  /**
   * export pdf view
   */
  public $viewPdf = 'nawadash.pdf';

  /**
   * BaseEndpoint constructor.
   * @author BaRaa
   */
  public function __construct()
  {
    $this->init();
    $this->repositoryInstance = app()->make($this->repository);
    $this->repositoryInstance->setModel($this->model);
    $this->repositoryInstance->setResource($this->resource);
  }


  /**
   * Init Repo.'s Attributes
   * @author BaRaa
   */
  public function init()
  {
    /**
     * check if child class doesn't have repo and request
     * then set Default values according to resource name
     * if default repo. isn't exist BaseRepository will be default
     * if default request isn't exist BaseRequest will be default
     *
     * @author BaRaa
     */
    if (!isset($this->repository))
      $this->repository = class_exists($this->getDefaultRepository()) ? $this->getDefaultRepository() : BaseRepository::class;

    if (!isset($this->request))
      $this->request = class_exists($this->getDefaultRequest()) ? $this->getDefaultRequest() : BaseRequest::class;

    if (!isset($this->model) && class_exists($this->getDefaultModel()))
      $this->model = $this->getDefaultModel();

    if (!isset($this->export))
      $this->export = class_exists($this->getDefaultExport()) ? $this->getDefaultExport() : BaseExport::class;

    $this->resource = class_exists($this->getDefaultResource()) ? $this->getDefaultResource() : BaseResource::class;

  }

  /**
   * fetch all resources
   *
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function index()
  {
    $model = $this->__getRepository()->all();
    return response()->api(SUCCESS_STATUS, trans('core::messages.fetched_successfully', ['attribute' => $this->alertMessage()]), $model, $this->indexAdditionalData());
  }

  /**
   * fetch resource by id
   *
   * @param $id
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function show($id)
  {
    $model = $this->__getRepository()->find($id);
    $resource = $this->__getRepository()->getResource();

    return response()->api(SUCCESS_STATUS, trans('core::messages.fetched_successfully', ['attribute' => $this->alertMessage()]), (new $resource($model))->serializeForEdit(request()), $this->showAdditionalData());
  }

  /**
   * store new resource
   *
   * @param Request $request
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function store(Request $request)
  {
    $request->validate($this->__getRequest()->rules(), $this->__getRequest()->messages());
    $model = $this->created($this->__getRepository()->store($request), $request);
    $resource = $this->__getRepository()->getResource();
    return response()->api(SUCCESS_STATUS, trans('core::messages.saved_successfully', ['attribute' => $this->alertMessage()]), (new $resource($model))->serializeForFind($request));
  }

  /**
   * update resource
   *
   * @param Request $request
   * @param $id
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   */
  public function update(Request $request, $id)
  {
    $request->validate($this->__getRequest()->rules(), $this->__getRequest()->messages());
    $model = $this->updated($this->__getRepository()->update($request, $id), $request);
    $resource = $this->__getRepository()->getResource();
    return response()->api(SUCCESS_STATUS, trans('core::messages.updated_successfully', ['attribute' => $this->alertMessage()]), (new $resource($model))->serializeForEdit($request));
  }

  /**
   * update the status of resource
   *
   * @options: Active = 1, Inactive = 0
   * @param Request $request
   * @param $id
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function updateStatus(Request $request, $id)
  {
    $model = $this->__getRepository()->updateStatus($request, $id);
    return response()->api(SUCCESS_STATUS, trans('core::messages.updated_successfully', ['attribute' => $this->alertMessage()]), $model);
  }

  /**
   * fetch resource by id
   *
   * @param $id
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function delete($id)
  {
    $model = $this->__getRepository()->delete($id);
    return response()->api(SUCCESS_STATUS, trans('core::messages.deleted_successfully', ['attribute' => $this->alertMessage()]), $model);
  }

  /**
   * fetch resource by id
   *
   * @param $id
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function destroy($id)
  {
    $model = $this->__getRepository()->delete($id);
    return response()->api(SUCCESS_STATUS, trans('core::messages.deleted_successfully', ['attribute' => $this->alertMessage()]), $model);
  }

  /**
   * delete group
   *
   * @param Request $request
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function deleteGroup(Request $request)
  {
    $model = $this->__getRepository()->deleteGroup($request);
    return response()->api(SUCCESS_STATUS, trans('core::messages.deleted_successfully', ['attribute' => $this->alertMessage()]), $model);
  }

  /**
   * return new instance from repository
   * @return mixed
   * @author BaRaa
   */
  protected function __getRepository()
  {
    return $this->repositoryInstance;
  }

  /**
   * return new instance from request
   * @return mixed
   * @author BaRaa
   */
  public function __getRequest()
  {
    return new $this->request;
  }

  /**
   * get Model's name for messages
   * @return string
   * @author BaRaa
   */
  static function getModelName()
  {
    return trans('core::messages.resource');
  }

  public function alertMessage()
  {
    if ($this->model)
      return trans('core::messages.' . strtolower(class_basename($this->model)));
    else
      static::getModelName();
  }

  /**
   * if method is not existed in the current endpoint
   * map, redirect it to its repository
   *
   * @param string $method
   * @param array $parameters
   * @return mixed
   * @throws \Modules\Core\Exceptions\AuthenticationException
   * @author BaRaa
   */
  public function __call($method, $parameters)
  {
    $model = $this->__getRepository()->{$method}(request(), ...$parameters);
    return response()->api(SUCCESS_STATUS, trans('core::messages.saved_successfully', ['attribute' => $this->alertMessage()]), $model);
  }

  /**
   * @param $model
   * @param Request $request
   * @return mixed
   */
  public function created($model, Request $request)
  {
    // TODO: Implement created() method.
    return $this->saving($model, $request);
  }

  /**
   * @param $model
   * @param Request $request
   * @return mixed
   */
  public function updated($model, Request $request)
  {
    // TODO: Implement updated() method.
    return $this->saving($model, $request);
  }

  /**
   * @param $model
   * @param Request $request
   * @return mixed
   */
  public function saving($model, Request $request)
  {
    // TODO: Implement updated() method.
    return $model;
  }

  /**
   * reorder items
   * check if list exist in $request and elements count greater than zero
   * else will throw exception
   *
   * @param Request $request
   * @return mixed
   * @throws \Exception
   * @author BaRaa
   */
  public function order(Request $request)
  {
    if (!(isset($request->list) && count($request->list) > 0))
      throw new \Exception(trans('core::messages.empty_list'));

    collect($request->list)->map(function ($item, $index) {
      $this->repositoryInstance->getQuery()->where('id', $item['id'])->update([$this->orderingAttribute => $index]);
    });
    return response()->api(SUCCESS_STATUS, trans('core::messages.updated_successfully', ['attribute' => $this->alertMessage()]));
  }


  /**
   * append extra data to index json response
   * default is empty array
   * You can overwrite this function in child controller
   *
   * @param array $data
   * @return array
   * @author BaRaa
   */
  public function indexAdditionalData($data = [])
  {
    return $data;
  }

  /**
   * append extra data to show json response
   * default is empty array
   * You can overwrite this function in child controller
   *
   * @param array $data
   * @return array
   * @author BaRaa
   */
  public function showAdditionalData($data = [])
  {
    return $data;
  }


  /**
   * Predict default repo. based on controller resource
   * if predicted repo. isn't exist then returns base repo. for this module
   * @return mixed
   */
  public function getDefaultRepository()
  {
    $repositoryClass = str_replace(["Http\\", "Controllers", "Controller"], ["", "Repositories", "Repository"], get_class($this));
    if (class_exists($repositoryClass))
      return $repositoryClass;
    return str_replace(get_class_name($repositoryClass), "ModuleRepository", $repositoryClass);
  }

  /**
   * Predict Default request based on controller resource
   * @return mixed
   */
  public function getDefaultExport()
  {
    return str_replace(["Controllers", "Controller"], ["Exports", "Export"], get_class($this));
  }

  /**
   * Predict Default request based on controller resource
   * @return mixed
   */
  public function getDefaultRequest()
  {
    return str_replace(["Controllers", "Controller"], ["Requests", "Request"], get_class($this));
  }


  /**
   * Predict Default model based on controller resource
   * @return mixed
   */
  public function getDefaultModel()
  {
    return models_path(str_replace("Controller", "", get_class_name($this)));
  }

  /**
   * Predict Default model based on controller resource
   * @return mixed
   */
  public function getDefaultResource()
  {
    return str_replace(["Controllers", "Controller"], ["Resources", "Resource"], get_class($this));
  }

  /**
   * @param mixed $repository
   * @author BaRaa
   */
  public function setRepository($repository): void
  {
    $this->repository = $repository;
  }

  /**
   * @param mixed $resource
   */
  public function setResource($resource): void
  {
    $this->resource = $resource;
  }

}
