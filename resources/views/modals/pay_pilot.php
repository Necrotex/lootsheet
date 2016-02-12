<?php
echo BootForm::open(['route' => ['sheets.pay_pilot', 'pilot_id' => $pilot->id, 'id' => $id]]);
echo BootForm::hidden('_action', 'pay_pilot');
echo BootForm::text('payout', 'Payout', number_format($payout, 2, '.', ''), ['readonly']);
?><small class="text-muted">Copy this number for your payments</small><?php
echo Button::submit()->withValue('OK')->block();
echo BootForm::close();
