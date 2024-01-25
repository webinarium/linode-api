<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony'                        => true,
        '@Symfony:risky'                  => true,
        '@PhpCsFixer'                     => true,
        '@PhpCsFixer:risky'               => true,
        '@DoctrineAnnotation'             => true,
        '@PHP80Migration:risky'           => true,
        '@PHP83Migration'                 => true,
        '@PHPUnit100Migration:risky'      => true,

        // Rules override
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
        'concat_space'                    => ['spacing' => 'one'],
        'declare_strict_types'            => false,
        'increment_style'                 => ['style' => 'post'],
        'native_function_invocation'      => false,
        'phpdoc_annotation_without_dot'   => false,
        'whitespace_after_comma_in_array' => ['ensure_single_space' => false],
    ])
    ->setFinder($finder)
;
