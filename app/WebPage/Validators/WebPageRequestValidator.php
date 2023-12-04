<?php

namespace App\WebPage\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class WebPageRequestValidator
{

  public function validateRequest(Request $request): MessageBag|null
  {
    $validator = Validator::make($request->all(), [
      'url' => ['required', 'string', 'url']
    ]);

    if ($validator->fails()) {
      return $validator->errors();
    } else {
      return null;
    }
  }
}
