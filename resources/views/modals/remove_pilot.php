<?php
echo BootForm::open(['route' => ['sheets.remove_pilot', 'pilot_id' => $pilot->id, 'id' => $id]]);
echo BootForm::hidden('_action', 'remove_pilot');
echo Button::submit()->withValue('OK')->block();
echo BootForm::close();
