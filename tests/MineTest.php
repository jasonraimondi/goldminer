<?php
namespace Goldminer\Guts\Tests\SMS;

use Goldminer\Guts\Mine;

class MineTest extends \PHPUnit_Framework_TestCase
{
    const USER_ID = '250bd709-0abb-4d60-a677-936c27289cfb';
    const USER_NAME = 'JasonJames';

    /**
     * @var
     */
    protected $smsMessage;
    private $mine;

    public function setUp()
    {
        set_time_limit(1);
        $this->mine = new Mine();
    }

    // Yes, I know.
    public function testExcavate()
    {
        while(true) {
            $this->mine->mine();
            sleep(2);
        }
    }
}
