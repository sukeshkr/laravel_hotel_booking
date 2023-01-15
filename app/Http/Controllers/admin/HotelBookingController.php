<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class HotelBookingController extends Controller
{
    public function index()
    {
        return view('admin.hotel.hotel');
    }
    public function getHotel()
    {
        return view('admin.hotel.create');
    }
    public function posteHotel(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'location'=>'required',
            'image'=>'required',
            'image_name'=>'required',
            'description'=>'required',
        ]);

        $folderPath = public_path('hotel/');
        if(!File::isDirectory($folderPath)){
            File::makeDirectory($folderPath, 0777, true, true);
        }
        $image_parts = explode(";base64,", $request->image_name);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $imageName = uniqid() . '.jpg';
        $imageFullPath = $folderPath.$imageName;
        file_put_contents($imageFullPath, $image_base64);

        $data = Hotel::create([
            'name'=> $request->name,
            'location'=> $request->location,
            'description'=> $request->description,
            'file_name'=> $imageName,
        ]);

        if($data) {
            return redirect()->back()->with('sucess','Created Sucessfully');
        }
        else {
            return redirect()->back()->with('error','Something went wrong');
        }
    }

    public function hotelFetch(Request $request)
    {
        $col_order = ['id','name'];
        $total_data = Hotel::count();
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $col_order[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value'))) {

            $post = Hotel::offset($start)->limit($limit)->orderBy($order,$dir)->get();
            $total_filtered = Hotel::count();
        }
        else {

            $search = $request->input('search.value');

            $post = Hotel::where('id','like',"%{$search}%")
            ->orWhere('name','like',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();

            $total_filtered = Hotel::where('id','like',"%{$search}%")
            ->orWhere('name','like',"%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->count();

        }
        $data = array();

        if($post) {

            $slno = 1;

            foreach($post as $row) {

                $data_edit =  route('hotel.edit',Crypt::encryptString($row->id));
                $img_path = asset("hotel/$row->file_name");

                $nest['slno'] = $slno++;
                $nest['name'] = $row->name;
                $nest['location'] = $row->location;
                $nest['description'] = $row->description;
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

    public function hotelEdit($id)
    {
        $data = Hotel::where('id', Crypt::decryptString($id))->first();
        return view('admin.hotel.edit-hotel',compact('data'));
    }
    public function hotelUpdate(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'location'=>'required',
            'description'=>'required',

        ]);

        if($request->file('image')) {

            $folderPath = public_path('hotel/');
            if(!File::isDirectory($folderPath)){
                File::makeDirectory($folderPath, 0777, true, true);
            }
            $image_parts = explode(";base64,", $request->image_name);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $imageName = uniqid() . '.jpg';
            $imageFullPath = $folderPath.$imageName;
            file_put_contents($imageFullPath, $image_base64);

            $data['file_name'] = $imageName;
        }

        $res = Hotel::where('id',$request->id)->update($data);
        return redirect()->back()->with('sucess','Updated Successsfully');
        return $request->id;
    }

    public function hotelDestroy()
    {
        if(request()->ajax()) {
            $res = Hotel::destroy(request()->rowid);
            return $res;
        }
    }
}
