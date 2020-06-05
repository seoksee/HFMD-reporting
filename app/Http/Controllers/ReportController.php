<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Symptom;
use Illuminate\Support\Facades\Auth;
use App\Document;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $symptoms = Symptom::get();
        return view('report', compact('symptoms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        if($file = $request->file('document')){
            $name = time().$file->getClientOriginalName();
            $file->move('documents', $name);
            $document = Document::create(['file'=>$name]);
            $input['document_id'] = $document->id;
        }
        $symptoms = $request->symptoms;
        $symptom = join(",", $symptoms);
        $input['symptoms'] = $symptom;
        $user->reports()->create($input);
        $message = "Your report has been received and waiting review by an admin.";
        return redirect('/')->with('alert', $message);
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
        //
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
        //
    }
}
