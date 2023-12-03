<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

class CreateForUserObserver
{
    public function created(Model $model)
    {
        if(auth()->check()) {
            $model->user_id = auth()->user()->id;
            $model->save();
        }
    }
}
