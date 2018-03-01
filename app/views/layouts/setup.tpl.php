<?php
$notice = $this->getNotice();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Setup</title>
    <?php $cssFile = $this->getGlobal('cssFile'); ?>
    <?php foreach ($cssFile as $css_file): ?>
        <link type="text/css" rel="stylesheet" media="screen" href="<?php echo Bootstrap::getUrl($css_file); ?>"/>
    <?php endforeach; ?>

    <?php $jsFile = $this->getGlobal('jsFile'); ?>
    <?php foreach ($jsFile as $js_file): ?>
        <script type="text/javascript" src="<?php echo Bootstrap::getUrl($js_file); ?>"></script>
    <?php endforeach; ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $.Webshop({
                url: '<?php echo Bootstrap::getUrl().'/'?>',
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="install-logo">WEBSHOP INSTALL</div>
    <div class="row webshop-install">
        <div class="col-md-3">
            <div class="install-progress">
                <div class="install-progress-title border-bottom"> <b>Installation</b> </div>
                <div class="install-progress-step">
                    <div class="install-progress-step-title border-bottom install-active" id="install-title-config">Config database</div>
                    <div class="install-progress-step-title border-bottom" id="install-title-install">Install database</div>
                    <div class="install-progress-step-title border-bottom" id="install-title-admin">Create admin account</div>
                    <div class="install-progress-step-title" id="install-title-finish">Finish</div>
                </div>
            </div>

        </div>
        <div class="col-md-9 install-content">
            <div class="page-header clearfix border-bottom">
                <h1 class="pull-left" id="js-install-content-title">Database Configuration</h1>
            </div>
            <div class="padding-10">
                <div id="js-setup-config-database"><?php //include Bootstrap::getTemplate('setup/config.tpl')?></div>
                <div id="js-setup-install-database"><?php //include Bootstrap::getTemplate('setup/install.tpl')?></div>
                <div id="js-setup-install-web"><?php include Bootstrap::getTemplate('setup/setup_web.tpl')?></div>

            </div>
        </div>
    </div>
</div>
</body>
</html>