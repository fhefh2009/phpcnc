<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    body {
        background-color: #f8f8f8;
    }
    .form-reset {
        max-width: 330px;
        padding: 15px;
        margin: 20% auto;
    }
    .form-reset .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .form-reset .form-control:focus {
        z-index: 2;
    }
    .form-reset input[name="password"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .form-reset input[name="passconf"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .alert-danger {
        display: none;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <form class="form-reset" action="" method="post">
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
        <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
        <input type="password" class="form-control" name="password" placeholder="新密码">
        <input type="password" class="form-control" name="passconf" placeholder="重复新密码">
        <button class="btn btn-lg btn-default btn-block" type="submit">重置密码</button>
    </form>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function(){
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-reset").validate({
            rules: {
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