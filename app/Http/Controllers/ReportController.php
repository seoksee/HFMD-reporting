<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Symptom;
use Illuminate\Support\Facades\Auth;
use App\Document;
use App\Report;
use Illuminate\Support\Facades\Mail;
use App\State;
use App\District;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Twilio\Rest\Client;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        $states = State::get();
        $districts = District::get();
        return view('report', compact('symptoms','states','districts'));
    }

    public function fetch(Request $request) {
        $select = $request->get('select');
        $value = $request->get('value');
        $data = DB::table('districts')
                    ->where($select, $value)
                    ->get();
        $output = '<option value="">Select District</option>';
        foreach ($data as $row) {
            $output .= '<option value="' . $row->id . '">' . $row->name . '</option>';
        }
        echo $output;
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
            'DOB' => 'required | before:' . Carbon::now(),
            'relationship' => 'required',
            'symptoms' => 'required',
            'hospital_admission' => 'required',
            'residential_state_id' => 'required',
            'residential_district_id' => 'required',
            'attend_kindergarten' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $input = $request->all();
        $user = Auth::user();
        if($file = $request->file('document_id')){
            $name = time().$file->getClientOriginalName();
            $file->move('documents', $name);
            $document = Document::create(['file'=>$name]);
            $input['document_id'] = $document->id;
        }
        $symptoms = $request->symptoms;
        $symptom = join(",", $symptoms);
        $input['symptoms'] = $symptom;
        $DOB = $request->DOB;
        $age = Carbon::parse($DOB)->diff(Carbon::now())->format('%y years, %m months and %d days');
        $input['age'] = $age;
        if($request->children_infected == 0){
            $input['children_in_kindergarten_infected'] = 0;
        }
        // dd($request->children_in_kindergarten_infected);

        //send notification email to the user
        $user->reports()->create($input);
        $message = "Your report has been received and waiting review by an admin.";

        $data = [
            'title' => 'Submission of report on HFMD reporting system',
            'content' => 'Your report has been submitted and waiting review by an admin.',
        ];

        Mail::send('emails.test', $data, function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject('Reporting on HFMD reporting system');
        });

        //send notification sms to an admin
        $admin = User::where(['role_id'=> '1'])->firstOrFail();
        $message = "There is a new reported case on " . Carbon::now()->format('Y-m-d H:i:s');
        $this->sendMessage($message, $admin->phone);

        // return redirect('/')->with('alert', $message);
        return response()->json(['success' => 'Report created successfully.']);
    }

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create(
            $recipients,
            ['from' => $twilio_number, 'body' => $message]
        );
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
        // Report::findOrFail($id)->update($request->all());
        // return redirect()->back();
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
