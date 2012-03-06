<?php

namespace Testes;
use ArrayIterator;
use Testes\Assertion\AssertionInterface;
use Traversable;

abstract class RunableAbstract implements RunableInterface
{
    /**
     * The time it took for the test to run.
     * 
     * @var int
     */
    private $time = 0;

    /**
     * The amount of memory used during the test run.
     * 
     * @var int
     */
    private $memory = 0;

    /**
     * The time the test started.
     * 
     * @var int
     */
    private $startTimee = 0;

    /**
     * The time the test ended.
     * 
     * @var int
     */
    private $stopTime = 0;

    /**
     * The memory used at the start of the test.
     * 
     * @var int
     */
    private $startMemory = 0;

    /**
     * The memory used at the end of the test.
     * 
     * @var int
     */
    private $stopMemory = 0;

    /**
     * The peak memory used during the test.
     * 
     * @var int
     */
    private $peakMemory = 0;

    /**
     * All assertions.
     * 
     * @var array
     */
    private $assertions = array();

    /**
     * All failed assertions.
     * 
     * @var array
     */
    private $failedAssertions = array();

    /**
     * All passed assertions.
     * 
     * @var array
     */
    private $passedAssertions = array();

    /**
     * All exceptions.
     * 
     * @var array
     */
    private $exceptions = array();
    
    /**
     * Sets up the test.
     * 
     * @return void
     */
    public function setUp()
    {
        
    }
    
    /**
     * Tears down the test.
     * 
     * @return void
     */
    public function tearDown()
    {
        
    }
    
    /**
     * Returns whether or not the test passed.
     * 
     * @return bool
     */
    public function failed()
    {
        return !$this->passed();
    }
    
    /**
     * Returns whether or not the test passed.
     * 
     * @return bool
     */
    public function passed()
    {
        foreach ($this->assertions as $assertion) {
            if ($assertion->failed()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Starts the reporter.
     * 
     * @return Reporter
     */
    public function startBenchmark()
    {
        $this->startTimer();
        $this->startMemoryCounter();
        return $this;
    }

    /**
     * Stops the reporter.
     * 
     * @return Reporter
     */
    public function stopBenchmark()
    {
        $this->stopTimer();
        $this->stopMemoryCounter();
        return $this;
    }

    /**
     * Returns the number of milliseconds it took to run the tests.
     * 
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Returns the start time.
     * 
     * @return int
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Returns the start time.
     * 
     * @return int
     */
    public function getStopTime()
    {
        return $this->stopTime;
    }

    /**
     * Returns the peak amount of memory that was used during the test.
     * 
     * @return int
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * Returns the start memory.
     * 
     * @return int
     */
    public function getStartMemory()
    {
        return $this->startMemory;
    }

    /**
     * Returns the stop memory.
     * 
     * @return int
     */
    public function getStopMemory()
    {
        return $this->stopMemory;
    }

    /**
     * Starts the timer on the test. The start time is recored.
     * 
     * @return TestAbstract
     */
    private function startTimer()
    {
        $this->startTime = microtime(true);
        return $this;
    }

    /**
     * Stops the timer on the test. The stop time and total time it took the test to run is recorded.
     * 
     * @return TestAbstract
     */
    private function stopTimer()
    {
        $this->stopTime = microtime(true);
        $this->time     = $this->stopTime - $this->startTime;
        return $this;
    }

    /**
     * Starts the memory counter on the test. The start memory is recorded.
     * 
     * @return TestAbstract
     */
    private function startMemoryCounter()
    {
        $this->startMemory = memory_get_usage();
        return $this;
    }

    /**
     * Stops the memory counter on the test. The stop memory, peak memory and total memory used during the test is
     * recorded.
     * 
     * @return TestAbstract
     */
    private function stopMemoryCounter()
    {
        $this->stopMemory = memory_get_usage();
        $this->peakMemory = memory_get_peak_usage();
        $this->memory     = $this->peakMemory - $this->startMemory;
        return $this;
    }
}