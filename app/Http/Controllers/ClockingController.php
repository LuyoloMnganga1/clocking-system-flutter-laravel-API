<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clocking;
use App\Models\User;
use Carbon\Carbon;

class ClockingController extends Controller
{
    public function clockIn(Request $request)
    {
        $clocking = new Clocking();
        $clocking->user_id = $request->user_id;
        $clocking->clock_in = Carbon::now();
        $clocking->location_in = $request->location_in;
        $clocking->save();

        return response()->json(['message' => 'Clocked in successfully']);
    }
    public function checkClockInStatus()
    {
        $user = Auth::user();
        $today = Carbon::now()->startOfDay();

        $clockIn = Clocking::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->whereNotNull('clock_in_time')
            ->first();

        return response()->json($clockIn ? true : false);
    }

    public function clockOut(Request $request)
    {
        $clocking = Clocking::where('user_id', $request->user_id)
                            ->whereNull('clock_out')
                            ->first();

        if ($clocking) {
            $clocking->clock_out = Carbon::now();
            $clocking->location_out = $request->location_out;
            $clocking->save();

            return response()->json(['message' => 'Clocked out successfully']);
        }

        return response()->json(['message' => 'No active clock-in found'], 404);
    }

    public function getWeeklyClockings()
    {
        $user = Auth::user();
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $clockings = Clocking::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->get();

        return response()->json($clockings);
    }
}
