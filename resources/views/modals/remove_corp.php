<?php
echo BootForm::open(['route' => ['options.remove_corp', 'id' => $corp->id]]);
echo BootForm::hidden('_action', 'remove_corp');
echo Button::submit()->withValue('OK')->block();
echo BootForm::close();
