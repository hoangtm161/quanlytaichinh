<?php
/**
 * Created by PhpStorm.
 * User: TNC
 * Date: 8/1/18
 * Time: 09:48
 */

namespace App\Classes;


use App\Mail\UserActivationEmail;
use App\User;
use Mail;
use App\UserActivation;

class ActivationService
{
    protected $userActivation;

    public function __construct(UserActivation $userActivation)
    {
        $this->userActivation=$userActivation;
    }

    public function sendActivationEmail(User $user)
    {
        if ($user->active===true) {
            return;
        }
        $this->userActivation->createActivation($user);
        $activationEMail = new UserActivationEmail($user);
        Mail::to($user->email)->send($activationEMail);
    }

    public function activateUser(String $activationCode)
    {
        /*
        get activation record by activation code
        find user by users_id_foreign in user_activations table
        set active=true
        save user activation
        delete activation record in user_activations table
        */
        $activation = $this->userActivation->getActivationByActivationCode($activationCode);
        if ($this->userActivation===null) {
            return;
        }
        $user = User::find($activation->users_id_foreign);
        $user->active = true;
        $user->save();
        $this->userActivation->deleteActivationByActivationCode($activationCode);

        return $user;
    }


}