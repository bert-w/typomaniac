<?php

namespace BertW\Typomaniac\Mistakes;

/**
 * Choose a random key that is physically near another key on a QWERTY keyboard.
 */
class KeyboardTypo extends Mistake
{
    const KEYBOARD_QWERTY = [
        ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0', '-', '='],
        [null, 'q', 'w', 'e', 'r', 't', 'y', 'u', 'i', 'o', 'p', '[', ']'],
        [null, 'a', 's', 'd', 'f', 'g', 'h', 'j', 'k', 'l', ';', ','],
        [null, 'z', 'x', 'c', 'v', 'b', 'n', 'm', ',', '.', '/']
    ];

    const KEYBOARD_QWERTY_UPPERCASE = [
        ['!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '+'],
        [null, 'Q', 'W', 'E', 'R', 'T', 'Y', 'U', 'I', 'O', 'P', '{', '}'],
        [null, 'A', 'S', 'D', 'F', 'G', 'H', 'J', 'K', 'L', ':', '"'],
        [null, 'Z', 'X', 'C', 'V', 'B', 'N', 'M', '<', '>', '?']
    ];

    public function make()
    {
        $keyboard = self::KEYBOARD_QWERTY;
        foreach($this->input as $char) {
            foreach($keyboard as $rowIndex => $row) {
                foreach($row as $keyIndex => $key) {
                    if($key === $char) {
                        $newRowIndex = $this->newIndex($rowIndex, count($keyboard));
                        $newKeyIndex = $this->newIndex($keyIndex, count($keyboard[$newRowIndex]));
                        try {
                            $newKey = $keyboard[$newRowIndex];
                            $newKey = $newKey[$newKeyIndex];
                        } catch(\Exception $e) {
                            var_dump(compact('newRowIndex', 'newKeyIndex'));
                            throw $e;
                        }
                        $this->output[] = is_null($newKey) ? $key : $newKey;
                    }
                }
            }
        }
        return $this->output();
    }

    protected function newIndex($index, $length)
    {
        return $this->chance(50) ? ($index > 0 ? $index - 1 : 0) : ($index + 1 < $length ? $index + 1 : $length - 1);
    }
}
