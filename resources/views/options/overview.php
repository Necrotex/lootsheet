<?php if (count($errors->all()) > 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errors->first(); ?></div>
<?php endif; ?>

<div class="page-header">
    <h1>Access</h1>
</div>
<div class="pull-right">
    <?php echo Modal::named('add_corp')
        ->withTitle('Add Corp')
        ->withButton(Button::success('Add Corp'))
        ->withBody(view('modals.add_corp')->render());
    ?>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Corp</th>
        <th>ID</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($allowed_corps as $corp): ?>
        <tr>
            <td><?= $corp->name; ?></td>
            <td><?= $corp->value; ?></td>
            <td class=""><?php
                echo Modal::named('edit_option_'.$corp->id)
                    ->withTitle('Edit Corp')
                    ->withButton(Button::success('edit')->setSize('btn-xs'))
                    ->withBody(view('modals.edit_corp')->with('corp', $corp)->render());
                ?>
                <?php
                echo Modal::named('remove_corp_'.$corp->id)
                    ->withTitle('Remvoe Corp')
                    ->withButton(Button::danger('remove')->setSize('btn-xs'))
                    ->withBody(view('modals.remove_corp')->with('corp', $corp)->render());
                ?>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div class="page-header">
    <h1>Sheet Options</h1>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Value</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($options as $option): ?>
        <tr>
            <td><?= $option->name; ?></td>
            <td><?= $option->value; ?></td>
            <td><?php
                echo Modal::named('edit_option_'.$option->id)
                    ->withTitle('Edit Option')
                    ->withButton(Button::success('edit')->setSize('btn-xs'))
                    ->withBody(view('modals.edit_option')->with('option', $option)->render());
                ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
