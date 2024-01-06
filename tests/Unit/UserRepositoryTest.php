<?php

namespace Tests\Unit;

use Mockery;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use App\DataTransferObjects\StoreUserDTO;
use App\Repositories\User\UserRepository;

class UserRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_user(): void
    {
        $userModel = Mockery::mock(User::class);
        $demoUser = new User([
            "id" => 1,
            "name" => "Majid",
            "email" => "majid@test.id"
        ]);
        $userDTO = new StoreUserDTO(name:"majid", email:"majid@test.id",password:"123456");
        $userModel->shouldReceive('create')->once()->andReturn($demoUser);
        $userRepository = new UserRepository($userModel);
        $this->assertEquals($userRepository->create($userDTO),$demoUser);
    }
}
