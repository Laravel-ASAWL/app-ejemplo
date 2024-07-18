<?php

return [
    'target_php_version' => 8.1,

    'directory_list' => [
        'app/',
        'database/',
        'resources/',
        'routes/',
        'tests/Feature/App',
        'tests/Feature/Database',
        'tests/Feature/Resources',
        'tests/Feature/Routes',
    ],

    'exclude_file_regex' => '@^vendor/.*/(tests?|Tests?)/@',

    'exclude_analysis_directory_list' => [
        'vendor/',
    ],

    'suppress_issue_types' => [
        'PhanRedundantArrayValuesCall',
        'PhanSuspiciousWeakTypeComparison',
        'PhanTypeMismatchPropertyDefault',
        'PhanUndeclaredClassInstanceof',
        'PhanUndeclaredClassMethod',
        'PhanUndeclaredClassReference',
        'PhanUndeclaredExtendedClass',
        'PhanUndeclaredFunction',
        'PhanUndeclaredInterface',
        'PhanUndeclaredMethod',
        'PhanUndeclaredProperty',
        'PhanUndeclaredStaticMethod',
        'PhanUndeclaredThis',
        'PhanUndeclaredTrait',
        'PhanUndeclaredTypeParameter',
        'PhanUndeclaredTypeReturnType',
    ],
];
