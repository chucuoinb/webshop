<form action="" method="post" id="form-setup-web">
    <div class="form-group row border-bottom">
        <div class="col-md-3">Admin Url  <span style="color: red">*</span> </div>
        <div class="col-md-9" id="setup-admin-url">
            <span class=""><?php echo Bootstrap::getUrl().'/';?></span>
            <input type="text" name="admin_url" class="form-control "  required value="<?php echo Bootstrap::getConfig('admin_url')?>"/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3" >Create admin account <span style="color: red">*</span></div>
        <div class="col-md-5">
            <input type="text" name="admin_account" class="form-control valid_username" required value=""/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3">Create admin password</div>
        <div class="col-md-5">
            <input type="password" name="admin_password" class="form-control valid_length" value=""/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3">Database name <span style="color: red">*</span></div>
        <div class="col-md-5">
            <input type="text" name="database" class="form-control" required value="<?php echo Bootstrap::getConfig('db_name')?>"/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">Table Prefix</div>
        <div class="col-md-5">
            <input type="text" name="prefix" class="form-control" value="<?php echo Bootstrap::getConfig('db_prefix')?>"/>
        </div>
    </div>
    <input type="hidden" name="<?php echo WEB_URI;?>"  value="setup">
    <input type="hidden" name="action"  value="configDatabase">
    <div class="form-install-submit">
        <div class="form-loading display-none" id="form-loading"><img
                src="<?php echo Bootstrap::getUrl('pub/image/help/loader-large.gif'); ?>"/> Connecting ...
        </div>
        <div class="btn btn-install btn-submit" id="form-setup-web-submit">Next</div>
    </div>
</form>