<?php

namespace Unisharp\Unifly\Controller;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Unisharp\DataCarrier\DataCarrier;

class UniflyController extends Controller
{
    protected $repo;
    protected $presenter;
    protected $d; // DataCarrier

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
