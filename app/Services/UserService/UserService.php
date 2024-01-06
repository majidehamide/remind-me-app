<?php

namespace App\Services\UserService;

use App\DataTransferObjects\StoreUserDTO;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;

class UserService
{
    protected $userRepository;
    
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function create(StoreUserDTO $storeUserDTO):User{
        return $this->userRepository->create($storeUserDTO->toArray());
    }
}
