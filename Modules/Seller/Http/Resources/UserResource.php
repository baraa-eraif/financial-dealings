<?php


namespace Modules\Seller\Http\Resources;


use Modules\Core\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
  /**
   * Transform the resource into an array.
   * @param \Illuminate\Http\Request $request

   * @return array
   */
  public function toArray($request)
  {
    return [
      'id' => $this->id,
      'username' => $this->username,
      'name' => $this->username,
      'mobile' => $this->mobile,
      'email' => $this->email,
    ];
  }


}
