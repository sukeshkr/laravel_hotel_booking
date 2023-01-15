<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Stripe;
use Session;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function hotelsList(Request $request)
    {
        $request->validate([

            'destination' => 'required',
            'check_in'=> 'required',
            'check_out'=>'required',
            'rooms'=>'required',
            'adults'=>'required',
            'children'=>'required',
        ]);

        $datas = Hotel::where('location','like',"%{$request->destination}")->get();

        return view('hotel-list',compact('datas'));
    }

    public function hotelSearchData(Request $request)
    {
        if($request->ajax()) {

            $val = $request->rowVal;

            $res = Hotel::select('location')->where('location','like',"%{$val}%")->get();

            return response()->json([
                'result'=>$res,
            ]);
        }

    }

    public function hotelDetailsData($id)
    {
        $id = Crypt::decryptString($id);
        $datas = Room::where('hotel_id',$id)->get();
        return view('room-details',compact('datas'));
    }
    public function makeOrder(Request $request)
    {
        $request->validate([
            'price' => 'required|numeric',

        ]);

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->price,
                "currency" => "inr",
                "source" => $request->stripeToken,
                "description" => "Making test payment."
        ]);

        Session::flash('success', 'Payment has been successfully processed.');

        return back();
    }
}
