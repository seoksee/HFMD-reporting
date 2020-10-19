<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Symptom;
use Carbon;
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

        //monthlyreports for line chart
        $monthlyReportsQuery = DB::table('reports')
                                ->select(DB::raw("MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as numberOfCases"))
                                ->where('is_approve',1)
                                ->having('year',Carbon::now()->year)
                                ->groupBy('year')
                                ->groupBy('month')
                                ->get()->toArray();
        $monthlyReports = array_column($monthlyReportsQuery, 'numberOfCases', 'month');

        return view('home', compact('reports', 'fatal'))
                ->with('monthlyReports', json_encode($monthlyReports, JSON_NUMERIC_CHECK));
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
