<?php

namespace App\Traits;

trait ResponseTrait
{
    public function build_response($data = [], $message = '', $code = 200)
    {
        return response()->json(['data' => $data, 'message' => $message], $code);
    }
}
