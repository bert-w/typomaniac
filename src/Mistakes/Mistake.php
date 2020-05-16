<?php

namespace BertW\Typomaniac\Mistakes;

abstract class Mistake
{
    /** @var array */
    protected $input = [];

    /** @var array */
    protected $output = [];

    public function __construct($chars = [])
    {
        $this->input = $chars;
    }

    /**
     * @return string
     */
    protected function output()
    {
        return join('', $this->output);
    }

    /**
     * Add a character to the input array.
     * @param string $char
     * @return $this
     */
    public function push($char)
    {
        $this->input[] = $char;
        return $this;
    }

    /**
     * Decide when to stop receiving input.
     * By default, all mistakes act on a single character.
     * @return bool
     */
    public function end()
    {
        return true;
    }

    /** @return string */
    abstract public function make();

    /**
     * Convenience function to pick a chance.
     * @param int $chance Integer from 0 to 100.
     * @return bool
     * @throws \Exception
     */
    protected function chance($chance)
    {
        return random_int(0, 100) <= $chance;
    }
}
