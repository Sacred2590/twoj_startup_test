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
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $perPage = (int) request()->query('per_page', 15);
        $users = User::paginate($perPage);
        
        return UserResource::collection($users);
    }

    /**
     * @param CreateUserRequest $request
     * @param CreateUserAction $action
     * @return UserResource
     */
    public function store(CreateUserRequest $request, CreateUserAction $action): UserResource
    {
       return new UserResource($action->handle($request->validated()));
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function show(User $user):UserResource
    {
       return new UserResource($user);
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @param UpdateUserAction $action
     * @return UserResource
     */
    public function update(UpdateUserRequest $request, User $user, UpdateUserAction $action): UserResource
    {
        return new UserResource($action->handle($request->validated(), $user));
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();

        return response()->json(new \stdClass(), Response::HTTP_ACCEPTED);
    }
}
