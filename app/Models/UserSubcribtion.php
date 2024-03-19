<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\SubcribtionPlan;

class UserSubcribtion extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =['userd_id','subcribtion_plan_id','price','expired_date','payment_status','snap_token'];

    public function subcribtionPlan(): BelongsTo{
        return $this->belongsTo(SubcribtionPlan::class);
    }
}
