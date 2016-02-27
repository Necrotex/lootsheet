<?php if (count($errors->all()) > 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errors->first(); ?></div>
<?php endif;

if (Session::has('ignored')):
    foreach(Session::get('ignored') as $ignore): ?>
    <div class="alert alert-warning" role="alert"><?php echo $ignore; ?></div>
<?php
    endforeach;
endif;

if ($site->sheet->is_paid):?>
    <div class="alert alert-success" role="alert" style="">This sheet is complete. Nothing do to here. Move along.</div>
<?php endif;

if (!$site->active && !$site->finsihed && !$site->sheet->is_paid):?>
    <div class="alert alert-warning" role="alert" style="">This sheet is no longer active.</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-9">
        <div class="jumbotron">
            <span class=""><strong><?= $site->sig_id; ?> (<?= $site->sig_name ?>)</strong></span>
            <br/>

            <span class="pull-left">Created by: <?= $site->user->name; ?></span>
            <span class="pull-right"> Total: <?= number_format($site->sheet->total_isk, 2, '.', ' ') ?> ISK</span>
            <br/>

            <span class="pull-left">Created at: <?= $site->sheet->created_at; ?></span>
            <span
                class="pull-right"> Corp Cut: <?= number_format($site->sheet->corp_cut, 2, '.', ' '); ?>
                ISK</span>
            <br/>
            <span class="pull-left">Last Updated: <?= $site->sheet->updated_at; ?></span>
            <span class="pull-right"> Payout: <strong><?= number_format($site->sheet->payout, 2, '.', ' '); ?>
                    ISK</strong></span>
            <br/>
            <span class="pull-left"></span>
            <span class="pull-right"> Points: <?= $site->sheet->pilots->sum('points');; ?></span>
            <br/>
            <span class="pull-right"> Pilots: <?= count($site->sheet->pilots); ?></span><br/>
        </div>

        <div class="jumbotron">
            <h3>Pilots</h3>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Ship</th>
                    <th class="text-right">Modifier</th>
                    <th class="text-right">Points</th>
                    <th class="text-right">Cut %</th>
                    <th class="text-right">Cut ISK</th>
                    <?php if ($site->finished): ?>
                        <th class="text-right">Paid</th>
                    <?php else: ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($site->sheet->pilots->all() as $pilot):
                    $points = (1 + $site->sheet->modifier) * $pilot->points;
                    $cut = $points / $site->sheet->points;
                    $pilot_cut = $site->sheet->payout * $cut;
                    ?>
                    <tr>
                        <td><?= $pilot->name ?></td>
                        <td><?= $pilot->role; ?></td>
                        <td><?= $pilot->ship; ?></td>
                        <td class="text-right"><?= $site->sheet->modifier; ?></td>
                        <td class="text-right"><?= $points; ?></td>
                        <td class="text-right"><?= number_format($cut, 2); ?></td>
                        <td class="text-right"><?= number_format($pilot_cut, 2, '.', ' '); ?> </td>
                        <td>
                            <?php if ($site->finished): ?>
                                <?php if ($pilot->paid): ?>
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <?php else:
                                    echo Modal::named('pay_member' . $pilot->id)
                                        ->withTitle('Pay Pilot ' . $pilot->name)
                                        ->withButton(Button::success('Pay')->setSize('btn-xs'))
                                        ->withBody(view('modals.pay_pilot')
                                            ->with('pilot', $pilot)
                                            ->with('id', $site->id)
                                            ->with('payout', $pilot_cut)
                                            ->render());
                                    ?>
                                <?php endif; ?>
                            <?php elseif (!$site->finished && $site->active): ?>
                                <?php echo Modal::named('remove_pilot_' . $pilot->id)
                                    ->withTitle('Remove Pilot ' . $pilot->name)
                                    ->withButton(Button::danger('remove')->setSize('btn-xs'))
                                    ->withBody(view('modals.remove_pilot')
                                        ->with('pilot', $pilot)
                                        ->with('id', $site->id)
                                        ->render());
                            endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (count($site->sheet->comments) > 0): ?>
        <?php foreach ($site->sheet->comments->reverse() as $comment): ?>
        <?php if ($comment->type == 'sheet_info'): ?>
        <div class="alert alert-info" role="alert">
            <?php elseif ($comment->type == 'sheet_log'): ?>
            <div class="alert alert-success" role="alert">
                <?php elseif ($comment->type == 'sheet_important'): ?>
                <div class="alert alert-danger" role="alert">
                    <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        <?php endif; ?>
                        <p><?= $comment->comment; ?></p>
                        <span class="text-muted"><?= $comment->created_at . ' by ' . $comment->user->name ?></span>
                    </div>
                    <?php endforeach;
                    endif; ?>
                </div>

                <div class="col-md-3">
                    <?php if (!$site->finished && $site->active): ?>
                        <div class="jumbotron">
                            <?php if ($site->sheet->pilots->where('role', 'Bookmarker')->count() == 0):
                                echo Modal::named('add_bookmarker')
                                    ->withTitle('Add Bookmarker')
                                    ->withButton(Button::withValue('Add Bookmarker')->block())
                                    ->withBody(view('modals.add_bookmarker')->with('id', $site->id)->render());
                            endif;
                            ?>

                            <?php if ($site->sheet->pilots->where('role', 'Escalator')->count() < 4):
                                echo Modal::named('add_escalator')
                                    ->withTitle('Add Escalator')
                                    ->withButton(Button::withValue('Add Escalator')->block())
                                    ->withBody(view('modals.add_escalator')->with('id', $site->id)->render());
                            endif;
                            ?>

                            <?php if ($site->sheet->pilots->where('role', 'Defanger')->count() == 0):
                                echo Modal::named('add_defanger')
                                    ->withTitle('Add Defanger')
                                    ->withButton(Button::withValue('Add Defanger')->block())
                                    ->withBody(view('modals.add_defanger')->with('id', $site->id)->render());
                            endif;
                            ?>

                            <?php if ($site->sheet->pilots->where('role', 'Escalator')->count() == 4 && $site->sheet->pilots->where('role', 'Defanger')->count() == 1):
                                echo Modal::named('add_pilots')
                                    ->withTitle('Add Pilots')
                                    ->withButton(Button::withValue('Add Pilots')->block())
                                    ->withBody(view('modals.add_pilots')->with('id', $site->id)->render());
                            endif;
                            ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!$site->sheet->is_paid && $site->sheet->pilots()
                            ->whereNotIn('role', ['Bookmarker', 'Escalator', 'Defanger'])->count() > 0): ?>
                        <div class="jumbotron">
                            <?php if (!$site->finished && $site->active): ?>
                                <div>
                                    <?php
                                    echo Modal::named('mark_finished')
                                        ->withTitle('Mark as finished')
                                        ->withButton(Button::success('Mark as finished')->block())
                                        ->withBody(view('modals.mark_as_finished')->with('id', $site->id)->render());
                                    ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($site->finished): ?>
                                <?php if ($site->sheet->pilots->where('paid', '0')->count() == 0): ?>
                                    <div>
                                        <?php
                                        echo Modal::named('mark_paid')
                                            ->withTitle('Pay Corp Cut
                                            ')
                                            ->withButton(Button::success('Pay Corp Cut')->block())
                                            ->withBody(view('modals.mark_as_paid')->with('id', $site->id)->render());
                                        ?>
                                    </div>
                                <?php else: ?>
                                    <h4>Pay all pilots to contiune</h4>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!$site->finished && $site->active): ?>
                        <div class="jumbotron">
                            <?php echo Modal::named('close')
                                ->withTitle('Close Sheet')
                                ->withButton(Button::danger('Close')->block())
                                ->withBody(view('modals.close_sheet')->with('id', $site->id)->render());
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

