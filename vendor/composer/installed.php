<?php return array(
    'root' => array(
        'pretty_version' => 'dev-develop',
        'version' => 'dev-develop',
        'type' => 'wordpress-plugin',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'reference' => '5b8636882f494440f040b73fd3a243e90dbb950a',
        'name' => 'nexusmerchants/wp-stripe-billing-portal',
        'dev' => true,
    ),
    'versions' => array(
        'nexusmerchants/wp-stripe-billing-portal' => array(
            'pretty_version' => 'dev-develop',
            'version' => 'dev-develop',
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'reference' => '5b8636882f494440f040b73fd3a243e90dbb950a',
            'dev_requirement' => false,
        ),
        'stripe/stripe-php' => array(
            'pretty_version' => 'v7.128.0',
            'version' => '7.128.0.0',
            'type' => 'library',
            'install_path' => __DIR__ . '/../stripe/stripe-php',
            'aliases' => array(),
            'reference' => 'c704949c49b72985c76cc61063aa26fefbd2724e',
            'dev_requirement' => false,
        ),
    ),
);
