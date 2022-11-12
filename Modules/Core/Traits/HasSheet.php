<?php

namespace Modules\Core\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Meneses\LaravelMpdf\Facades\LaravelMpdf;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

trait HasSheet
{
  /**
   * @param Request $request
   * @return mixed
   */
  public function import(Request $request)
  {
    $model = $this->__getRepository()->insert($request);
    return response()->api(SUCCESS_STATUS, trans('core::messages.fetched_successfully', ['attribute' => $this->alertMessage()]), $model, []);
  }

  /**
   * @param null $collection
   * @return mixed
   * @throws ContainerExceptionInterface
   * @throws NotFoundExceptionInterface
   */
  public function exportExcel($collection = null)
  {
    @ini_set('max_execution_time', 300);
    @ini_set('memory_limit', '512M');
    $filename = createUniqueFilename();
    Excel::store(new $this->export(array_merge($this->serializeDataForSheet(), $this->serializeAddtionForSheet()), $this->serializeColumnForSheet(), strtolower(class_basename($this->model))), "/reports/$filename");
    return response()->api(SUCCESS_STATUS, trans('core::messages.excel_exported_successfully'), ['filename' => $filename]);
  }

  /**
   * @return mixed
   * @throws \Mpdf\MpdfException
   */
  public function exportPdf()
  {
    $pdf = LaravelMpdf::loadView($this->viewPdf, ['columns' => $this->serializeColumnForSheet()],
      ['collection' => $this->serializeDataForSheet(), 'model_name' => strtolower(class_basename($this->model))], ['title' => 'Certificate','format' => 'A4-L','orientation' => 'L']);
    $path_file = createUniqueFilename('pdf');
    Storage::put("reports/" . $path_file, $pdf->output());
    return response()->api(SUCCESS_STATUS, trans('core::messages.excel_exported_successfully'), ['file_name' => $path_file]);
  }
  /**
   * @param $fileName
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   */
  public function export($fileName)
  {
    return response()->download(storage_path('app/reports/' . $fileName));
  }

  /**
   * @return mixed
   * @throws \Psr\Container\ContainerExceptionInterface
   * @throws \Psr\Container\NotFoundExceptionInterface
   */
  public function serializeDataForSheet()
  {
    $resource = $this->__getRepository()->getResource();
    if (request()->get('id')) {
      $model = $this->__getRepository()->find(request()->get('id'));
      $resource = $this->__getRepository()->getResource();
      return  (new $resource($model))->serializeForEdit(request());
    }
    return $resource::Collection($this->__getRepository()->getProcessedQuery()->get())->toArray(request());
  }

  /**
   * @return array
   */
  public function serializeAddtionForSheet()
  {
    return [];
  }

  /**
   * @return array
   */
  public function serializeColumnForSheet(): array
  {
    return ((new $this->model)->getserializeColumnForSheet()) ?? ((new $this->model)->getFillable());
  }
}
