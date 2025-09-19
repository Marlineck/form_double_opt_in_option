<?php

namespace LinaWolf\FormDoubleOptIn\EventListener;

use LinaWolf\FormDoubleOptIn\Event\RedirectToConfirmationFormEvent;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

class RedirectToConfirmationFormEventListener
{
    public function __invoke(RedirectToConfirmationFormEvent $event): void
    {
        $optIn = $event->getOptIn();
        $validationPid = $event->getValidationPid();

        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $uriBuilder
            ->reset()
            ->setTargetPageUid($validationPid)
            ->uriFor(
                'confirmEmail',
                ['hash' => $optIn->getValidationHash(), 'validationPid' => $validationPid],
                'DoubleOptIn',
                'formdoubleoptin',
                'doubleoptin',
            );

        $response = new RedirectResponse($uri, 302);
        $response->send();
        exit;
    }
}
