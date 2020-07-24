<?php
/**
 * This file contains Valitron\Validator settings.
 */
$lang = \Apricot\Lang::getLangCode();
return
[
    'lang_dir' => assets_dir('lang/'.$lang),
    'lang' => 'vlucas.valitron',
];
