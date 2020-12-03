<?php

abstract class Tester
{

    private int $success = 0;
    private array $failed = [];
    private int $tested = 0;
    private array $missing = [];

    abstract public function run(): void;

    public function __destruct()
    {
        echo 'Tests run: ' . $this->tested;
        echo PHP_EOL;
        echo 'success: ' . $this->success;
        if ($this->failed) {
            echo PHP_EOL;
            echo 'failed: ' . count($this->failed) . ' - ' . implode(', ', $this->failed);
        }
        if ($this->missing) {
            echo PHP_EOL;
            echo 'missing: ' . count($this->missing) . ' - ' . implode(', ', $this->missing);
        }
    }

    final public function getCalledMethod()
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);

        return $trace[2]['function'];
    }

    final public function methodList(): array
    {
        return array_diff(
            get_class_methods(static::class),
            get_class_methods('Tester')
        );
    }

    final public function _isEqual($expected, $actual, bool $strict = false): void
    {
        $this->tested++;
        if ($strict && $expected === $actual) {
            $this->success++;
        } elseif (false === $strict && $expected == $actual) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

    final public function _isNotEqual($expected, $actual, bool $strict = false): void
    {
        $this->tested++;
        if ($strict && $expected !== $actual) {
            $this->success++;
        } elseif (false === $strict && $expected != $actual) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod();
        }
    }

    final public function _isTrue(bool $isTrue, string $message = ''): void
    {
        $this->tested++;
        if (true === $isTrue) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod() . '[' . $message . ']';
        }
    }

    final public function _isFalse(bool $isFalse, string $message = ''): void
    {
        $this->tested++;
        if (false === $isFalse) {
            $this->success++;
        } else {
            $this->failed[] = $this->getCalledMethod() . '[' . $message . ']';
        }
    }

    final public function _missingTest(string $message = ''): void
    {
        $this->missing[] = $this->getCalledMethod() . '[' . $message . ']';
    }

}