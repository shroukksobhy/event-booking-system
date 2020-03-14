<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('users.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
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
        //  $data = $request->all();
        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'ticket_type' => $request->ticket_type,
        ]);

        //echo $result->name;
        if ($result) {
            $arr = array('msg' => "Your ticket is booked Successfully");
        }
        return Response()->json($arr);
    }

    public function check(Request $request) //will recieve ajax request // Check if this email is used in this ticket or  not
    {
        if ($request->get('email')) {
            $email = $request->email;
            $ticket_type = $request->ticket_type;
            $data = User::where('email', $email)->where('ticket_type', $ticket_type)->count();
            //$data = DB::table('users')->where('email', $email)->count();
            if ($data > 0) {
                echo "not-unique";
            } else {
                echo "unique";  //0  lw mwgod
            }
            //  echo  "this is " . $request->get('email');
        }
    }
    public function ticketNumber(Request $request)
    {
        $hisTicket = $request->ticket_type;
        $numberOfTicket = User::all()->where('ticket_type', "=", $hisTicket)->count();
        if ($numberOfTicket >= 200) {
            echo "invalid";
        } else {
            echo "valid";
        }
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
