<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient\Tests\Campaign;

use EBC\PublisherClient\Tests\TestCase;
use EBC\PublisherClient\Campaign\Schedule;

/**
 * Schedule
 */
class ScheduleTest extends TestCase
{
    const CLASS_NAME = 'EBC\PublisherClient\Campaign\Schedule';

    public function testDeserialize()
    {
        /** @var Schedule $schedule */
        $schedule = $this->deserialize(
            array('start_date' => '2014-01-09 19:20:30', 'end_date' => '2014-01-28 09:18:05'),
            self::CLASS_NAME
        );

        $this->assertInstanceOf(self::CLASS_NAME, $schedule);

        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $schedule->getStartDate());
        $this->assertEquals('2014-01-09 19:20:30', $schedule->getStartDate()->formatAsString());
        $this->assertInstanceOf('EBT\EBDate\EBDateTime', $schedule->getEndDate());
        $this->assertEquals('2014-01-28 09:18:05', $schedule->getEndDate()->formatAsString());
    }
}
