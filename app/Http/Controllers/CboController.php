<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\States;
use App\Models\Cbo;
use App\Models\Lgas;
use Illuminate\Support\Facades\Session;
use App\Models\CboMonthly;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class CboController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cbo_index()
    {
        if (Gate::denies('admin_role')) {
            abort('404');
        }

        $cbo = Cbo::all();
        $states = States::where('status', 'active')->get();

        return view('backend.cbo.cbo')->with([
            'cbos' => $cbo,
            'states' => $states,
        ]);
    }

    public function cbo_monthly()
    {
        if (Gate::denies('admin_cbo')) {
            abort('404');
        }

        $cbo = CboMonthly::all();
        $states = States::where('status', 'active')->get();

        return view('backend.cbo.cbomonthly')->with([
            'cbos' => $cbo,
            'states' => $states,
        ]);
    }

    public function add_cbo(Request $request)
    {

        $cboRole = Role::where('name', 'Cbo')->first();

        $cbo = User::create([
            'name' => $request->cbo_name,
            'email' => $request->email,
            'password' => Hash::make($request->state),
            'email_verified_at' => now(),
            'remember_token' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $submit_cbo = Cbo::create([
            'cbo_name' => $request->cbo_name,
            'email' => $request->email,
            'state' => $request->state,
            'lga' => $request->lga,
            'phone' => $request->phone,
            'contact_person' => $request->contact_person,
            'date_of_engagement' => $request->engage_date,
            'date_of_establishment' => $request->establish_date,
            'physical_contact_address' => $request->contact_address,
        ]);

        $cbo->roles()->attach($cboRole);

        if ($submit_cbo) {
            Session::flash('flash_message', 'Cbo Added Successfully');
            return redirect(route('cbo'));
        }
    }

    public function add_cbo_monthly(Request $request)
    {

        $attachment = $request->attachment->store('photos/attachments');
        $month = date('M');
        $year = date('Y');
        $submit_cbo_monthly = CboMonthly::create([
            'cbo_name' => $request->cbo_name,
            'state' => $request->state,
            'lga' => $request->lga,
            'attachment' => $attachment,
            'minutes_of_meeting' => $request->minutes,
            'date_of_meeting' => $request->meeting_date,
            'month'=>$month,
            'year'=>$year,
        ]);

        if ($submit_cbo_monthly) {
            Session::flash('flash_message', 'Cbo Monthly Report Added Successfully');
            return redirect(route('cbo.monthly'));
        }
    }

    public function fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent');
        $data = DB::table('lgas')->where($select, $value)
            ->get();

        $output = '';
        foreach ($data as $row) {
            $output .=
                '<option id="'.$row->name.'" value="'.$row->name .'">' .$row->name . '</option>
            ';
        }

        echo $output;
    }

    public function cbo_fetch(Request $request)
    {
        $select = $request->get('select');
        $value = $request->get('value');
        $dependent = $request->get('dependent1');
        $data = DB::table('cbos')->where('lga', $value)
            ->get();

        $output = '';


        foreach ($data as $row) {

            $output .=
            '<option value="'.$row->cbo_name.'">'.$row->cbo_name .'</option>
        ';

        }

        echo $output;
    }
}
