<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Symptom;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminSymptomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $symptoms = Symptom::paginate(8);
        // // dd($symptoms);
        // return view('admin.symptoms.index', compact('symptoms'));

        // if($request->ajax()){
        //     $data = Symptom::latest()->get();
        //     return Datatables::of($data)
        //             ->addIndexColumn()
        //             ->addColumn('action', function($row){
        //                 $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editSymptom">Edit</a>';
        //                 $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltipV" data-id="'.$row->id.'" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteSymptom">Delete</a>';
        //                 return $btn;
        //             })
        //             ->rawColumns(['action'])
        //             ->make(true);
        // }
        return view('admin.symptoms.index');
    }

    public function getTableData(Request $request){
            $data = Symptom::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editSymptom">Edit</a>';
                    if(DB::table('reports')->where('symptoms', $row->id)->doesntExist()){
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltipV" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteSymptom">Delete</a>';
                    } else {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltipV" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-secondary btn-sm deleteSymptom disabled">Delete</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        Symptom::updateOrCreate(
            ['id' => $request->symptom_id],
            ['name' => $request->name]
        );

        return response()->json(['success' => 'Symptom saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function editData(Request $request){
        $symptom_id = $request->symptom_id;
        $name = Symptom::find($symptom_id);
        $data = [
            'symptom_id' => $symptom_id,
            'name' => $name
        ];
        return response()->json($data);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Symptom::find($id)->delete();
        return response()->json(['success'=>'Symptom deleted successfully.']);
    }

    public function deleteData(Request $request){
        $symptom_id = $request->symptom_id;
        $symptom = Symptom::find($symptom_id)->delete();
        return response()->json(['success'=>'Symptom deleted successfully.']);
    }
}
