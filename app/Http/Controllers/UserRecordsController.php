<?php

namespace App\Http\Controllers;

use App\Models\UserRecords;
use Illuminate\Http\Request;
use Validator;
use Response;
use DataTables;

class UserRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = UserRecords::where('is_deleted',0)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url= asset('storage/'.$row->image);
                    return '<img src="'.$url.'" border="0" style="border-radius: 50%;" width="40" height="40" />';
                })
                ->addColumn('experience', function ($row) {
                    if($row->date_of_leaving == null) {
                        $row->date_of_leaving = date('Y-m-d');
                    }
                    $date_diff = abs(strtotime($row->date_of_joining) - strtotime($row->date_of_leaving));
                    $years = floor($date_diff / (365*60*60*24));
                    $months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
                    if($months == 0) {
                        return $years.' Years ';
                    } else {
                        return $years.' Years '.$months.' Months';
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"> Delete</a>';
                    return $btn;
                })
                ->rawColumns(['experience','image','action'])
                ->make(true);
        }

        return view('userRecords.index');
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
        $requestData = $request->all();

        if(!isset($requestData['still_working'])) {
            $requestData['still_working'] = 'off';
        }

        $validator = Validator::make(
            $requestData,
            [
                'name' => 'required',
                'email' => 'required|email|unique:user_records',
                'date_of_joining' => 'required',
                'date_of_leaving' => 'required_if:still_working,off',
                'image' => 'required|mimes:jpeg,png,jpg,svg',
            ]
        );

        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ), 400); // 400 being the HTTP code for an invalid request.
        }

        $requestData['date_of_joining'] = date('Y-m-d',strtotime($requestData['date_of_joining']));
        if($requestData['date_of_leaving'] != null) {
            $requestData['date_of_leaving'] = date('Y-m-d',strtotime($requestData['date_of_leaving']));
        }

        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();

            $temp = explode(".", $imageName);
            $newFileName = round(microtime(true)) . '.' . end($temp);

            $path = $request->file('image')->storeAs('uploads', $newFileName, 'public');
            $requestData['image'] = $path;
        }

        UserRecords::create($requestData);

        return redirect()->route('userRecords.index')
            ->with('success','User record added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRecords  $userRecords
     * @return \Illuminate\Http\Response
     */
    public function show(UserRecords $userRecords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRecords  $userRecords
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRecords $userRecords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRecords  $userRecords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRecords $userRecords)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRecords  $userRecords
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userRecords = UserRecords::find($id);
        $userRecords->is_deleted = 1;
        $userRecords->save();

        return response()->json(['success'=>'User Record deleted successfully.']);
    }
}
