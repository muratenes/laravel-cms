<?php

use PhpCsFixer\Finder;

$rules = [
    '@PSR2'                                 => true,
    '@PHP70Migration'                       => true,
    '@PHP71Migration'                       => true,
    '@PHP73Migration'                       => true,
    '@Symfony'                              => true,
    '@Symfony:risky'                        => true,
    '@PhpCsFixer'                           => true,
    'array_syntax'                          => ['syntax' => 'short'],
    'array_indentation'                     => true,
    'binary_operator_spaces'                => ['operators' => ['=>' => 'align']],
    'increment_style'                       => ['style' => 'post'],
    'linebreak_after_opening_tag'           => true,
    'mb_str_functions'                      => true,
    'no_php4_constructor'                   => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_else'                       => true,
    'no_useless_return'                     => true,
    'not_operator_with_successor_space'     => true,
    'php_unit_strict'                       => true,
    'strict_comparison'                     => true,
    'strict_param'                          => true,
    'align_multiline_comment'               => ['comment_type' => 'all_multiline'],
    'backtick_to_shell_exec'                => true,
    'braces'                                => true,
    'indentation_type'                      => true,
    'phpdoc_order'                          => true,
    'method_chaining_indentation'           => true,
    'concat_space'                          => ['spacing' => 'one'],
    'ordered_imports'                       => true,
    //    'no_extra_consecutive_blank_lines'      => true,
    'blank_line_before_statement'              => true,
    'no_unused_imports'                        => true,
    'no_whitespace_in_blank_line'              => true,
    'blank_line_after_namespace'               => true,
    'single_blank_line_before_namespace'       => true,
    'single_line_after_imports'                => true,
    'blank_line_after_opening_tag'             => true,
    'no_empty_statement'                       => true,
    //    'trailing_comma_in_multiline_array'     => true,
    'no_blank_lines_after_class_opening'    => true,
    'no_blank_lines_after_phpdoc'           => true,
    'phpdoc_trim'                           => true,
    'phpdoc_indent'                         => true,
    'no_superfluous_phpdoc_tags'            => false,
    'phpdoc_add_missing_param_annotation'   => true,
    'phpdoc_scalar'                         => true,
    'phpdoc_to_comment'                     => false,
    //'phpdoc_to_param_type' => true,
    //'phpdoc_to_return_type' => true,
];

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->notName('*.blade.php')
    ->notName('.phpstorm.meta.php')
    ->notName('_ide_*.php')
    ->exclude('bootstrap/cache')
    ->exclude('node_modules')
    ->exclude('storage')
    ->ignoreVCS(true)
;

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
;
