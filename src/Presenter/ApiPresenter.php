<?php

namespace Unisharp\Unifly\Presenter;

class ApiPresenter
{
    /**
     * code: HTTP response code
     * status_code: Status code in the json content.
     */
    public function json($data, $message = '', $code = 200, $status_code = false)
    {
        if ($status_code === null) {
            $status_code = (int)($code . '00');
        }
        if ($status_code === false) {
            // For backward compatibiltiy, if no $status_code,
            // use the origin 3 digits HTTP return code.
            $status_code = $code;
        }
        $status = [
            'code' => $status_code,
            'message' => $message,
        ];
        $response['status'] = $status;
        if ($data != null) {
            $response['data'] = $data;
        }

        $flag = 0;
        $is_pretty = \Request::get('pretty', null);
        if ($is_pretty) {
            $flag = JSON_PRETTY_PRINT;
        }

        return response()->json($response, $code, array(), $flag);
    }
}
