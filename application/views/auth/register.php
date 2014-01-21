<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    body {
        background-color: #f8f8f8;
    }

    .form-join {
        max-width: 330px;
        padding: 15px;
        margin: 20% auto;
    }

    .form-join .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .form-join .form-control:focus {
        z-index: 2;
    }

    .form-join input[name="email"] {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    .form-join input[name="captcha"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }

    button.captcha {
        margin-bottom: -1px;
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }

    button.join {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    .alert-danger {
        display: none;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <form class="form-join" action="" method="post">
        <?php if($registered === 'ok'){ ?>
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>邀请信已经发送到邮箱，欢迎加入</p>
            </div>
        <?php } ?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
        <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
        <input type="text" class="form-control" name="email" value="<?php echo set_value('email'); ?>" placeholder="邮箱"
               autofocus>
        <input type="text" class="form-control" name="captcha" placeholder="人类？">
        <button class="btn btn-lg btn-default btn-block captcha">我是人类</button>
        <button class="btn btn-lg btn-default btn-block join" style="margin: 0px;" type="submit">加入</button>
    </form>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script>
    $(function () {
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-join").validate({
            rules: {
                "email": {
                    required: true,
                    maxlength: 50,
                    email: true
                },
                "captcha": {
                    required: true,
                    rangelength: [8, 8]
                }
            },
            messages: {
                "email": {
                    required: "请输入邮箱",
                    maxlength: "邮箱不超过{0}个字",
                    email: "邮箱无效"
                },
                "captcha": {
                    required: "请输入验证码",
                    rangelength: "验证码不匹配"
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
        $('.captcha').click(function () {
            $(this).attr("disabled", true).html("Loading...")
            $.ajax({
                url: "./captcha",
                success: function (data) {
                    $(".captcha").html(data);
                },
                error: function () {
                    $(".alert").html("OOPS!验证码提取错误！");
                },
                complete: function(){
                    $('.captcha').removeAttr("disabled");
                }
            });
            return false;
        });
    });
</script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>