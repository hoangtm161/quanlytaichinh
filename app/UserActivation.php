<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    protected $table='user_activations';

    protected $fillable=[
        'users_id_foreign',
        'activation_code'
    ];

    public function getActivationCode()
    {
        return hash_hmac('sha256', str_random(40), config('app.key'));
    }

    public function createActivation(User $user)
    {
        $activation = $this->getActivationByUserID($user);
        if (!$activation) {
            return $this->generateActivationCode($user);
        }
        return $this->regenerateActivationCode($user);
    }

    private function regenerateActivationCode(User $user)
    {
        $activationCode = $this->getActivationCode();
        UserActivation::where('users_id_foreign',$user->id)->update([
            'activation_code' => $activationCode,
        ]);
        return $activationCode;
    }

    private function generateActivationCode(User $user)
    {
       // dd($user);
        $activationCode = $this->getActivationCode();
        UserActivation::create([
            'users_id_foreign' => $user->id,
            'activation_code' =>$activationCode,
        ]);
        return $activationCode;
    }

    public function getActivationByUserID(User $user)
    {
        return UserActivation::where('users_id_foreign',$user->id)->first();
    }

    public function getActivationByActivationCode(String $activationCode)
    {
        return UserActivation::where('activation_code',$activationCode)->first();
    }

    public function deleteActivationByActivationCode(String $activationCode)
    {
        UserActivation::where('activation_code',$activationCode)->delete();
    }

}
