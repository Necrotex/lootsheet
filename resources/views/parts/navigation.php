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
                <li>
                    <a href="<?= URL::route('sig.new') ?>">Add new Site</a>
                </li>
                <li>
                    <a href="<?= URL::route('sheets.all') ?>">Sheets</a>
                </li>
                <li>
                    <a href="<?= URL::route('options.all') ?>">Options</a>
                </li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</div>
