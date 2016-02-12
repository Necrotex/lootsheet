<?php
echo BootForm::open(['route' => ['options.action', 'id' => $option->id]]);
echo BootForm::text('name', 'Name', $option->name);
echo BootForm::text('value', 'Value', $option->value);
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
