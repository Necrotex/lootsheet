<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">Sites this week</div>
			<div class="panel-body">
				<div id="sites_stats"></div>
				<?= Lava::render('ColumnChart', 'Sites', 'sites_stats') ?>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">ISK this week</div>
			<div class="panel-body">
				<div id="total_isk"></div>
				<?= Lava::render('LineChart', 'totalisk', 'total_isk') ?>
			</div>
			<div class="panel-footer text-center">
					<small class="text-muted pull-right">Total ISK recorded: <?= number_format($sheets->sum('total_isk'), 2, '.', ' '); ?> ISK</small>
					<small class="text-muted">Total payout recorded: <?= number_format($sheets->sum('payout'), 2, '.', ' '); ?> ISK</small>
					<small class="text-muted pull-left">Total corp cut recorded: <?= number_format($sheets->sum('corp_cut'), 2, '.', ' '); ?> ISK</small>
				</small>

			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">Bomber by type</div>
			<div class="panel-body">
				<div id="bomber_type"></div>
				<?= Lava::render('PieChart', 'bomber', 'bomber_type') ?>
			</div>
		</div>
	</div>

	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">All Ships by type</div>
			<div class="panel-body">
				<div id="ship_type"></div>
				<?= Lava::render('PieChart', 'ships', 'ship_type') ?>
			</div>
		</div>
	</div>
</div>