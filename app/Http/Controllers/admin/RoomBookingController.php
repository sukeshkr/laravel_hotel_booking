<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Specification;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;

class RoomBookingController extends Controller
{
    public function index()
    {
        return view('admin.room.room');
    }
    public function getRoom()
    {
        $datas = Hotel::all();
        return view('admin.room.create',compact('datas'));
    }
    public function postRoom(Request $request)
    {
        $request->validate([

            'room_no'=>'required',
            'hotel'=>'required',
            'price'=>'required',
            'file'=>'required',
            'specification.*'=>'required',
        ]);

        $file_name = $request->file('file')->hashName();
        $request->file->move(public_path('room'),$file_name);

        $data = Room::create([
            'room_no'=>$request->room_no,
            'hotel_id'=>$request->hotel,
            'price'=>$request->price,
            'file'=>$file_name,
        ]);

        $specifications = $request->specification;

        if($data) {

            for ($i=0; $i < count($specifications); $i++) {

                $dataSave = [
                    'room_id' => $data->id,
                    'specification'=> $request->specification[$i],
                ];

                Specification::create($dataSave);
            }

            return redirect()->back()->with('sucess','Created Sucessfully');
        }
        else {

            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function roomFetch(Request $request)
    {
        $col_order = ['room_no','price'];
        $total_data = Room::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {

            $post = Room::offset($start)->limit($limit)->orderBy($order,$dir)->get();
            $total_filtered = Room::count();
        }
        else {

            $search = $request->input('search.value');

            $post = Room::where('id','like',"%{$search}%")
            ->orWhere('room_no','like',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $total_filtered = Room::where('id','like',"%{$search}%")
            ->orWhere('room_no','like',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();

        }
        $data = array();

        if($post) {

            $slno = 1;

            foreach($post as $row) {

                $data_edit =  route('room.edit',Crypt::encryptString($row->id));
                $img_path = asset("room/$row->file");

                $specifications = $row->specifications->map(function($specifications, $key) {
                    return ucwords($specifications->specification);
                });

                $nest['slno'] = $slno++;
                $nest['room_no'] = $row->room_no;
                $nest['price'] = $row->price;
                $nest['hotel'] = $row->hotel->name;
                $nest['specifications'] = $specifications;
                $nest['image'] = "<img width='100' height='60' src='{$img_path}' alt='blog'>";
                $nest['actions'] = "<a href='{$data_edit}' class='btn btn-primary btn-sm'><i class='fa fa-edit' aria-hidden='true'></i></a>
                <a data-toggle='modal' data-id='{$row->id}' data-target='#del-modal' class='btn btn-danger btn-sm' href='#'><i class='fa  fa-trash' aria-hidden='true'></i></a>";
                $data[] = $nest;
            }
       }

       $json = array(
            'draw' => intval($request->input('draw')),
            'recordsTotal'=>intval($total_data),
            'recordsFiltered'=>intval($total_filtered),
            'data'=>$data,
       );

       echo json_encode($json);
    }

    public function roomEdit($id)
    {
        $datas = Hotel::all();
        $roomData = Room::where('id',Crypt::decryptString($id))->first();
        return view('admin.room.edit-room',compact('roomData','datas'));
    }

    public function roomUpdate(Request $request)
    {
        $data = $request->validate([
            'room_no' => 'required|numeric',
            'hotel_id' => 'required',
            'price' => 'required|numeric|between:1,9999999',
        ]);

        if($request->file('file')) {

            $file_name = $request->file('file')->hashName();
            $request->file->move(public_path('room'),$file_name);
            $data['file'] = $file_name;
        }

        if(Arr::whereNotNull($request->specification)) {

           foreach ($request->specification as $speciValue) {

            $dataSave = [
                'room_id' => $request->id,
                'specification'=> $speciValue,
            ];

            Specification::create($dataSave);
           }
        }
        Room::where('id',$request->id)->update($data);

        return redirect()->back()->with('sucess','Updated Sucessfully');

    }

    public function roomDestroy()
    {
        if(request()->ajax()) {
            $res = Room::destroy(request()->rowid);
            return $res;
        }
    }

}
