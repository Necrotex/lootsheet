<?php
echo BootForm::open(['route' => ['options.action', 'id' => $corp->id]]);
echo BootForm::text('name', 'Name', $corp->name);
echo BootForm::text('value', 'ID', $corp->value);
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
