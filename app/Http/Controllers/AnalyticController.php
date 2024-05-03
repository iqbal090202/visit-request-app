<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Request as ModelsRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $now = Carbon::now();
        if (request()->has('tren') && request()->input('tren') !== null) {
            $filterTren = request()->input('tren');
        } else {
            $filterTren = ['month' => (int) $now->month - 1, 'year' => $now->year];
        }

        // if ($expiredRequests->count() > 0) {
        //     foreach ($expiredRequests as $request) {
        //         // $request->update([
        //         //     'status' => 'missed'
        //         // ]);
        //     }
        // }

        // $daily = ModelsRequest::select(DB::raw('DATE(start_date) as visit_date'), DB::raw('COUNT(*) as visit_count'))
        //     // ->where('status', 'requested')
        //     ->whereYear('start_date', $filterTren['year'])
        //     ->whereMonth('start_date', $filterTren['month'])
        //     ->groupBy('visit_date')
        //     ->get()->toArray();

        $totalPerMonth = ModelsRequest::select(DB::raw('strftime("%Y", start_date) as year'), DB::raw('strftime("%m", start_date) as month'), DB::raw('COUNT(*) as visit_count'))
            ->whereYear('start_date', $filterTren['year'])
            ->whereMonth('start_date', $filterTren['month'] + 1)
            ->groupBy('year', 'month')
            ->count();

        $dataByPurpose = ModelsRequest::select(DB::raw('COUNT(*) as visit_count'), DB::raw('visit_purpose'))
            ->whereYear('start_date', $filterTren['year'])
            ->whereMonth('start_date', $filterTren['month'] + 1)
            ->groupBy('visit_purpose')
            ->get()->toArray();

        // $weeklyVisitData = ModelsRequest::select(DB::raw('strftime("%Y", start_date) as year'), DB::raw('strftime("%W", start_date) as week'), DB::raw('COUNT(*) as visit_count'))
        // ->groupBy('year', 'week')
        // ->get();

        // $monthlyVisitData = ModelsRequest::select(DB::raw('strftime("%Y", start_date) as year'), DB::raw('strftime("%m", start_date) as month'), DB::raw('COUNT(*) as visit_count'))
        //     ->whereYear('start_date', '2024')
        //     ->groupBy('year', 'month')
        //     ->get()->toArray();

        // $currentMonth = date('m');
        // $currentYear = date('Y');

        // // Filter visit data for current month
        // $currentMonthData = array_filter($daily, function ($data) use ($currentMonth, $currentYear) {
        //     return date('m', strtotime($data['visit_date'])) == $currentMonth && date('Y', strtotime($data['visit_date'])) == $currentYear;
        // });

        // // Convert the filtered data into an array
        // $currentMonthArray = array_values($currentMonthData);

        // // Output the data for the current month
        // dd($currentMonthArray);
        return Inertia::render('Admin/Analytic/Index', [
            'dailyData' => $this->getRequestDataByDate($filterTren),
            'totalPerMonth' => $totalPerMonth,
            'dataByPurpose' => $dataByPurpose,
            'filters' => [
                'tren' => $filterTren
            ],
        ]);
    }

    public function getRequestDataByDate($filter)
    {
        $filter['month'] += 1;

        $start = Carbon::createFromDate(null, $filter['month'])->startOfMonth();
        $end = Carbon::createFromDate(null, $filter['month'])->endOfMonth();
        $dates = [];

        for ($date = $start; $date->lte($end); $date->addDay()) {
            $dates[] = (object) [
                'date' => $date->format('d'),
                'totalRequest' => 0
            ];
        }

        $requestData = ModelsRequest::whereMonth('start_date', '=', $filter['month'])
            ->whereDay('start_date', '>=', $start)
            ->whereDay('start_date', '<=', $end)
            ->get();

        foreach ($requestData as $request) {
            $date = $request->created_at->format('d');
            $index = array_search($date, array_column($dates, 'date'));

            if ($index !== false) {
                $dates[$index]->totalRequest++;
            }
        }

        return $dates;
    }
}
