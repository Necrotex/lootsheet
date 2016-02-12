<?php
echo BootForm::open(['route' => ['sheets.add_bookmarker', $site->id]]);
echo BootForm::hidden('_action', 'add_bookmarker');
echo BootForm::text('name', 'Name');
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
