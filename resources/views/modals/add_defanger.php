<?php
echo BootForm::open(['route' => ['sheets.add_defanger', $site->id]]);
echo BootForm::hidden('_action', 'add_defanger');
echo BootForm::text('name', 'Name');
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
