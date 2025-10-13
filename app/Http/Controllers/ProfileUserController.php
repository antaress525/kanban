<?php

namespace App\Http\Controllers;

use App\Actions\UpdateProfileAction;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdateProfileUserRequest;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    public function update(UpdateProfileUserRequest $request, UpdateProfileAction $action) {
        $action->handle($request->validated());
    }
}
