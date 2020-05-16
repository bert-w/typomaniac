<?php

namespace BertW\Typomaniac\Mistakes;

/**
 * Change the character capitalization to either lower or uppercase.
 */
class CharacterChangeCapitalization extends Mistake
{
    public function make()
    {
        foreach($this->input as $char) {
            $this->output[] = $this->is_lowercase($char) ? strtoupper($char) : strtolower($char);
        }
        return $this->output();
    }

    public function end()
    {
        return count($this->input) >= 2;
    }

    protected function is_lowercase($str)
    {
        $chr = mb_substr($str, 0, 1, 'UTF-8');
        return mb_strtolower($chr, 'UTF-8') === $chr;
    }
}
