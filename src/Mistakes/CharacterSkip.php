<?php

namespace BertW\Typomaniac\Mistakes;

/**
 * Skip a key stroke (simply returns an empty string).
 */
class CharacterSkip extends Mistake
{
    public function make()
    {
        return $this->output();
    }
}
