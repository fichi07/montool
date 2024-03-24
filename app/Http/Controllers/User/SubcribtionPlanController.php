<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubcribtionPlan;
use App\Models\UserSubcribtion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class SubcribtionPlanController extends Controller
{
   public function index(){
    $subcribtionPlan = SubcribtionPlan::all();

       return inertia('User/Dashboard/SubcribtionPlan/Index', [
            'subcribtionPlans'=>SubcribtionPlan::all(),
        ]);
   } //

   public function userSubcribe(Request $request, SubcribtionPlan $subcribtionPlan){

      $data=[
         'user_id' => Auth::id(),
         'subcribtion_plan_id'=>$subcribtionPlan->id,
         'price'=> $subcribtionPlan->price,
         'expired_date'=>Carbon::now()->addMonths($subcribtionPlan->active_period_in_months),
         'payment_status'=>'paid'

      ];

      $userSubcribtion= UserSubcribtion::create($data);
      return redirect(route('user.dashboard.index'));
      
   }
}
