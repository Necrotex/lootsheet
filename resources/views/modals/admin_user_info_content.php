	<div class="modal-body">
		<div class="row">
			<div class="col-md-4">
				<img src="https://image.eveonline.com/Character/<?= $user->character_id; ?>_128.jpg" />

			</div>
			<div class="col-md-4">
				<h4><?php echo $user->name; ?></h4>
				<p>Last login:
				<span data-toggle="tooltip" data-placement="top" title="<?=$user->updated_at ?>">
					<?= Carbon\Carbon::parse($user->updated_at)->diffForHumans() ?>
				</span></p>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			<?php
				if(!$user->admin):
					echo BootForm::open(['route' => ['admin.promote_user', 'id' => $user->id]]);
					echo BootForm::hidden('_action', 'promote_user');
					echo Button::submit()->success()->withValue('Promote');
					echo BootForm::close();
				else:
					echo BootForm::open(['route' => ['admin.demote_user', 'id' => $user->id]]);
					echo BootForm::hidden('_action', 'demote_user');
					echo Button::submit()->danger()->withValue('Demote');
					echo BootForm::close();
				endif;
			?>
		</div>
	</div><!-- /.modal-content -->
