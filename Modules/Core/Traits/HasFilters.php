<?php

namespace Modules\Core\Traits;

use Illuminate\Database\Eloquent\Builder;
use Modules\Core\Filters\Filter;

trait HasFilters
{
  /**
   * get Query
   * if user passed filter
   * otherwise
   * return the model
   * @return mixed
   * @throws \Exception
   */
  public function getQuery()
  {
    if ($this->__filterResourceName() != null && request()->get($this->__filterResourceName()) != null) {
      $filters = (new Filter(request()->all()))->reformStructure();
      return $this->buildFilterQuery($filters);
    }
    return $this->originalQuery();
  }

  function get_resource_name($classPath)
  {
    $pathPartials = explode('\\', $classPath);
    return strtolower(end($pathPartials));
  }


  /**
   * return new Query from model
   *
   * @return mixed
   * @author BaRaa
   */
  public function originalQuery()
  {
    return $this->__getModel();
  }

  /**
   * get filter resource name attribute from request
   *
   * @return string|mixed
   * @author BaRaa
   */
  public function __filterResourceName()
  {
    if (request()->has($this->get_resource_name($this->model) . '_filter'))
      return get_resource_name($this->model) . '_filter';
    return request()->has('filter') ? 'filter' : null;
  }

  /**
   * build query according
   * to the given data
   *
   * @param $filters
   * @return mixed
   * @author BaRaa
   */
  private function buildFilterQuery($filters)
  {
    $query = $this->__getModel()->newQuery();
    if ($filters['query'] != null && trim($filters['query']) != '')
      $query = $query->whereRaw($filters['query'], $filters['values']);

    if (isset($filters['relations']) && sizeof($filters['relations']) > 0) {
      foreach ($filters['relations'] as $key => $relation) {
        $query = $query->whereHas($key, function ($query) use ($relation) {
          $query->whereRaw($relation['query'], $relation['values']);
        });
      }
    }
    return $query;
  }


  /**
   * get the serialized filters
   * @return bool
   * @author BaRaa
   */
  protected function getFilters()
  {
    return request()->has('filter');
  }


  /**
   * @param Builder $q
   * @param $attribute
   * @param $value
   * @param string $operator
   * @return Builder
   */
  public function filterByJson(Builder $q, $attribute, $value, $operator = "LIKE")
  {
    $q = isset($value) ? $q->whereRaw('LOWER(JSON_EXTRACT(' . $attribute . ', "$.' . app()->getLocale() . '")) like ?', ['"%' . strtolower($value) . '%"']) : $q;
    return $q;
  }

  public function filterByKey(Builder $q, $attribute, $value, $operator = "LIKE")
  {
    return isset($value) ? $q->where($attribute, $operator, $value) : $q;
  }

  public function searchByRelation($relation, $attribute, $request_key, bool $json = false)
  {
    return $this->whereHas($relation, function ($inner) use ($attribute, $request_key, $json) {
      $json ? $this->filterByJson($inner, $attribute, request()->get($request_key)) :
        $this->filterByKey($inner, $attribute, request()->get($request_key));
    });
  }
}
