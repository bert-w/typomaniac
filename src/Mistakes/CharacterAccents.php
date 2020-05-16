<?php


namespace BertW\Typomaniac\Mistakes;

/**
 * Make a mistake for misentered accent characters, so ü ends up like "u  or u".
 */
class CharacterAccents extends Mistake
{
    const ACUTE = ['á', 'Á', 'é', 'É', 'í', 'Í', 'ó', 'Ó', 'ú', 'Ú', 'ç', 'Ç'];
    const GRAVE = ['à', 'À', 'è', 'È', 'ì', 'Ì', 'ò', 'Ò', 'ù', 'Ù'];
    const CIRCUMFLEX = ['â', 'Â', 'ê', 'Ê', 'î', 'Î', 'ô', 'Ô', 'û', 'Û',];
    const UMLAUT = ['ä', 'Ä', 'ë', 'Ë', 'ï', 'Ï', 'ö', 'Ö', 'ü', 'Ü'];
    const TILDE = ['ñ', 'Ñ'];

    const KEY = [
        '\'' => self::ACUTE,
        '`' => self::GRAVE,
        '^' => self::CIRCUMFLEX,
        '"' => self::UMLAUT,
        '~' => self::TILDE,
    ];

    const ROOT_CHARACTER = [
        'a' => ['á', 'à', 'ä', 'â', 'ª'],
        'A' => ['Á', 'À', 'Â', 'Ä'],
        'e' => ['é', 'è', 'ë', 'ê',],
        'E' => ['É', 'È', 'Ê', 'Ë'],
        'i' => ['í', 'ì', 'ï', 'î',],
        'I' => ['Í', 'Ì', 'Ï', 'Î'],
        'o' => ['ó', 'ò', 'ö', 'ô',],
        'O' => ['Ó', 'Ò', 'Ö', 'Ô'],
        'u' => ['ú', 'ù', 'ü', 'û',],
        'U' => ['Ú', 'Ù', 'Û', 'Ü'],
        'n' => ['ñ'],
        'N' => ['Ñ'],
        'c' => ['ç'],
        'C' => ['Ç'],
    ];

    const A = ['á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'];
    const E = ['é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'];
    const I = ['í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'];
    const O = ['ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'];
    const U = ['ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'];
    const N = ['ñ', 'Ñ'];
    const C = ['ç', 'Ç'];

    public function make()
    {
        foreach($this->input as $char) {
            foreach(self::KEY as $key => $characters) {
                if(in_array($char, $characters)) {
                    $rootChar = $this->getRootCharacter($char);
                    $this->output[] = $this->chance(50) ? $key . $rootChar : $rootChar . $key;
                    continue(2);
                }
            }
            $this->output[] = $char;
        }
        return $this->output();
    }

    /**
     * Get the unaccentuated character for the given input.
     * @param string $char
     * @return string
     */
    protected function getRootCharacter($char)
    {
        foreach(self::ROOT_CHARACTER as $root => $characters) {
            if(in_array($char, $characters)) {
                return $root;
            }
        }
        return $char;
    }
}
