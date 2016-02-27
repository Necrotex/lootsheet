<div class="row">
	<div class="col-md-12">
		<div class="jumbotron">
			<h1>Welcome to the C0RE Lootsheet</h1>
			<a href="<?=URL::route('auth.login');?>"><img style="margin-top:50px;" class="center-block" src="<?=URL::asset('/img/login_sso.png'); ?>"></a>

			<?php if (count($errors->all()) > 0): ?>
				<div class="alert alert-danger" role="alert" style="margin-top:50px"><?php echo $errors->first(); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>