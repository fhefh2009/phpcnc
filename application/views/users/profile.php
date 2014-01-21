<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    .form-profile {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-profile .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-profile .form-control:focus {
        z-index: 2;
    }
    .form-profile input[name="city"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-profile input[name="company"]  {
        margin-bottom: -1px;
        border-radius: 0;
    }
    .form-profile input[name="blog"] {
        margin-bottom: -1px;
        border-radius: 0;
    }
    .form-profile textarea {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        resize: vertical;
    }
    small.extra-info {
        color: darkgray;
    }
    ul.profile-tip{
        margin: 0;
        padding-left: 15px;
    }
    .alert-danger {
        display: none;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <small class="pull-right extra-info"><?php echo $current_user['email']; ?> &nbsp;•&nbsp; <?php echo $current_user['created_on']; ?>加入 &nbsp;•&nbsp; <?php echo $current_user['id']; ?>号成员</small>
                    <h3 class="panel-title">资料维护</h3>
                </div>
                <div class="panel-body">
                    <form class="form-profile" action="" method="post">
                        <?php if($update_profile === 'ok'){ ?>
                            <div class="alert alert-success alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <p>资料已经更新</p>
                            </div>
                        <?php } ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                        <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                        <input type="text" class="form-control" name="city" placeholder="城市" value="<?php echo set_value('city', $current_user['city']); ?>">
                        <input type="text" class="form-control" name="company" placeholder="公司" value="<?php echo set_value('company', $current_user['company']); ?>">
                        <input type="url" class="form-control" name="blog" placeholder="主页" value="<?php echo set_value('blog', $current_user['blog'] ? $current_user['blog'] : 'http://'); ?>">
                        <textarea name="intro" class="form-control" placeholder="简介" rows="6"><?php echo set_value('intro', $current_user['intro']); ?></textarea>
                        <button class="btn btn-default" type="submit">更新</button>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Tip</h3>
                </div>
                <div class="panel-body">
                    <ul class="profile-tip">
                        <li>完善资料，让大家更了解自己</li>
                        <li>想要换个脸？<a href="settings/avatar">到此处</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function(){
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-profile").validate({
            rules: {
                "city": {
                    maxlength: 20
                },
                "company": {
                    maxlength: 20
                },
                "blog": {
                    maxlength: 100,
                    url: true
                },
                "intro": {
                    maxlength: 400
                }
            },
            messages: {
                "city": {
                    maxlength: "城市不超过{0}个字"
                },
                "company": {
                    maxlength: "公司不超过{0}个字"
                },
                "blog": {
                    maxlength: "主页不超过{0}个字",
                    url: "主页需为合法网址，如：http://phpcnc.org"
                },
                "intro": {
                    maxlength: "简介不超过{0}个字"
                }
            },
            invalidHandler:function(){
                $(".alert-danger p").remove();
            },
            onkeyup: false,
            onfocusout: false,
            errorLabelContainer: ".alert-danger",
            errorElement: "p"
        });
    });
</script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>