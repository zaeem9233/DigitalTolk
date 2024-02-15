<?php
use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use DTApi\Helpers\TeHelper;

class HelperTest extends TestCase
{
    public function testWillExpireAt()
    {
        $due_time = '2024-02-15 10:00:00';
        $created_at = '2024-02-10 08:00:00';
        $result = TeHelper::willExpireAt($due_time, $created_at);
        $this->assertEquals('2024-02-14 14:00:00', $result);
    }
}