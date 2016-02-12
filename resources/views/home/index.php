<div class="row">
    <div class="col-md-12">
        <div class="jumbotron">
            <h1>Wellcome to the C0RE Lootsheet</h1>

            <p>Here's a text with some explainations how to use this app.</p>
        </div>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Sig ID</th>
            <th>Type</th>
            <th>Group</th>
            <th>Name</th>
            <th>Last updated</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sites as $site): ?>
            <tr>
                <th><a href="<?= route('sheets.single', [$site->id]); ?>"><?= $site->sig_id; ?></a></th>
                <td><?= $site->sig_type ?></td>
                <td><?= $site->sig_group ?></td>
                <td><?= $site->sig_name ?></td>
                <td><?= $site->updated_at ?></td>
                <td><?= $site->created_at ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
