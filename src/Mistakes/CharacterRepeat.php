<?php

namespace BertW\Typomaniac\Mistakes;

/**
 * Repeat a character.
 */
class CharacterRepeat extends Mistake
{
    public function make()
    {
        foreach($this->input as $char) {
            $this->output[] = $char . $char;
        }
        return $this->output();
    }
}
