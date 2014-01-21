<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    .form-password {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-password .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-password .form-control:focus {
        z-index: 2;
    }
    .form-password input[name="passold"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-password input[name="password"] {
        margin-bottom: -1px;
        border-radius: 0;
    }
    .form-password input[name="passconf"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    ul.pass-tip{
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
               <h3 class="panel-title">密码维护</h3>
            </div>
            <div class="panel-body">
                <form class="form-password" action="" method="post">
                    <?php if($reset_password === 'ok'){ ?>
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <p>密码已经更新</p>
                        </div>
                    <?php } ?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                    <input type="password" class="form-control" name="passold" placeholder="原密码" autofocus>
                    <input type="password" class="form-control" name="password" placeholder="新密码">
                    <input type="password" class="form-control" name="passconf" placeholder="重复新密码">
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
                <ul class="pass-tip">
                    <li>修改密码后，请牢记新密码</li>
                    <li>在下次登录的时候请使用新密码</li>
                    <li>如果忘记密码无法登录，可以选择重置密码</li>
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
        $(".form-password").validate({
            rules: {
                "passold": {
                    required: true,
                    minlength: 6,
                    maxlength: 18
                },
                "password": {
                    required: true,
                    minlength: 6,
                    maxlength: 18
                },
                "passconf": {
                    required: true,
                    equalTo: "input[name='password']"
                }
            },
            messages: {
                "passold": {
                    required: "请输入原密码",
                    minlength: "原密码至少需要{0}个字",
                    maxlength: "原密码不超过{0}个字"
                },
                "password": {
                    required: "请输入新密码",
                    minlength: "新密码至少需要{0}个字",
                    maxlength: "新密码不超过{0}个字"
                },
                "passconf": {
                    required: "请重复输入新密码",
                    equalTo: "两次新密码录入不一致"
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