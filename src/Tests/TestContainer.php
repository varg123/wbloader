<?php


namespace Tests;


use Tests\Tests\ProductParams;

class TestContainer
{
    private $testList;

    public function __construct(array $testList)
    {
        $this->testList = $testList;
    }

    public function start()
    {
        /**
         * @var $test ITest
         */
        $messages = [];
        $i = 1;
        foreach ($this->testList as $test) {
            $testResult = $test->test();
            if ($testResult) {
                $messages[] = "-{$i}." . $test->getName() . ': ' . implode(', ', $testResult);
            } else {
                $messages[] = "+{$i}." . $test->getName() . ': OK!';
            }
            $i++;
        }
        return $messages;
    }
}