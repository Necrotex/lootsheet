<div class="row">
	<div class="col-md-12">
		<div class="jumbotron">
			<h1>Manage Users</h1>

			<?php echo BootForm::text('search_user', 'Search User'); ?>
			<ul class="list-group" id="found_users">
			</ul>
		</div>
	</div>
</div>

<div class="panel panel-default">
	<!-- Default panel contents -->
	<div class="panel-heading">Admins</div>
	<table class="table table-striped">
		<thead>
			<tr>
				<th></th>
				<th>Name</th>
				<td>Last Login</td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($users->where('admin', '1') as $admin):
				//cant demote yourself
				if(Auth::user()->id == $admin->id) continue;
				?>
				<tr>
					<td>
						<img src="https://image.eveonline.com/Character/<?=$admin->character_id; ?>_64.jpg" />
					</td>
					<td><?=$admin->name; ?></td>
					<td>
                        <span data-toggle="tooltip" data-placement="top" title="<?=$admin->updated_at ?>">
                            <?= Carbon\Carbon::parse($admin->updated_at)->diffForHumans() ?>
                        </span>
					</td>
					<td>
						<?php echo Modal::named('demote_' . $admin->id)
										->withTitle('Demote ' . $admin->name)
						                ->withButton(Button::danger('demote')->setSize('btn-xs'))
						                ->withBody(view('modals.admin_user_info_content')->with('user', $admin)->render());
						?>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>

<?php echo Modal::named('user_info'); ?>