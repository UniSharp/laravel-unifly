<?php

namespace Unisharp\Unifly\Presenter;

class ApiPresenter
{
    public function json($data, $message = '', $code = 200)
    {
        $status = [
            'code' => $code,
            'message' => $message,
        ];
        $response['status'] = $status;
        if ($data != null) {
            $response['data'] = $data;
        }

        return response()->json($response, $code);
    }
}
