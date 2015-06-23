<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('src')
    ->name('*.php');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::CONTRIB_LEVEL)
    ->fixers([
        '-php4_constructor',
        '-long_array_syntax',
        'short_array_syntax',
        'ordered_use',
        'concat_with_spaces',
        'multiline_spaces_before_semicolon',
        'align_double_arrow',
        'align_equals'
    ])
    ->finder($finder);
