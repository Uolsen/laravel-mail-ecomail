## Get started

### Requirements

- PHP 8.2+
- [Laravel 11+](https://laravel.com/docs/installation)

<br/>

### Install

```bash
composer require involve-digital/laravel-mail-ecomail
```

#### Add api key in env

```
ECOMAIL_API_KEY=yourApiKey
```

#### Add driver into mail.php config

```
'ecomail' => [
    'transport' => 'ecomail',
],
```

#### Change mailer

```
MAIL_MAILER=ecomail
```

#### Publish config

```bash
php artisan vendor:publish --tag=laravel-mail-ecomail-config
```
