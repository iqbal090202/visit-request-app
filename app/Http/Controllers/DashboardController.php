<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Request as ModelsRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // $daily = ModelsRequest::select(DB::raw('DATE(start_date) as visit_date'), DB::raw('COUNT(*) as visit_count'))
        // ->groupBy('visit_date')
        // ->get();

        // $weeklyVisitData = ModelsRequest::select(DB::raw('strftime("%Y", start_date) as year'), DB::raw('strftime("%W", start_date) as week'), DB::raw('COUNT(*) as visit_count'))
        // ->groupBy('year', 'week')
        // ->get();

        // $monthlyVisitData = ModelsRequest::select(DB::raw('strftime("%Y", start_date) as year'), DB::raw('strftime("%m", start_date) as month'), DB::raw('COUNT(*) as visit_count'))
        // ->groupBy('year', 'month')
        // ->get();
        // dd($monthlyVisitData);

        $latestRequest = ModelsRequest::with('visitors')->latest()->take(5)->get();
        // dd($latestRequest);

        $upcomingVisit = ModelsRequest::with('visitors')
            ->where('status', 'accepted')
            ->whereDate('start_date', '>', Carbon::now()->toDateString())
            ->orWhere(function ($query) {
                $query->whereDate('start_date', '=', Carbon::now()->toDateString())
                      ->whereTime('start_date', '>', Carbon::now()->toTimeString());
            })
            ->oldest()->take(5)->get();
        // dd($upcomingVisit);

        return Inertia::render('Dashboard', [
            'dataTotals' => [
                'all' => ModelsRequest::count(),
                'requested' => ModelsRequest::where('status', 'requested')->count(),
                'accepted' => ModelsRequest::where('status', 'accepted')->count(),
                'rejected' => ModelsRequest::where('status', 'rejected')->count(),
                'finished' => ModelsRequest::where('status', 'finished')->count(),
                'missed' => ModelsRequest::where('status', 'missed')->count()
            ],
            'latestRequest' => $latestRequest,
            'upcomingVisit' => $upcomingVisit
        ]);
    }
}
