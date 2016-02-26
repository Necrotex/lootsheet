<?php
echo BootForm::open(['route' => 'options.add_corp']);
echo BootForm::text('name', 'Name');
echo BootForm::text('value', 'ID');
echo Button::submit()->withValue('Add')->block();
echo BootForm::close();
