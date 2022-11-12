<?php
/**
 * return current system languages
 *
 * @return array
 * @author @BaRaa
 */
function locales()
{
  return config('languages');
}

/**
 * @return string
 * @author @BaRaa
 */
function current_locale()
{
  return \Illuminate\Support\Facades\App::getLocale();
}

function load_resource_pagination($resourceClass = null, \Illuminate\Pagination\LengthAwarePaginator $paginator)
{
  $data = $paginator->getCollection();
  if ($resourceClass != null) {
    $data = $resourceClass::collection($paginator->getCollection());
  }
  $result['data'] = $data;
  $temp = $paginator->toArray();
  unset($temp['data']);
  $result['paginator'] = $temp;

  return $result;
}

//if (!function_exists('get_resource_name')) {
/**
 * this function returns the name of resource which
 * is the name of object's class
 * all resource name will be returned in lower case¬
 *
 * @param $classPath
 * @return string
 * @author BaRaa
 */
function get_resource_name($classPath)
{
  $pathPartials = explode('\\', $classPath);
  return strtolower(end($pathPartials));
}

/**
 * @param $classPath
 * @return mixed
 * @author BaRaa
 */
function get_class_name($classPath)
{
  if (is_object($classPath))
    $classPath = get_class($classPath);
  $pathPartials = explode('\\', $classPath);
  return end($pathPartials);
}


/**
 * @param $model
 * @return string
 */
function models_path($model)
{
  return "App\\Models\\$model";
}
/**
 *
 * @param $img
 * @param string $size
 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
 * @author BaRaa
 */

function image_url($img, $size = '')
{

  return (!empty($size)) ? url('image/' . $size . '/' . $img) : url('image/' . $img);
}
