<?php

\OC::$server->getNavigationManager()->add(function () {
    $urlGenerator = \OC::$server->getURLGenerator();
    return [
        'id' => 'bplog',
        'order' => 10,
        'href' => $urlGenerator->linkToRoute('bplog.page.index'),
        'icon' => $urlGenerator->imagePath('bplog', 'bplog.svg'),
        'name' => \OC::$server->getL10N('bplog')->t('Blood Pressure Log'),
    ];
});
