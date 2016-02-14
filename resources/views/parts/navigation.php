<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand brand-logo" href="<?= URL::route('home') ?>">
                <img alt="Brand" src="<?= URL::asset('/img/logo.png') ?>" height="60px">
            </a>
            <a class="navbar-brand" href="<?= URL::route('home') ?>">
                <span class="pull-left">C0RE :: Lootsheet</span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?= URL::route('home') ?>">Home</a>
                </li>

                <?php if(Auth::check()): ?>
                    <li>
                        <a href="<?= URL::route('sig.new') ?>">Add Site</a>
                    </li>
                    <li>
                        <a href="<?= URL::route('sheets.all') ?>">Sheets</a>
                    </li>
                    <li>
                        <a href="<?= URL::route('stats.all') ?>">Stats</a>
                    </li>
                <?php endif; ?>
            </ul>

            <?php if(Auth::check() && Auth::user()->admin): ?>
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?= URL::route('options.all') ?>">Options</a>
                            </li>
                            <li>
                                <a href="<?= URL::route('admin.index') ?>">Users</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>

            <?php if(Auth::check()): ?>
                <p class="navbar-text navbar-right">
                    Signed in as <strong><?= Auth::user()->name; ?></strong>
                    (<a href="<?=URL::route('auth.logout'); ?>" class="navbar-link">Logout</a>)
                </p>
            <?php endif; ?>

        </div>
    </div>
</div>
