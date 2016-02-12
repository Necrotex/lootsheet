<?php
echo BootForm::open(['route' => ['sheets.mark_as_finished', $site->id]]);
echo BootForm::hidden('_action', 'mark_as_finished');
echo BootForm::number('payout', 'Site Payout');
echo BootForm::textarea('comment');
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
