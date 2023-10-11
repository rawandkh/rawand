<?php

namespace App\Listeners\app\Listeners;

use App\Events\app\Events\RegisterEvent;
use App\Models\Code;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\app\Events\RegisterEvent  $event
     * @return void
     */
    public function handle(RegisterEvent $event)
    {
        do{
        $code=random_int(100000, 999999);
         }while(Code::where('code',$code)->exists());
         
         Code::create([
            'code'=>$code,
            'user_id'=>$event->data->user_id,
            'college_id'=>$event->data->college_id,
         ]);
    }
}
