<?php

namespace App;

use App\Repositories\ClientPlanRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ClientPlan extends Model
{
    use HasFactory;
    protected $table = 'client_plans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['client_id ', 'plan_id ','equipment_included',
                           'expiration_date', 'payment_id', 'scheduled_renew_msg'];

    /**
     * Transforms dates to carbon
     * @var string[]
     */
    protected $dates = ['created_at', 'updated_at', 'expiration_date'];

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'client_id', 'usuario_id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class)->withTrashed();
    }

    public function allClasses(){
        return $this->hasMany(PlanClass::class, 'plan_id', 'id');
    }

    public function specificClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', )
            ->where('remaining_classes', '!=', null);
    }

    public function unlimitedClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', 1);
    }

    public function sharedClasses(){
        return $this->hasMany(RemainingClass::class, 'client_plan_id', 'id')
            ->where('unlimited', '=', 0)
            ->where('remaining_classes', '=', null);
    }

    public function clientLastPlanWithRemainingClasses(Request $request){
        $clientPlanRepository = new ClientPlanRepository();
        $lastPlanWithRemainingClasses = $clientPlanRepository->findValidClientPlan(clientId: $request->query('clientId'), extendedTimeToRenew: true);

        return response()->json([
            'success' => true,
            'lastPlanWithRemainingClasses' => $lastPlanWithRemainingClasses
        ], 200);
    }

}
