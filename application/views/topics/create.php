<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    ol.breadcrumb{
        margin: 0
    }
    div.md-preview img {
        max-width: 100%;
    }
    div.md-editor {
        margin: 20px 0;
    }
    ul.markdown-tip{
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
              <h3 class="panel-title"><ol class="breadcrumb">
                      <li><a href="#">PHPCNC</a></li>
                      <li><a href="topics/<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></a></li>
                      <li class="active">新的话题</li>
                  </ol></h3>
            </div>
            <div class="panel-body">
                <form class="form-create" action="" method="post">
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <input type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                    <input type="text" class="form-control" name="title" placeholder="标题" value="<?php echo set_value('title'); ?>"
                           autofocus>
                    <textarea name="content" class="form-control" placeholder="正文（支持Markdown）" rows="18" data-provide="markdown"><?php echo set_value('content'); ?></textarea>
                    <button class="btn btn-default" type="submit">发布</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $subject['name']; ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $subject['description']; ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Markdown</h3>
            </div>
            <div class="panel-body">
                <ul class="markdown-tip">
                    <li>Markdown是什么？ <a href="https://zh.wikipedia.org/zh-cn/Markdown" target="_blank">点之</a></li>
                    <li>利用Markdown，可书写具有良好可读性和排版效果的文章</li>
                    <li>Markdown的目标是实现易读易写</li>
                    <li>Markdown简单易学</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script src="static/js/markdown.js"></script>
<script src="static/js/to-markdown.js"></script>
<script src="static/js/bootstrap-markdown.js"></script>
<script>
    $(function(){
        var $alert_danger = $(".alert-danger");
        if ($alert_danger.children().length > 0) $alert_danger.show();
        $(".form-create").validate({
            rules: {
                "title": {
                    required: true,
                    minlength: 5,
                    maxlength: 50
                },
                "content": {
                    required: true,
                    minlength: 20,
                    maxlength: 2000
                }
            },
            messages: {
                "title": {
                    required: "请输入标题",
                    minlength: "标题至少需要{0}个字",
                    maxlength: "标题不超过{0}个字"
                },
                "content": {
                    required: "请输入正文",
                    minlength: "正文至少需要{0}个字",
                    maxlength: "正文不超过{0}个字"
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