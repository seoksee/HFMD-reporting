<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\Symptom;

class AdminReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::paginate(8);
        // dd($reports);
        foreach($reports as $report){
            $symptoms = $report->symptoms;
            $symptom = explode(',', $symptoms);
            foreach($symptom as $row){
                $symptomName = Symptom::find((int)$row)->name;
            }
        }
        // return view('/');
        return view('admin.report', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);
        $symptoms = Symptom::get();
        // dd($report->document);
        return view('admin.reports.show', compact('report', 'symptoms'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $report = Report::findOrFail($id)->update($request->all());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        if($report->document){
            unlink(public_path().$report->document->file);
        }
        dd($report);
        $report->delete();
        $message = "Report $id is deleted.";

        return redirect()->back()->with('alert', $message);
    }

    public function changeFatal(Request $request)
    {
        $report = Report::find($request->id);
        $report->fatal = $request->fatal;
        $report->save();
        // dd($report);
        return response()->json(['success'=>'Deceased changed successfully.']);
    }

    public function changeVerify(Request $request)
    {
        $report = Report::find($request->id);
        $report->is_approve = $request->is_approve;
        $report->save();
        // dd($report);
        return response()->json(['success' => 'Verify status changed successfully.']);
    }

    public function deleteData(Request $request)
    {
        $report_id = $request->report_id;
        $report = Report::find($report_id)->delete();
        return response()->json(['success' => 'Symptom deleted successfully.']);
    }
}
