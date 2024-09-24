## Get started

### Requirements

- PHP 8.2+
- [Laravel 11+](https://laravel.com/docs/installation)

<br/>

### Install

```bash
composer require power-components/livewire-powergrid
```

#### Add api key in env

```
ECOMAIL_API_KEY=yourApiKey
```

#### Add driver into mail.php config

```
'laravel-mail-ecomail' => [
    'transport' => 'laravel-mail-ecomail',
],
```

#### Change mailer

```
MAIL_MAILER=laravel-mail-ecomail
```

#### Publish config

```bash
php artisan vendor:publish --tag=laravel-mail-ecomail-config
```
