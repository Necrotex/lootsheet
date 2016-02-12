<?php if (count($errors->all()) > 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errors->first(); ?></div>
<?php endif;

if ($site->sheet->is_paid):?>
    <div class="alert alert-success" role="alert" style="">This sheet is complete. Nothing do to here. Move along.</div>
    <?php
endif;
$payout = $site->sheet->total_isk - ($site->sheet->total_isk * $options->where('key', 'corp_cut')->first()->value);
?>

<div class="row">
    <div class="col-md-9">
        <div class="jumbotron">
            <span class=""><strong><?= $site->sig_id; ?> (<?= $site->sig_name ?>)</strong></span>
            <br/>

            <span class="pull-left">Created by: <?= $site->creator; ?></span>
            <span class="pull-right"> Total: <?= number_format($site->sheet->total_isk, 2, '.', ' ') ?> ISK</span>
            <br/>

            <span class="pull-left">Created at: <?= $site->sheet->created_at; ?></span>
            <span
                class="pull-right"> Corp Cut: <?= number_format($site->sheet->total_isk * $options->where('key', 'corp_cut')->first()->value, 2, '.', ' '); ?>
                ISK</span>
            <br/>
            <span class="pull-left">Last Updated: <?= $site->sheet->updated_at; ?></span>
            <span class="pull-right"> Payout: <strong><?= number_format($payout, 2, '.', ' '); ?> ISK</strong></span>
            <br/>
            <span class="pull-left"></span>
            <?php $points = 0;
            foreach ($site->sheet->pilots as $pilot) {
                $points += $pilot->points;
            }
            ?>
            <span class="pull-right"> Points: <?= $points; ?></span>
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
                    <th>Modifier</th>
                    <th>Points</th>
                    <th>Cut %</th>
                    <th>Cut ISK</th>
                    <?php if ($site->finished): ?>
                        <th>Paid</th>
                    <?php else: ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($site->sheet->pilots->all() as $pilot):
                    $points = (1 + $site->sheet->modifier) * $pilot->points;
                    $cut = $points / $site->sheet->points;
                    $pilot_cut = $payout * $cut;
                    ?>
                    <tr>
                        <td><?= $pilot->name ?></td>
                        <td><?= $pilot->role; ?></td>
                        <td><?= $pilot->ship; ?></td>
                        <td><?= $site->sheet->modifier; ?></td>
                        <td class="text-right"><?= $points; ?></td>
                        <td class="text-right"><?= number_format($cut, 2); ?></td>
                        <td class="text-right"><?= number_format($pilot_cut, 2, '.', ' '); ?> </td>

                        <?php if ($site->finished): ?>
                            <td>
                                <?php if ($pilot->paid): ?>
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                                <?php else:
                                    echo Modal::named('pay_member' . $pilot->id)
                                        ->withTitle('Pay Pilot')//todo: Use pilot name
                                        ->withButton(Button::success('Pay')->setSize('btn-xs'))
                                        ->withBody(view('modals.pay_pilot')
                                            ->with('pilot', $pilot)
                                            ->with('id', $site->id)
                                            ->with('payout', $pilot_cut)
                                            ->render());
                                    ?>
                                <?php endif; ?>
                            </td>
                        <?php else: ?>
                            <td>
                                <?php echo Modal::named('remove_pilot_' . $pilot->id)
                                    ->withTitle('Remove Pilot')//todo: Use pilot name
                                    ->withButton(Button::danger('remove')->setSize('btn-xs'))
                                    ->withBody(view('modals.remove_pilot')
                                        ->with('pilot', $pilot)
                                        ->with('id', $site->id)
                                        ->render());
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (count($site->sheet->comments) > 0): ?>
            <?php
            $comments = $site->sheet->comments->where('type', 'site_finnished_comment');
            foreach ($comments as $comment): ?>
                <div class="jumbotron">
                    <h4>Comment:</h4>

                    <p><?= $comment->comment; ?></p>
                    <span class="text-muted"><?= $comment->created_at ?> by <?= $comment->user_id ?></span>
                </div>
            <?php endforeach;

            $comments = $site->sheet->comments->where('type', 'sheet_log');
            foreach ($comments as $comment): ?>
                <div class="alert alert-warning" role="alert">
                    <p><?= $comment->comment; ?></p>
                    <span class="text-muted"><?= $comment->created_at ?> by <?= $comment->user_id ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="col-md-3">
        <?php if (!$site->finished): ?>
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

                <?php
                echo Modal::named('add_pilots')
                    ->withTitle('Add Pilots')
                    ->withButton(Button::withValue('Add Pilots')->block())
                    ->withBody(view('modals.add_pilots')->with('id', $site->id)->render());
                ?>
            </div>
        <?php endif; ?>

        <?php if (!$site->sheet->is_paid && $site->sheet->pilots->count() > 0): ?>
            <div class="jumbotron">
                <?php if (!$site->finished): ?>
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
                    <?php if ($site->sheet->pilots->where('paid', 0)->count() == 0): ?>
                        <div>
                            <?php
                            echo Modal::named('mark_paid')
                                ->withTitle('Mark as paid')
                                ->withButton(Button::success('Mark as paid')->block())
                                ->withBody(view('modals.mark_as_paid')->with('id', $site->id)->render());
                            ?>
                        </div>
                    <?php else: ?>
                        <h4>Pay all pilots to contiune</h4>
                    <?php endif; ?>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </div>
</div>

