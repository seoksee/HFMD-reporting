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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'users' => 'required',
            'message' => 'required',
            'date' => 'required|after:' . Carbon::now()->addMinute(),
        ]);
        // if($request->users == "all") {
            // $recipients = User::select('phone')->get();
            // $recipients = DB::table('users')->select('phone')->get();
        // } else {
            // $recipients = DB::table('users')->select('phone')->where('state', '=', $request->users)->get();
        // }
        // dd($recipients);
        // $recipients = $validatedData["users"];
        // foreach ($recipients as $recipient) {
            // dd($recipient);
            // $this->sendMessage($validatedData["message"], $recipient->phone);
        // }

        // $input = $request->all();
        // $recipientsDB = implode(', ', $request->users);

        $input['id'] = $request->notification_id;
        $input['recipients'] = $request->users;
        $input['content'] = $request->message;
        $input['when_to_send'] = $request->date;

        $admin = Auth::user();
        // $input['user_id'] = $admin->id;
        if($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }
        $admin->notifications()->updateOrCreate(["id" => $input['id']], [
            "recipients" => $request->users,
            "content" => $request->message, "when_to_send" => $request->date
        ]);
        return response()->json(['success' => 'Notification created successfully.']);

        // return new JsonResponse(\error_response(422, 'Invalid notification', $validator->getMessageBag()->toArray()), 422);
        // Notification::updateOrCreate($input);

        $message = "Your notification has been created successfully.";
        // return redirect('/admin/notifications')->with('alert', $message);

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

    public function editData(Request $request)
    {
        $notification_id = $request->notification_id;
        $notification = Notification::find($notification_id);
        $recipients = $notification->recipients;
        $content = $notification->content;
        $when_to_send = $notification->when_to_send;
        $data = [
            'notification_id' => $notification_id,
            'users' => $recipients,
            'message' => $content,
            'date' => $when_to_send
        ];
        // dd($data);
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
        //
    }

    public function deleteData(Request $request)
    {
        $notification_id = $request->notification_id;
        $notification = Notification::find($notification_id)->delete();
        return response()->json(['success' => 'Notification deleted successfully.']);
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
            // ->addColumn('action', function ($row) {
            // $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editNotification">Edit</a>';
            // $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltipV" data-id="' . $row->id . '" data-original-title="Delete" class="delete btn btn-danger btn-sm deleteNotification">Delete</a>';
            // return $btn;
            //     return $btn;
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }
}
