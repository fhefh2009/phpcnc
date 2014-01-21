<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    body {
        background-color: #f8f8f8;
    }

    .form-active {
        max-width: 330px;
        padding: 15px;
        margin: 20% auto;
    }

    .form-active .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .form-active .form-control:focus {
        z-index: 2;
    }

    .form-active input[name="username"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-active input[name="password"] {
        margin-bottom: -1px;
        border-radius: 0;
    }

    .form-active input[name="passconf"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .alert-danger {
        display: none;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <form class="form-active" action="active" method="post">
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>注意：</strong> 激活后<b>用户名</b>将不可修改
        </div>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
        <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
        <input type="text" class="form-control" name="username" value="<?php echo set_value('username'); ?>" placeholder="用户名"
               autofocus>
        <input type="password" class="form-control" name="password" placeholder="密码">
        <input type="password" class="form-control" name="passconf" placeholder="重复密码">
        <button class="btn btn-lg btn-default btn-block" type="submit">激活</button>
    </form>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function(){
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-active").validate({
            rules: {
                "username": {
                    required: true,
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
                "username": {
                    required: "请输入用户名",
                    maxlength: "用户名不超过{0}个字"
                },
                "password": {
                    required: "请输入密码",
                    minlength: "密码至少需要{0}个字",
                    maxlength: "密码不超过{0}个字"
                },
                "passconf": {
                    required: "请重复输入密码",
                    equalTo: "两次密码录入不一致"
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