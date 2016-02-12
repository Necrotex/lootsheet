<?php

echo BootForm::open(['route' => ['sheets.add_escalator', $site->id]]);
echo BootForm::hidden('_action', 'add_escalator');
echo BootForm::text('name', 'Name');

echo BootForm::select('ship', 'Ship',
    [
        'Archon'     => 'Archon',
        'Thanatos'   => 'Thanatos',
        'Nidhoggur'  => 'Nidhoggur',
        'Chimera'    => 'Chimera',
        'Revalation' => 'Revalation',
        'Naglfar'    => 'Naglfar',
        'Moros'      => 'Moros',
        'Phoenix'    => 'Phoenix'
    ]
);
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
