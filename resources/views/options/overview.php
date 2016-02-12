<?php if (count($errors->all()) > 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errors->first(); ?></div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Name</th>
        <th>Value</th>
        <th></th>
    </tr>
    </thead>
    <tbody>

    <?php foreach($options as $option): ?>
        <tr>
            <td><?=$option->name; ?></td>
            <td><?=$option->value; ?></td>
            <td><?php
                echo Modal::named('edit_option_' . $option->id)
                    ->withTitle('Edit Option')
                    ->withButton(Button::success('edit')->setSize('btn-xs'))
                    ->withBody(view('modals.edit_option')->with('option', $option)->render());
                ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
