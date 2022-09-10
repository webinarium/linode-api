<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([

        //--------------------------------------------------------------
        //  Rule sets
        //--------------------------------------------------------------
        '@Symfony'                        => true,
        '@Symfony:risky'                  => true,
        '@PhpCsFixer'                     => true,
        '@PhpCsFixer:risky'               => true,
        '@DoctrineAnnotation'             => true,
        '@PHP74Migration'                 => true,
        '@PHP74Migration:risky'           => true,
        '@PHPUnit84Migration:risky'       => true,

        //--------------------------------------------------------------
        //  Rules override
        //--------------------------------------------------------------
        'binary_operator_spaces'          => [
            'default'   => null,
            'operators' => [
                '='   => 'align',
                '+='  => 'align',
                '-='  => 'align',
                '*='  => 'align',
                '/='  => 'align',
                '%='  => 'align',
                '**=' => 'align',
                '&='  => 'align',
                '|='  => 'align',
                '^='  => 'align',
                '<<=' => 'align',
                '>>=' => 'align',
                '.='  => 'align',
                '??=' => 'align',
                '=>'  => 'align',
            ],
        ],
        'braces'                          => false,
        'concat_space'                    => ['spacing' => 'one'],
        'declare_strict_types'            => false,
        'function_typehint_space'         => false,
        'increment_style'                 => ['style' => 'post'],
        'native_function_invocation'      => false,
        'no_extra_blank_lines'            => true,
        'self_static_accessor'            => true,
        'single_line_comment_spacing'     => false,
        'whitespace_after_comma_in_array' => ['ensure_single_space' => false],
        'yoda_style'                      => false,
    ])
    ->setFinder($finder)
;
