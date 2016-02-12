<?php
echo BootForm::open(['route' => ['sheets.mark_as_paid', $site->id]]);
echo BootForm::hidden('_action', 'mark_as_paid');
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
