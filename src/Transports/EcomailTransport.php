<?php

declare(strict_types=1);

namespace InvolveDigital\LaravelMailEcomail\Transports;

use Illuminate\Support\Arr;
use InvolveDigital\LaravelMailEcomail\Api\EcomailApiService;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

final class EcomailTransport extends AbstractTransport
{

    public function __construct()
    {
        parent::__construct();
    }

    public function __toString(): string
    {
        return 'laravel-mail-ecomail';
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());

        if (!$emailFrom = Arr::first($email->getFrom())) {
            return;
        }

        if (!$emailTo = Arr::first($email->getTo())) {
            return;
        }

        EcomailApiService::sendEmail(
            $email->getSubject(),
            $emailFrom->getName(),
            $emailFrom->getAddress(),
            $email->getHtmlBody(),
            $emailTo->toString(),
            Arr::first($email->getCc())?->toString(),
            Arr::first($email->getBcc())?->toString(),
        );
    }

}
