<?php
echo BootForm::open(['route' => ['sheets.mark_as_paid', $site->id]]);
echo BootForm::hidden('_action', 'mark_as_paid');
echo BootForm::text('payout', 'Corp Cut', number_format($site->sheet->corp_cut, 2, '.', ''), ['readonly']);
echo Button::submit()->withValue('Mark as Paid')->block();
echo BootForm::close();
