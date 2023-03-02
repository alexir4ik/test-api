<?php


namespace App\Repositories;

use App\Models\User;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class UserRepository
{
    public Model $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $user = $this->model->create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email'],
        ]);

        if ($user) {
            $user->createToken('api_token')->plainTextToken;

            return $user;
        }
    }

    public function getUserByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function passwordValidate($requestPassword, $dbPassword)
    {
        if (Hash::check($requestPassword, $dbPassword)) {
            return true;
        } else {
            return false;
        }
    }

    public function getToken($user)
    {
        return $user->tokens()->where('name', '=', 'api_token')->pluck('token')->first();
    }

    public function getTokenByHashedToken($hashedToken)
    {
        return PersonalAccessToken::query()->where('token', '=', $hashedToken)->first();
    }

    public function getUserByToken($token)
    {
        return $token->tokenable;
    }
}
