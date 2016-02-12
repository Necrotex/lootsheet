<div class="row">
    <div class="col-md-12">
        <div class="jumbotron">
            <h1>Add a new Signature</h1>

            <p>Some more text here.</p>

            <?php echo BootForm::open(['route' => 'sig.create']) ?>

            <?php echo BootForm::text('sig_paste', 'Signature', null,
                ['placeholder' => 'Copy and paste the signature form your probe scanner window here', 'rows' => 5]); ?>

            <?php echo BootForm::submit('Save', ['class' => 'btn-block btn-primary btn']); ?>

            <?php echo BootForm::close(); ?>

        </div>
    </div>
</div>
