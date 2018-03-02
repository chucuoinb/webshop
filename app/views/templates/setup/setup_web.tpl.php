<form action="" method="post" id="form-setup-web">

    <div class="form-group row border-bottom">
        <div class="col-md-3">Admin Url  <span style="color: red">*</span> </div>
        <div class="col-md-9" id="setup-admin-url">
            <span class=""><?php echo Bootstrap::getUrl().'/';?></span>
            <input type="text" name="admin_url" class="form-control "  required value="<?php echo Bootstrap::getConfig('admin_url')?>"/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">First Name</div>
        <div class="col-md-5">
            <input type="text" name="admin_first_name" class="form-control" value=""/>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-3">Last Name</div>
        <div class="col-md-5">
            <input type="text" name="admin_last_name" class="form-control" value=""/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3" >Create admin account <span style="color: red">*</span></div>
        <div class="col-md-5">
            <input type="text" name="admin_account" class="form-control " required value=""/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3">Create admin password <span style="color: red">*</span></div>
        <div class="col-md-5">
            <input type="password" name="admin_password" class="form-control valid_length" required value=""/>
        </div>
    </div>
    <div class="form-group row border-bottom">
        <div class="col-md-3">Retype password <span style="color: red">*</span></div>
        <div class="col-md-5">
            <input type="text" name="admin_repassword" class="form-control " required value=""/>
        </div>
    </div>

    <input type="hidden" name="<?php echo WEB_URI;?>"  value="setup">
    <input type="hidden" name="action"  value="createAdminAccount">
    <div class="form-install-submit">
        <div class="form-loading " id="form-loading"><img
                src="<?php echo Bootstrap::getUrl('pub/image/help/loader-large.gif'); ?>"/> Connecting ...
        </div>
        <div class="btn btn-install btn-submit" id="form-setup-web-submit">Next</div>
    </div>
</form>