<?php

namespace BertW\Typomaniac;

use BertW\Typomaniac\Mistakes\CharacterAccents;
use BertW\Typomaniac\Mistakes\CharacterChangeCapitalization;
use BertW\Typomaniac\Mistakes\CharacterRepeat;
use BertW\Typomaniac\Mistakes\CharactersFlip;
use BertW\Typomaniac\Mistakes\CharacterSkip;
use BertW\Typomaniac\Mistakes\KeyboardTypo;
use BertW\Typomaniac\Mistakes\Mistake;

class Typomaniac
{
    /** @var string[] */
    protected $mistakes = [
        CharacterAccents::class,
        CharacterRepeat::class,
        CharactersFlip::class,
        CharacterSkip::class,
        KeyboardTypo::class,
        CharacterChangeCapitalization::class,
    ];

    /** @var int */
    protected $chance = 2;

    /**
     * @param array|null $options
     */
    public function __construct(array $options = [])
    {
        foreach($options as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    /**
     * @param string $str
     * @param array|null $options Override the options for this typo creation.
     * @return Result
     */
    public function typo($str, array $options = [])
    {
        $result = new Result(array_merge([
            'chance' => $this->chance,
            'mistakes' => $this->mistakes,
        ], $options));

        $mistake = null;
        $strEnd = strlen($str) - 1;
        foreach($this->split($str) as $i => $char) {
            if($mistake || $this->chance($result->chance)) {
                $mistake = $mistake ?: $this->selectMistake($result->mistakes);
                $mistake->push($char);
                if($mistake->end() || $i >= $strEnd) {
                    $result->push($mistake);
                    $mistake = null;
                }
                continue;
            }
            $result->push($char);
        }
        return $result;
    }

    /**
     * Split a string into individual characters.
     * @param string $str
     * @return array
     */
    protected function split($str)
    {
        return preg_split('//u', $str, -1, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Add a new mistake to the array.
     * @param string $mistake
     */
    public function addMistake($mistake)
    {
        $this->mistakes[] = $mistake;
    }

    /**
     * @param array|null $mistakes
     * @return Mistake
     */
    protected function selectMistake($mistakes = null)
    {
        $element = $this->randomFromArray(!is_null($mistakes) ? $mistakes : $this->mistakes);
        return new $element;
    }

    /**
     * @param array $array
     * @return mixed
     */
    protected function randomFromArray($array)
    {
        return $array[array_rand($array)];
    }

    /**
     * @param int $chance
     * @return bool
     * @throws \Exception
     */
    protected function chance($chance)
    {
        return random_int(0, 100) <= $chance;
    }
}
