<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    body {
        background-color: #f8f8f8;
    }
    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 20% auto;
    }
    .form-signin .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    button.login {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    a.forgotten {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .alert-danger {
        display: none;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <form class="form-signin" action="" method="post">
        <?php if($reset_password === 'ok'){ ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>密码已重置，请登录</p>
            </div>
        <?php } ?>
        <div class="alert alert-danger">
            <?php if($login === 'fail'){ ?>
                <p>身份识别失败</p>
            <?php } ?>
            <?php echo validation_errors(); ?>
        </div>
        <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
        <input type="text" class="form-control" name="email" placeholder="邮箱" value="<?php echo set_value('email'); ?>"
               autofocus>
        <input type="password" class="form-control" name="password" placeholder="密码">
        <button class="btn btn-lg btn-default btn-block login" type="submit">冒泡</button>
        <a href="forgotten/password" class="btn btn-default btn-lg btn-block pull-right forgotten"
           style="margin: 0" role="button">忘记密码</a>
    </form>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function(){
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-signin").validate({
            rules: {
                "email": {
                    required: true,
                    maxlength: 50,
                    email: true
                },
                "password": {
                    required: true,
                    minlength: 6,
                    maxlength: 18
                }
            },
            messages: {
                "email": {
                    required: "请输入邮箱",
                    maxlength: "邮箱不超过{0}个字",
                    email: "邮箱无效"
                },
                "password": {
                    required: "请输入密码",
                    minlength: "密码至少需要{0}个字",
                    maxlength: "密码不超过{0}个字"
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