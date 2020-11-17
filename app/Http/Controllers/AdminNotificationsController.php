<?php

namespace App\Http\Controllers;

use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;
use App\Notification;
use App\Symptom;
use App\User;
use Illuminate\Support\Facades\DB;
use DataTables;

class AdminNotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.notifications.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('admin.notifications.create', compact($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'users' => 'required',
            'message' => 'required'
        ]);
        if($request->users == "all") {
            // $recipients = User::select('phone')->get();
            $recipients = DB::table('users')->select('phone')->get();
        } else {
            $recipients = DB::table('users')->select('phone')->where('state', '=', $request->users)->get();
        }
        // dd($recipients);
        // $recipients = $validatedData["users"];
        foreach ($recipients as $recipient) {
            // dd($recipient);
            // $this->sendMessage($validatedData["message"], $recipient->phone);
        }

        $input = $request->all();
        // $recipientsDB = implode(', ', $request->users);
        $input['recipients'] = $request->users;
        $input['content'] = $request->message;
        $input['when_to_send'] = $request->date;
        $admin = Auth::user();
        $admin->notifications()->create($input);

        $message = "Your notification has been created successfully.";
        return redirect('/admin/notifications')->with('alert', $message);
        // return response()->json(['success' => 'Notification created successfully.']);
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

    // public function sendCustomMessage(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'users' => 'required|array',
    //         'message' => 'required'
    //     ]);
    //     $recipients = $validatedData["users"];
    //     foreach($recipients as $recipient) {
    //         $this->sendMessage($validatedData["body"], $recipient);
    //     }
    //     return back()->with(['success' => "Messages on their way!"]);
    // }


    public function getTableData(Request $request) {
        $data = Notification::latest()->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
            $btn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
