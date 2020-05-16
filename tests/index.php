<?php

// Run `composer dump-autoload` first.
require __DIR__.'/../vendor/autoload.php';

$typo = new \BertW\Typomaniac\Typomaniac();

/**
 * Get some random articles from Wikipedia.
 * @return string
 */
function text()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://en.wikipedia.org/api/rest_v1/page/random/summary');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    return json_decode(curl_exec($ch), true)['extract'];
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
<div class="container">
    <?php for($i = 0; $i < 5; $i++): ?>
    <div class="card my-3">
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr><th class="w-50">Original</th><th>Typo'd</th></tr>
                </thead>
                <tbody>
                        <?php $message = text(); ?>
                        <?php $result = $typo->typo($message); ?>
                        <tr><td><?php echo $message; ?></td><td><?php echo $result; ?></td></tr>
                        <tr>
                            <td></td>
                            <td>
                                <table class="table table-sm table-striped text-danger">
                                <?php foreach($result->usedMistakes as $class => $count): ?>
                                    <tr>
                                        <td><?php echo $count; ?>x</td>
                                        <td><?php echo $class; ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </table>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php endfor ?>
</div>
