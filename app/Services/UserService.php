<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Laravel\Sanctum\PersonalAccessToken;


class UserService
{
    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function loginUser(array $data)
    {
        $user = $this->repo->getUserByEmail($data['email']);

        if ($user) {
            if ($this->repo->passwordValidate($data['password'], $user->password)) {
                return $this->repo->getToken($user);
            }
        }
    }


    public function getUser($hashedToken)
    {
        $token = $this->repo->getTokenByHashedToken($hashedToken);
        
        return $this->repo->getUserByToken($token);
    }
}
