<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcribtionPlan;
use App\Models\UserSubcribtion;
use Carbon\Carbon;
use Auth;
use Termwind\Components\Raw;
use Str;
use Midtrans;


class SubcribtionPlanController extends Controller
{

   public function __construct()
   {
      // Set your Merchant Server Key
      \Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
      // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
      \Midtrans\Config::$isProduction = false;
      // Set sanitization on (default)
      \Midtrans\Config::$isSanitized = false;
      // Set 3DS transaction for credit card to true
      \Midtrans\Config::$is3ds = false;
   }

   public function index(){

    $subcribtionPlans = SubcribtionPlan::all();
       return inertia('User/Dashboard/SubcribtionPlan/Index', [
            'subcribtionPlans'=>SubcribtionPlan::all(),
             'userSubcribtion'=> null,
        ]);
   } //

   public function userSubcribe(Request $request, SubcribtionPlan $subcribtionPlan){

      $data=[
         'user_id' => Auth::id(),
         'subcribtion_plan_id'=>$subcribtionPlan->id,
         'price'=> $subcribtionPlan->price,
         'payment_status'=>'pending'

      ];

      $userSubcribtion= UserSubcribtion::create($data);

        $params = [
            'transaction_details' => [
                'order_id' => $userSubcribtion->id.'-'.Str::random(5),
                'gross_amount' => $userSubcribtion->price
            ]
        ];

      $snap_token = \Midtrans\Snap::getSnapToken($params);

      $userSubcribtion->update([
            'snap_token' => $snap_token
        ]);

      return inertia('User/Dashboard/SubcribtionPlan/Index', [
            'userSubcribtion'=> $userSubcribtion,
        ]);
      
   }

    public function midtransCallback(Request $request)
    {
        $notif = new Midtrans\Notification();

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $transaction_id = explode('-', $notif->order_id)[0];
        $userSubcribtion = UserSubcribtion::find($transaction_id);

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $userSubcribtion->payment_status = 'pending';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $userSubcribtion->payment_status = 'paid';
                $userSubcribtion->expired_date = Carbon::now()->addMonths((int) $userSubcribtion->subcribtionPlan->active_period_in_months);
            }
        }
        else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $userSubcribtion->payment_status = 'failed';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $userSubcribtion->payment_status = 'failed';
            }
        }
        else if ($transaction_status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $userSubcribtion->payment_status = 'failed';
        }
        else if ($transaction_status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $userSubcribtion->payment_status = 'paid';
            $userSubcribtion->expired_date = Carbon::now()->addMonths((int) $userSubcribtion->subcribtionPlan->active_period_in_months);
        }
        else if ($transaction_status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $userSubcribtion->payment_status = 'pending';
        }
        else if ($transaction_status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $userSubcribtion->payment_status = 'failed';
        }

        $userSubcribtion->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Payment success'
        ]);
    }
}
