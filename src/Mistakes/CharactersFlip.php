<?php

namespace BertW\Typomaniac\Mistakes;

/**
 * Flip a character with the previous one.
 */
class CharactersFlip extends Mistake
{
    public function make()
    {
        $this->output = array_reverse($this->input);
        return $this->output();
    }

    public function end()
    {
        return count($this->input) >= 2;
    }
}
