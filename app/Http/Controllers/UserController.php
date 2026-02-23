<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Actions\User\CreateUserAction;
use App\Http\Resources\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateUserRequest;
use App\Actions\User\UpdateUserAction;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = (int) request()->query('per_page', 15);
        $users = User::paginate($perPage);
        
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request, CreateUserAction $action): UserResource
    {
       return new UserResource($action->handle($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user):UserResource
    {
       return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): UserResource
    {
        return new UserResource($action->handle($request->validated(), $user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return response()->json(new \stdClass(), Response::HTTP_ACCEPTED);
    }
}
