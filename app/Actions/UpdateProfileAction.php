<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

class UpdateProfileAction
{
    public function handle(array $data) {
        Auth::user()->update($data);
    }
}
