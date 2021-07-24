<?php 

return [
    'plugin' => [
        'name' => 'Simple Redirects',
        'description' => 'Verwalte eigene Weiterleitungen und erzwinge HTTPS / (Non-)WWW Anfragen.'
    ],
    
    'menu' => [
        'name' => 'Weiterleitungen',
        'description' => 'Verwalte deine Weiterleitungehn und HTTPS / (Non-)WWW Anfragen.'
    ],

    'config' => [
        'tabs' => [
            'redirects' => 'Benutzerdefinierte Weiterleitungen',
            'force' => 'HTTPs & WWW'
        ],

        'redirects' => [
            'source' => 'Ursprung URL / Pfad',
            'status' => 'Status-Code',
            'destination' => 'Ziel URL / Pfad',
            'get' => 'Deaktiviere bei ?noRedirect GET Parameter',
            'prompt' => 'Neue Weiterleitung hinzufügen' 
        ],

        'force' => [
            'section_https' => 'HTTPs Konfiguration',
            'section_www' => 'WWW Konfiguration',
            'section_test' => 'Einstellungen testen',
            'https_force' => 'Erzwinge HTTPS überall',
            'https_force_desc' => 'Stelle sicher, dass dein Server HTTPS Anfragen akzeptiert.',
            'http_get_mode' => 'noSSL Anfrage-Parameter',
            'http_get_mode_desc' => 'Deaktiviere bei ?noSSL GET Parameter.',
            'www_force' => 'Erzwinge (Non-)WWW überall',
            'www_force_desc' => 'Schalte WWW oder (Non-WWW) Weiterleitungen.',
            'www_mode' => '(Non-)WWW Richtung',
            'www_mode_desc' => 'Aus leitet von Non-WWW auf WWW weiter, An das Gegenteil.',
            'status_code_desc' => 'Google empfiehlt hier 301 (Permanent) zu verwenden.'
        ],

        'https_test' => [
            'action' => 'HTTPS Verbindungstest',
            'action_desc' => 'Speichere deine Einstellung bevor du testest.',
            'modal_title' => 'HTTPs Test Ergebnis',
            'modal_close' => 'Fenster schließen',
            'test1_title' => 'Prüfe cURL Server-Verfügbarkeit',
            'test1_desc' => 'Bestätigte Anforderungen für das HTTPs Testing',
            'test1_success' => 'cURL ist installiert und verfügbar',
            'test1_error' => 'Anforderungen werden erfüllt, Test abgebrochen...',
            'test2_title' => 'Prüfe HTTPS Verfügbarkeit',
            'test2_desc' => 'Bestätige, dass der Server HTTPs Anfragen akzeptiert',
            'test2_success' => 'Die HTTPs Anfrage wurde erfolgreich beantwortet.',
            'test2_error' => 'Die HTTPs Anfrage konnte nicht bestätigt werden.',
            'test3_title' => 'Prüfe HTTPS Weiterleitung',
            'test3_desc' => 'Bestätigte grundlegende HTTP -> HTTPS Weiterleitung',
            'test3_success' => 'Die HTTP Anfrage wurde erfolgreich auf HTTPS weitergeleitet.',
            'test3_error' => 'Die HTTP Anfrage wurde nicht, gemäß Einstellungen, auf HTTPS weitergeleitet.',
            'test3_canceled' => 'Die HTTPs Option ist derzeit deaktiviert.',
            'test4_title' => 'Prüfe WWW Weiterleitung',
            'test4_desc' => 'Bestätigte grundlegende (Non-)WWW Weiterleitung',
            'test4_success' => 'Die HTTP Anfrage wurde erfolgreich weitergeleitet.',
            'test4_error' => 'Die HTTP Anfrage wurde nicht, gemäß Einstellungen, weitergeleitet.',
            'test4_canceled' => 'Die (Non-)WWW Option ist derzeit deaktiviert.'
        ]
    ]
];
