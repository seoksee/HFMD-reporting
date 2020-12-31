<?php

namespace App\Http\Controllers;

use App\District;
use Illuminate\Http\Request;
use App\Report;
use App\State;
use App\Symptom;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
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
    public function index($state='')
    {
        //getting number of verified and not fatal reports
        $reports = Report::whereMonth('created_at', '=', Carbon::now()->month)
                    ->whereYear('created_at', '=', Carbon::now()->year)
                    ->where(['is_approve' => 1, 'fatal' => 0])->get();

        //getting verified and fatal reports
        $fatal = Report::whereMonth('created_at', '=', Carbon::now()->month)
                ->whereYear('created_at', '=', Carbon::now()->year)
                ->where(['is_approve' => 1, 'fatal' => 1])->get();

        //getting reports for line chart
        $report_cases = $this->report_cases('');

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

        //notice
        $two_weeks_from_now = Carbon::now()->subWeek(2)->format('Y-m-d h:m:s');
        $states = State::get();
        $outbreak = null;
        foreach ($states as $state) {
            $districts = District::where(['state_id' => $state->id])->get();
            foreach ($districts as $district) {
                $cases = DB::table('reports')->select(DB::raw("COUNT(*) as numberOfCases"))->where('is_approve', 1)->where('created_at', '>', $two_weeks_from_now)->where('residential_district_id', $district->id)->get()->toArray();
                if ($cases[0]->numberOfCases >= 3) {
                    $outbreak .= $district->name . ", " . $state->name . " ";
                }
            }
        }
        // $outbreak = Report::where('created_at', '>', $two_weeks_from_now)
        //             ->where(['is_approve' => 1])->get();
                // dd($outbreak);

        // dd($cases_in_states);
        return view('home', compact('reports', 'fatal', 'outbreak'))
                ->with(['dailyReports' => json_encode($report_cases['dailyReports'], JSON_NUMERIC_CHECK),
                        'weeklyReports' => json_encode($report_cases['weeklyReports'], JSON_NUMERIC_CHECK),
                        'monthlyReports'=> json_encode($report_cases['monthlyReports'], JSON_NUMERIC_CHECK),
                        'yearlyReports' => json_encode($report_cases['yearlyReports'], JSON_NUMERIC_CHECK),
                        'cases_in_states' => json_encode($cases_in_states)]);
    }

    public function fetch(Request $request){
        $select = $request->get('select');
        $value = $request->get('value');
        $type = $request->get('type');
        $data = DB::table('districts')
                    ->where($select, $value)
                    ->get();
        $output = '<select name="district" class="custom-select animated--fade-in district-selection">
                    <option value="">by District</option>';
        foreach($data as $row) {
            $output .= '<option value="' . $row->id .'">' . $row->name . '</option>';
        }
        $output .= '</select>';
        if($select == 'state_id') {
            $report_cases = $this->report_cases('state', $value);
        } else {
            $report_cases = $this->report_cases('district', $value);
        }

        $result = [
            'district' => $output,
            'report_cases' => $report_cases
        ];

        return response()->json($result);
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

    public function fetchSymptoms(Request $request)
    {
        $value = $request->get('value');
        if($value != null) {
            $reports = Report::select('symptoms')->whereYear('created_at', '=', $value)->get();
        } else {
            $reports = Report::select('symptoms')->get();
        }

        $symptoms = Symptom::select('name')->get();
        $symptomsName = [];

        foreach ($symptoms as $symptom) {
            array_push($symptomsName, $symptom->name);
        }

        $numOfSymptoms = count($symptoms);
        for ($i = 0; $i < $numOfSymptoms; $i++) {
            $symptomsCount[$i] = 0;
        }

        foreach($reports as $row) {
            $count = $row->symptoms;
            foreach(explode(',', $count) as $id) {
                $symptomsCount[$id-1]++;
            }
        }


        $result = [
            'symptomsCount' => $symptomsCount,
            'symptomsName' => $symptomsName
        ];

        return response()->json($result);
    }

    public function hospitals(){
        return view('hospitals');
    }

    public function report_cases($location, $id=''){
        //daily reports for line chart
        $dailyReportsQuery = DB::table('reports')
            ->select(DB::raw("DAY(created_at) as day, MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
            ->where('is_approve', 1)
            ->having('year', Carbon::now()->year)
            ->having('month', Carbon::now()->month)
            ->groupBy('year')
            ->groupBy('month')
            ->groupBy('day');

        //weekly reports for line chart
        $weeklyReportsQuery = DB::table('reports')
            ->select(DB::raw("WEEKOFYEAR(created_at) as week, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
            ->where('is_approve', 1)
            ->having('year', Carbon::now()->year)
            ->groupBy('year')
            ->groupBy('week');

         //monthlyreports for line chart
        $monthlyReportsQuery = DB::table('reports')
            ->select(DB::raw("MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
            ->where('is_approve', 1)
            ->having('year', Carbon::now()->year)
            ->groupBy('year')
            ->groupBy('month');

        //yearly reports for line chart
        $yearlyReportsQuery = DB::table('reports')
            ->select(DB::raw("YEAR(created_at) as year, COUNT(*) as numberOfCases"))
            ->where('is_approve', 1)
            ->having('year', '<=', Carbon::now()->year)
            ->having('year', '>', Carbon::now()->year - 10)
            ->groupBy('year');

        if ($location == 'state') {
            $dailyReportsQuery = $dailyReportsQuery
                ->where('residential_state_id', $id);

            $weeklyReportsQuery = $weeklyReportsQuery
                ->where('residential_state_id', $id);

            $monthlyReportsQuery = $monthlyReportsQuery
                ->where('residential_state_id', $id);

            $yearlyReportsQuery = $yearlyReportsQuery
                ->where('residential_state_id', $id);

        } else if ($location == 'district') {
            $dailyReportsQuery = $dailyReportsQuery
                ->where('residential_district_id', $id);
            $weeklyReportsQuery = $weeklyReportsQuery
                ->where('residential_district_id', $id);
            $monthlyReportsQuery = $monthlyReportsQuery
                ->where('residential_district_id', $id);
            $yearlyReportsQuery = $yearlyReportsQuery
                ->where('residential_district_id', $id);
        }

        $dailyReports = array_column($dailyReportsQuery->get()->toArray(), 'numberOfCases', 'day');
        $weeklyReports = array_column($weeklyReportsQuery->get()->toArray(), 'numberOfCases', 'week');
        $monthlyReports = array_column($monthlyReportsQuery->get()->toArray(), 'numberOfCases', 'month');
        $yearlyReports = array_column($yearlyReportsQuery->get()->toArray(), 'numberOfCases', 'year');

        $reports = [
            'dailyReports' => $dailyReports,
            'weeklyReports' => $weeklyReports,
            'monthlyReports' => $monthlyReports,
            'yearlyReports' => $yearlyReports
        ];
        return $reports;
    }

}
