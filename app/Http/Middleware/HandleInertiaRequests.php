<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;
use Auth;
use Carbon\Carbon;
use Session;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    public function activePlan(){
        $activePlan = Auth::user()?Auth::user()->lastActiveUserSubcribtion:null;

        if(!$activePlan){
        return null;
        }

        $lastDay= Carbon::parse($activePlan->update_at)->addMonths($activePlan->subcribtionPlan->active_period_in_months);
        $activeDays=Carbon::parse($activePlan->update_at)->diffInDays($lastDay);
        $remainingActiveDays=Carbon::parse($activePlan->expired_date)->diffInDays(Carbon::now());

        return [
            'name' => $activePlan->subcribtionPlan->name, 
            'remainingActiveDays'=>$remainingActiveDays,
            'activeDays'=>$activeDays,
        ];
    }
    /**
     *
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
                'activePlan'=>$this->activePlan()
            ],
            'flashMessage' => [
                'message' => Session::get('message'),
                'type' => Session::get('type'),
            ],
             'env' => [
                'MIDTRANS_CLIENTKEY' => env('MIDTRANS_CLIENTKEY')
              
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
