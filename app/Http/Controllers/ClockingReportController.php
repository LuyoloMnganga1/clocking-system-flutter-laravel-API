<?php
namespace App\Http\Controllers;

use App\Models\Clocking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClockingsExport;
use Carbon\Carbon;

class ClockingReportController extends Controller
{
    public function getReport()
    {
        $clockings = Clocking::with('user')->get();
        return response()->json($clockings);
    }

    public function exportReport()
    {
        return Excel::download(new ClockingsExport, Carbon::now().'clockings.xlsx');
    }
}
