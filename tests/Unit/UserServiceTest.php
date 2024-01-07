<?php

namespace Tests\Unit;

use App\DataTransferObjects\StoreUserDTO;
use Mockery;
use App\Models\User;
use Tests\TestCase;
use App\Repositories\User\UserRepository;
use App\Services\UserService\UserService;

use function Laravel\Prompts\password;

class UserServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create_user(): void
    {
        $mockUserRepository = Mockery::mock(UserRepository::class)->makePartial();
        $userDTO = new StoreUserDTO(name:"majid", email:"majid@test.id",password:"123456");
        $demoUser = new User([
            "id" => 1,
            "name" => "Majid",
            "email" => "majid@test.id"
        ]);
        $mockUserRepository->shouldReceive('create')->once()->andReturn($demoUser);
        $userService = new UserService($mockUserRepository);
        $this->assertEquals($userService->create($userDTO), $demoUser);
        $this->assertTrue(true);
    }
}
