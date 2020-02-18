<?php

namespace App\Http\Controllers;

use App\Http\Requests\HideRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\UserResource;
use App\User;
use App\Utils\GithubUserSearcher;

/**
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{
    /**
     * @var GithubUserSearcher
     */
    private $userSearcher;

    /**
     * UsersController constructor.
     * @param GithubUserSearcher $githubUserSearcher
     */
    public function __construct(GithubUserSearcher $githubUserSearcher)
    {
        $this->userSearcher = $githubUserSearcher;
    }

    /**
     * @param bool $all
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function users(bool $all = false)
    {
        $query = User::query();

        if (!$all) {
            $query->where('is_hide', 0);
        }

        $users = $query->orderBy('id', 'desc')->get();

        return UserResource::collection($users);
    }

    /**
     * @param SearchRequest $request
     * @return UserResource|\Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request)
    {
        $result = $this->userSearcher->run($request->input('login'));

        if ($result['status'] === $this->userSearcher::STATUS_SUCCESS) {
            $user = User::query()->create([
                'username' => $result['data']['login'],
                'avatar_url' => $result['data']['avatar_url'],
            ]);

            return new UserResource($user);
        } else {
            return response()->json([
                'errors' => [
                    'login' => [
                        $result['data']
                    ],
                ],
            ], 422);
        }
    }

    /**
     * @param User $user
     * @return UserResource
     */
    public function user(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * @param HideRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hide(HideRequest $request)
    {
        User::query()
            ->where('id', $request->input('id'))
            ->update([
                'is_hide' => $request->input('is_hide'),
            ]);

        return response()->json();
    }
}
