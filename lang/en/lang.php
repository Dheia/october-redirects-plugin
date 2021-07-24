<?php 

return [
    'plugin' => [
        'name' => 'Simple Redirects',
        'description' => 'Manage custom redirections and force HTTPS / (Non-)WWW location requests.'
    ],
    
    'menu' => [
        'name' => 'Redirects',
        'description' => 'Manage redirections and HTTPS / (Non-)WWW requests.'
    ],

    'config' => [
        'tabs' => [
            'redirects' => 'Custom Redirects',
            'force' => 'HTTPs & WWW'
        ],

        'redirects' => [
            'source' => 'Source URL / Slug',
            'status' => 'Status Code',
            'destination' => 'Destination URL / Slug',
            'get' => 'Disable on ?noRedirect GET Parameter',
            'prompt' => 'Add new redirection' 
        ],

        'force' => [
            'section_https' => 'HTTPs Configuration',
            'section_www' => 'WWW Configuration',
            'section_test' => 'Test Settings',
            'https_force' => 'Force HTTPS everywhere',
            'https_force_desc' => 'Make sure your server accepts HTTPs requests.',
            'http_get_mode' => 'noSSL Request Parameter',
            'http_get_mode_desc' => 'Disable on ?noSSL GET parameter.',
            'www_force' => 'Force (Non-)WWW everywhere',
            'www_force_desc' => 'Toggle WWW or (Non-WWW) redirections.',
            'www_mode' => '(Non-)WWW direction',
            'www_mode_desc' => 'Off means Non-WWW to WWW redirection, On the opposite.',
            'status_code_desc' => 'Google recommends using 301 (Permanent redirects) in such cases.'
        ],

        'https_test' => [
            'action' => 'Test HTTPS Connection',
            'action_desc' => 'Save your settings before testing.',
            'modal_title' => 'HTTPs Test Result',
            'modal_close' => 'Close Modal',
            'test1_title' => 'Check cURL Server availability',
            'test1_desc' => 'Verify Requirements for HTTPS Testing',
            'test1_success' => 'cURL is installed and available',
            'test1_error' => 'Requirements for testing does not match, canceled...',
            'test2_title' => 'Check HTTPS availability',
            'test2_desc' => 'Verify that your server handles HTTPs requests',
            'test2_success' => 'The HTTPs request was executed successfully.',
            'test2_error' => 'The HTTPs request could not be established.',
            'test3_title' => 'Check HTTPS redirection',
            'test3_desc' => 'Verify main HTTP -> HTTPS redirection',
            'test3_success' => 'The HTTP request was successfully forwarded to HTTPS.',
            'test3_error' => 'The HTTP request could not be forwarded to HTTPS according your settings.',
            'test3_canceled' => 'The Force-HTTPs modus is disabled according your settings.',
            'test4_title' => 'Check WWW redirection',
            'test4_desc' => 'Verify main (Non-)WWW redirection',
            'test4_success' => 'The HTTP request was successfully forwarded.',
            'test4_error' => 'The HTTP request could not be forwarded according your settings.',
            'test4_canceled' => 'The Force-(Non-)WWW modus is disabled according your settings.'
        ]
    ]
];
