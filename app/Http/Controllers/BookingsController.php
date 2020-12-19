<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Room;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingsController extends CrudController {

    public static function store(Request $request, $model, $id, $return_id = false)
    {
        $room = Room::where('room_number', $request->room_number)->first();
        $available = self::check_availability($request->arrival_date, $request->checkout_date, $request->room_number);
        if($available != 'available'){
            return self::generate_response($model, $available, true, 400);
        }
        if($request->initial_payment == $room->price){
            $status = "Paid";
        }else{
            $status = "Partially Paid";
        }
        $booking = new Booking();
        $booking->room_number = $room->room_number;
        $booking->arrival_date = Carbon::parse($request->arrival_date);
        $booking->checkout_date = Carbon::parse($request->checkout_date);
        $booking->status = $status;
        $booking->customer_id = Auth::user()->id;
        $booking->save();
        $payment = new Payment();
        $payment->date = Carbon::today();
        $payment->amount = $request->initial_payment;
        $payment->booking_id = $booking->id;
        $payment->customer_id = Auth::user()->id;
        return self::show($request, $model, $booking->id, false);
    }

    public static function check_availability($check_in, $check_out, $room_number){
        $bookings = Booking::where('room_number', $room_number)->get();
        foreach ($bookings as $booking){
            $stayPeriod = CarbonPeriod::create($booking->arrival_date, $booking->checkout_date);
            if($stayPeriod->contains(Carbon::parse($check_in))){
                return "Please try after ".$stayPeriod->getEndDate()->toDateString()." or before ".$stayPeriod->getStartDate()->toDateString();
                break;
            }else if($stayPeriod->contains(Carbon::parse($check_out))){
                return "Please checkout before ".$stayPeriod->getStartDate()->toDateString()." or check in after ". $stayPeriod->getEndDate()->toDateString();
                break;
            }
        }
        return 'available';
    }
}
