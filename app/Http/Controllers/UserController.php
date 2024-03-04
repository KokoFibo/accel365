<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $users = User::paginate(10);

        $users = DB::table('users')->join('locations', 'locations.id', '=', 'users.location_id')
            ->select('users.*', 'locations.location_name')
            ->orderBy('users.id', 'desc')
            ->paginate(10);
        $locations = Location::get();
        $units = User::whereIn('level', ['AAD', 'AD'])->get();
        return Inertia::render('Registration/Registration', [
            'users' => $users,
            'locations' => $locations,
            'units' => $units
        ])->with('message', 'Added Sucessfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'level' => 'required',
            'kode_agent' => 'nullable',
            'unit' => 'nullable',
        ]);

        // dd($request->all());
        $data = new User;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->level = $request->level;
        $data->kode_agent = $request->kode_agent;
        $data->unit = $request->unit;
        $data->role = 0;
        $data->location_id = 1;
        $data->password = Hash::make('12345678');
        $data->save();
        return redirect()->route('user.index');
        // return redirect()->route('user.index')->with('message', 'Added Sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $data_edit = User::find($id);
        return redirect()->route('user.index', ['data_edit' => $data_edit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'level' => 'required',
            'kode_agent' => 'nullable',
            'unit' => 'nullable',
        ]);
        // dd($request->all());
        // dd($request->all(), $id);
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->level = $request->level;
        $data->kode_agent = $request->kode_agent;
        $data->unit = $request->unit;
        $data->save();
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);
        $data->delete();
    }
}
