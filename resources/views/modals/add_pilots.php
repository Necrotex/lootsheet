<?php
echo BootForm::open(['route' => ['sheets.add_pilots', $site->id]]);
echo BootForm::hidden('_action', 'add_pilots');
echo BootForm::textarea('pilots');
?> <small class="text-muted">Copy and Paste your fleet composition here</small> <?php
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();
