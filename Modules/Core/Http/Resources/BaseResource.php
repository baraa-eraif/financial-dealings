<?php


namespace Modules\Core\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function toArray($request)
  {
    return parent::toArray($request);
  }

  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function serializeForEdit($request)
  {
//        dd($this->sanitizeTranslations($request));), $this->sanitizeTranslationsGet($request)
    return array_merge($this->toArray($request));
  }

  /**
   * Transform the resource into an array.
   *
   * @param \Illuminate\Http\Request $request
   * @return array
   */
  public function serializeForFind($request)
  {
    return $this->toArray($request);
  }


  /**
   * returns concatenation of translations attributes and locales with translated value
   * if attribute is image or file appends url
   *
   *
   * @param Request $request
   * @return array
   * @author BaRaa
   */
  public function sanitizeTranslations(Request $request)
  {
    return $this->translations;
    $translations = [];
//    dd($this->translations);
    foreach ($this->translations as $attribute => $translation) {
      foreach ($translation as $locale => $value) {
        $translations[$attribute . "_" . $locale] = $value;
        if (in_array($attribute, $this->getImageable()))
          $translations[$attribute . "_" . $locale . "_url"] = $value;
      }
    }
    return count($translations) > 0 ? $translations : null;
  }

  public function sanitizeTranslationsGet(Request $request)
  {
    $translations = [];
    foreach ($this->translations as $attribute => $translation) {
      $translations[$attribute] = $this->getSanitizeTranslations($attribute) ?? null;
    }
    return $translations;
  }


  public function getLocale($attribute)
  {
    return isset($attribute) && array_key_exists(app()->getLocale(), $attribute) ? $attribute[app()->getLocale()] : "";
  }

  public function getTranslationsByModel($model, $attribute)
  {
    return isset($model) && $model->$attribute ? $model->getTranslations($attribute) : null;
  }

  public function getSanitizeTranslations($attribute)
  {
    return $this->getTranslations($attribute) ? $this->getTranslations($attribute) : null;
  }

  public function getTranslationWithKeyLocale($attribute, array $locales = ['ar', 'en'])
  {
    $data = [];
    foreach ($locales as $locale)
      $data[$locale] = $this->getTranslationWithFallback($attribute, $locale);
    return $data;
  }

  public function setCollectingTranslation()
  {
    $data = [];
    $data['name'] = [
      'ar' => \request()->get('name.ar'),
      'en' => \request()->get('name.en'),
    ];
    dd($data);
  }
}
