<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Symptom;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //getting number of verified and not fatal reports
        $reports = Report::whereMonth('created_at', '=', Carbon::now()->month)
                    ->whereYear('created_at', '=', Carbon::now()->year)
                    ->where(['is_approve' => 1, 'fatal' => 0])->get();

        //getting verified and fatal reports
        $fatal = Report::whereMonth('created_at', '=', Carbon::now()->month)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->where(['is_approve' => 1, 'fatal' => 1])->get();

        //daily reports for line chart
        $dailyReportsQuery = DB::table('reports')
                                ->select(DB::raw("DAY(created_at) as day, MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
                                ->where('is_approve', 1)
                                ->having('year', Carbon::now()->year)
                                ->having('month', Carbon::now()->month)
                                ->groupBy('year')
                                ->groupBy('month')
                                ->groupBy('day')
                                ->get()->toArray();
        $dailyReports = array_column($dailyReportsQuery, 'numberOfCases', 'day');

        //weekly reports for line chart
        $weeklyReportsQuery = DB::table('reports')
                                ->select(DB::raw("WEEKOFYEAR(created_at) as week, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
                                ->where('is_approve', 1)
                                ->having('year', Carbon::now()->year)
                                ->groupBy('year')
                                ->groupBy('week')
                                ->get()->toArray();
        $weeklyReports = array_column($weeklyReportsQuery, 'numberOfCases', 'week');

        //monthlyreports for line chart
        $monthlyReportsQuery = DB::table('reports')
                                ->select(DB::raw("MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
                                ->where('is_approve',1)
                                ->having('year',Carbon::now()->year)
                                ->groupBy('year')
                                ->groupBy('month')
                                ->get()->toArray();
        $monthlyReports = array_column($monthlyReportsQuery, 'numberOfCases', 'month');

        //yearly reports for line chart
        $yearlyReportsQuery = DB::table('reports')
                            ->select(DB::raw("YEAR(created_at) as year, COUNT(*) as numberOfCases"))
                            ->where('is_approve', 1)
                            ->having('year', '<=', Carbon::now()->year)
                            ->having('year', '>', Carbon::now()->year-10)
                            ->groupBy('year')
                            ->get()->toArray();
        $yearlyReports = array_column($yearlyReportsQuery, 'numberOfCases', 'year');
        //getting verified reports
        $verified_reports = Report::whereMonth('created_at', '=', Carbon::now()->month)
                    ->whereYear('created_at','=', Carbon::now()->year)
                    ->where(['is_approve' => 1])->get();
        $cases_in_states = [];
        for($i=0; $i<=16; $i++){
            $cases_in_states[$i] = 0;
        }
        foreach ($verified_reports as $report){
            // dd($report->residential_state_id);
            for ($i = 0; $i <= 16; $i++) {
                if($report->residential_state_id == $i){
                    $cases_in_states[$i]++;
                }
            }
        }
        // dd($cases_in_states);
        return view('home', compact('reports', 'fatal'))
                ->with(['dailyReports' => json_encode($dailyReports, JSON_NUMERIC_CHECK),
                        'weeklyReports' => json_encode($weeklyReports, JSON_NUMERIC_CHECK),
                        'monthlyReports'=> json_encode($monthlyReports, JSON_NUMERIC_CHECK),
                        'yearlyReports' => json_encode($yearlyReports, JSON_NUMERIC_CHECK),
                        'cases_in_states' => json_encode($cases_in_states)]);
    }

    public function symptoms(){
        $data = Report::select('symptoms')->get();
        $symptoms = Symptom::select('name')->get();
        $symptomsName = [];
        foreach ($symptoms as $symptom) {
            array_push($symptomsName, $symptom->name);
        }

        $numOfSymptoms = count($symptoms);
        for($i=0; $i<$numOfSymptoms; $i++){
            $symptomsCount[$i] = 0;
        }

        foreach($data as $row){
            $count = $row->symptoms;
            foreach(explode(',', $count) as $id){
                $symptomsCount[$id-1]++;
            }

        }

        return view('symptoms', compact('symptomsCount', 'symptomsName'));
    }

    public function hospitals(){
        return view('hospitals');
    }

}
