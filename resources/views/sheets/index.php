<table class="table table-striped">
    <thead>
        <tr>
            <th>Sig ID</th>
            <th>Type</th>
            <th>Group</th>
            <th>Name</th>
            <th>Last updated</th>
            <th>Created</th>
            <th>Finished</th>
            <th>Active</th>
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
                    <span class="glyphicon <?= !$site->finished ? 'glyphicon-remove' : 'glyphicon-ok' ?>"
                          aria-hidden="true">

                    </span>
                </td>
                <td>
                    <span class="glyphicon <?= !$site->active ? 'glyphicon-remove' : 'glyphicon-ok' ?>"
                        aria-hidden="true">

                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
