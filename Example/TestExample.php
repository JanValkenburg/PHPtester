<?php
declare(strict_types = 1);

require_once __DIR__ . '/../src/Tester.php';

class TestExample extends Tester
{
    public function run(): void
    {
        foreach ($this->methodList() as $method) {
            $this->$method();
        }
    }

    protected function isEqual(): void
    {
        $this->_isEqual(2, 2);
    }

    protected function isNotEqual(): void
    {
        $this->_isNotEqual(2, 1);
    }

    protected function isTrue(): void
    {
        $this->_isTrue(true);
    }

    protected function isFalse(): void
    {
        $this->_isFalse(false);
    }

    protected function isNotFalse(): void
    {
        $this->_isFalse(true);
    }

    protected function missingTest(): void
    {
        $this->_missingTest('todo');
    }

}

(new TestExample())->run();