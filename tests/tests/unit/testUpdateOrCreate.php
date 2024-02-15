<?php
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use DTApi\Helpers\TeHelper;

class HelperTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateOrUpdateUser()
    {
        $userData = [
            'role' => 'customer',
        ];
        $userController = new UserController();
        $result = $userController->createOrUpdate(null, $userData);
        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals($userData['role'], $result->user_type);
    }
}