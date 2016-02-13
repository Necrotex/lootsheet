<div class="row">
    <div class="col-md-12">
        <div class="jumbotron">
            <h1>Wellcome to the C0RE Lootsheet</h1>

            <p>Here's a text with some explainations how to use this app.</p>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Active Sites</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Sig ID</th>
                <th>Type</th>
                <th>Group</th>
                <th>Name</th>
                <th>Last updated</th>
                <th>Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sites as $site): ?>
                <tr>
                    <th><a href="<?= route('sheets.single', [$site->id]); ?>"><?= $site->sig_id; ?></a></th>
                    <td><?= $site->sig_type ?></td>
                    <td><?= $site->sig_group ?></td>
                    <td><?= $site->sig_name ?></td>
                    <td>
                        <span data-toggle="tooltip" data-placement="top" title="<?=$site->updated_at ?>">
                            <?= Carbon\Carbon::parse($site->updated_at)->diffForHumans() ?>
                        </span>
                    </td>
                    <td>
                        <span data-toggle="tooltip" data-placement="top" title="<?=$site->created_at ?>">
                            <?= Carbon\Carbon::parse($site->created_at)->diffForHumans() ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($site->sheet->pilots->where('role', 'Bookmarker')->count() == 1): ?>
                            <span class="label label-info" data-toggle="tooltip" data-placement="top" title="Bookmarked">BM</span>
                        <?php endif; ?>

                        <?php if ($site->sheet->pilots->where('role', 'Defanger')->count() == 1): ?>
                            <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="Defanged">DF</span>
                        <?php endif; ?>

                        <?php if ($site->sheet->pilots->where('role', 'Escalator')->count() == 4): ?>
                            <span class="label label-warning" data-toggle="tooltip" data-placement="top" title="Escalated">ES</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>