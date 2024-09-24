<?php

return [

    'send_mail_url' => env('ECOMAIL_SEND_MAIL_URL', 'https://api2.ecomailapp.cz/transactional/send-message'),

    'api_key' => env('ECOMAIL_API_KEY'),

    'log_file' => env('ECOMAIL_LOG_FILE', 'logs/laravel-mail-ecomail.log'),

];
