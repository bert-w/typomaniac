<?php

namespace BertW\Typomaniac;

use BertW\Typomaniac\Mistakes\Mistake;

class Result
{
    /** @var array List of used mistakes and their frequency. */
    public $usedMistakes = [];

    /** @var array List of available mistakes. */
    public $mistakes = [];

    /** @var int The chance of a mistake (0 - 100). */
    public $chance;

    /** @var string */
    protected $output = '';

    /**
     * @param array|null $properties
     */
    public function __construct(array $properties = [])
    {
        foreach($properties as $key => $value) {
            if(property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function __toString()
    {
        return $this->output;
    }

    /**
     * @param Mistake $mistake
     * @return $this
     */
    public function pushUsedMistake(Mistake $mistake)
    {
        $mistake = get_class($mistake);
        if(!array_key_exists($mistake, $this->usedMistakes)) {
            $this->usedMistakes[$mistake] = 1;
        } else {
            $this->usedMistakes[$mistake] += 1;
        }
        return $this;
    }

    /**
     * Push a Mistake result or an arbitrary string (like the actual input) to the output string.
     * @param Mistake|string $mistake
     * @return $this
     */
    public function push($mistake)
    {
        if($mistake instanceof Mistake) {
            $this->output .= $mistake->make();
            $this->pushUsedMistake($mistake);
            return $this;
        }
        $this->output .= $mistake;
        return $this;
    }
}
