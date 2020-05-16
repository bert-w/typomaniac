# bert-w/typomaniac
[![Latest Stable Version](https://poser.pugx.org/bert-w/typomaniac/v/stable)](https://packagist.org/packages/bert-w/typomaniac)
[![Total Downloads](https://poser.pugx.org/bert-w/typomaniac/downloads)](https://packagist.org/packages/bert-w/typomaniac)
[![License](https://poser.pugx.org/bert-w/typomaniac/license)](https://packagist.org/packages/bert-w/typomaniac)

A library that creates deliberate spelling mistakes/typos for you.

### Installation instructions
`composer require bert-w/typomaniac`

### Quick start

##### Code Samples
```php
$typomaniac = new \BertW\Typomaniac\Typomaniac([
    // Chance of an error (0 - 100), decided per character (default).
    'chance' => 2,
    // Usable mistakes (default).
    'mistakes' => [
        BertW\Typomaniac\Mistakes\CharacterAccents::class,
        BertW\Typomaniac\Mistakes\CharacterRepeat::class,
        BertW\Typomaniac\Mistakes\CharactersFlip::class,
        BertW\Typomaniac\Mistakes\CharacterSkip::class,
        BertW\Typomaniac\Mistakes\KeyboardTypo::class,
        BertW\Typomaniac\Mistakes\CharacterChangeCapitalization::class,
    ],
]);

$result = $typomaniac->typo('Please create random typo\'s in this text. The longer the text the more chance of an error!');
```

It has a convenient `__toString()` method to get the actual string output:
```php
echo $result;

// Result:
// 'Please create randoom typo's in tihs text. The longer the text the more chance of an  error!'
```

`$result` also has more properties that could be useful:
```php
class Result {
    /** @var array List of used mistakes and their frequency. */
    public $usedMistakes = [];

    /** @var array List of available mistakes. */
    public $mistakes = [];

    /** @var int The chance of a mistake (0 - 100). */
    public $chance;
}
```

### Explanation of the various `Mistake` types
 - `CharacterAccents`: Make a mistake for misentered accent characters. `ü => "u || u"`.
 - `CharacterRepeat`: Repeat a character. `a => aa`
 - `CharactersFlip`: Flip a character with the previous one. `af => fa`
 - `CharacterSkip`: Skip a key stroke (simply returns an empty string). `a => (empty)`
 - `KeyboardTypo`: Choose a random key that is physically near another key on a QWERTY keyboard. `a => q`
 - `CharacterChangeCapitalization`: Change the character capitalization to either lower or uppercase. `A => a`
 
#### Adding your own mistake type
Before trying to add your own mistake class, please read the **Inner workings** below first.

To add your own spelling mistake, simply create a class and extend it from `BertW\Typomaniac\Mistakes\Mistake`. See the
source code for examples.
```php
// Add a mistake to the default mistake options (or assign it in the constructor).
$typomaniac->addMistake(\MyLibrary\FindSynonym::class);
$result = $typomaniac->typo(...);
```

### Inner workings
- Typomaniac loops your input string one character at a time.
- Per each character, the `$chance` property is used to determine whether a mistake should take place.
- Once this happens, one of the `Mistake` classes is randomly chosen as the current active Mistake.
- As long as the `Mistake->end()` function returns `false`, it will continue to push characters to the Mistake `input`.
This allows us to send a substring of arbitrary length of the input to the Mistake class. For instance, the
`CharactersFlip` class expects 2 characters and returns the 2 characters but flipped.
- Once the `Mistake->end()` function returns `true`, the Mistake class is asked to make a mistake on the received input.
i.e. `CharactersFlip` would return `'af'` for a given input string `'fa'`.
- The loop is continued, so a new Mistake can take place (or the end is reached, in which case, it stops).




