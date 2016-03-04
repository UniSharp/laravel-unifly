<?php

namespace Unisharp\Unifly\Controller;

use App\Http\Controllers\Controller;

abstract class UniflyController extends Controller
{
    public function export()
    {
        $this->repo->export();
    }

    public function sort()
    {
        $seq = json_decode(request('sorted'));
        $this->repo->sort($seq);
        return redirect()->back()->with('status', _('排序成功'));
    }
}
