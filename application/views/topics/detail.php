<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/sidebar_dev_link.css" rel="stylesheet" type="text/css">
<link href="static/css/sidebar_statistics.css" rel="stylesheet" type="text/css">
<link href="static/css/bootstrap-markdown.min.css" rel="stylesheet" type="text/css">
<link href="static/css/go_top.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    ol.breadcrumb, div.author p, ul.pager {
        margin: 0
    }
    div.topic-head > h3 {
        margin-top: 0;
    }
    ul.pager li {
        margin-left: 10px;
    }
    div.topic-head > small {
        color: darkgray
    }
    div.topic-content img {
        max-width: 100%;
    }
    li.comment .avatar {
        width:48px;
        height:48px;
    }
    li.comment > div {
        padding-left: 60px;
        margin-top: 0;
    }
    li.comment > small, li.comment > div > small {
        color: darkgray;
    }
    li.comment > div  img {
        max-width: 100%;
    }
    div.author .avatar {
        width:48px;
        height:48px;
    }
    div.author > div {
        padding-left: 60px;
    }
    h6.hot-topic {
        margin: 0;;
    }
    div.md-preview img {
        max-width: 100%;
    }
    div.md-editor {
        margin: 0 0 20px;
    }
    .alert-danger {
        display: none;;
    }
    #bdshare a, #bdshare span {
        height: 25px;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <ol class="breadcrumb">
                    <li><a href="./">PHPCNC</a></li>
                    <li><a href="topics/<?php echo $topic['subject_id']['id'] ?>"><?php echo $topic['subject_id']['name'] ?></a></li>
                    <li class="active">话题详情</li>
                </ol>
            </div>
            <div class="panel-body">
                <div class="topic-head">
                    <h3><?php echo $topic['title'] ?></h3>
                    <small>
                        <a href="member/<?php echo $topic['author_id']['id'] ?>"><?php echo $topic['author_id']['username'] ?></a>
                        &nbsp;•&nbsp; 创建于<?php echo $topic['created_on'] ?>前
                        <?php if($topic['updated_on'] != $topic['created_on']){ ?>
                            &nbsp;•&nbsp; 更新于<?php echo $topic['updated_on'] ?>前
                        <?php } ?>
                        <?php if($topic['last_commenter_id']){ ?>
                            &nbsp;•&nbsp; 最后回复来自<a href="member/<?php echo $topic['last_commenter_id']['id'] ?>"><?php echo $topic['last_commenter_id']['username'] ?></a>
                            &nbsp;•&nbsp; <?php echo $topic['last_comment_on'] ?>
                        <?php } ?>
                        &nbsp;•&nbsp; <?php echo $topic['read_count'] + 1; ?>次阅读
                        <?php if($topic['comment_count']){ ?>
                            &nbsp;•&nbsp; <?php echo $topic['comment_count']; ?>个回复
                        <?php } ?>
                    </small>
                </div>
                <hr/>
                <div class="topic-content">
                        <h4><?php echo $topic['content'] ?></h4>
                </div>
            </div>
            <div class="panel-footer">
                <div id="comments"></div>
                <!-- Baidu Button BEGIN -->
                <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare pull-right">
                    <a class="bds_tsina"></a>
                    <a class="bds_qzone"></a>
                    <a class="bds_tqq"></a>
                    <a class="bds_renren"></a>
                    <a class="bds_fbook"></a>
                    <a class="bds_twi"></a>
                    <a class="bds_douban"></a>
                    <a class="bds_youdao"></a>
                    <span class="bds_more">更多</span>
                </div>
                <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6864780" ></script>
                <script type="text/javascript" id="bdshell_js"></script>
                <script type="text/javascript">
                    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
                </script>
                <!-- Baidu Button END -->
                <?php if($topic['author_id']['id'] === $current_user['id']){ ?>
                <a class="btn btn-default btn-xs" role="btn" href="topic/edit/<?php echo $topic['id'] ?>">
                    <span class="glyphicon glyphicon-edit"></span> 编辑
                </a>
                <?php }else{ ?>
                <button type="button" class="btn btn-default btn-xs collect" data-topic="<?php echo $topic['id'] ?>" disabled>
                    <span class="glyphicon glyphicon-heart"></span> <span class="text">收藏</span>
                </button>
                <?php } ?>
            </div>

        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">历史回复</h3>
            </div>
            <ul class="list-group comment-list">
                <?php if($comments){ ?>
                    <?php foreach($comments as $comment){ ?>
                    <li class="list-group-item comment">
                        <a href="member/<?php echo $comment['author_id']['id'] ?>" class="pull-left">
                            <img class="img-rounded avatar" src="http://www.gravatar.com/avatar/<?php echo $comment['author_id']['avatar']; ?>?s=48&d=monsterid">
                        </a>
                        <div>
                            <?php echo $comment['content'] ?>
                            <small>
                                <a href="member/<?php echo $comment['author_id']['id'] ?>"><?php echo $comment['author_id']['username'] ?></a>
                                &nbsp;•&nbsp; 回复于<?php echo $comment['created_on'] ?>前
                            </small>
                            <a href="<?php echo uri_string() ?>#new-comment" title="回复" class="pull-right comment-reply"
                               data-author="<?php echo $comment['author_id']['username'] ?>">
                                <span class="glyphicon glyphicon-share-alt"></span>
                            </a>
                        </div>
                    </li>
                    <?php } ?>
                <?php }else{ ?>
                    <li class="list-group-item comment tip">
                        等着你回复
                    </li>
                <?php } ?>
            </ul>
            <?php if($next_page || $pre_page){ ?>
            <div class="panel-footer">
                <ul class="pager">
                <?php if($next_page){ ?>
                    <li class="pull-right"><a href="topic/<?php echo $topic['id']; ?>/page/<?php echo $next_page; ?>#comments">向右走</a></li>
                <?php } ?>
                <?php if($pre_page){ ?>
                    <li class="pull-right"><a href="topic/<?php echo $topic['id']; ?>/page/<?php echo $pre_page; ?>#comments">向左走</a></li>
                <?php } ?>
                </ul>
            </div>
            <?php } ?>
        </div>
        <div class="panel panel-default" id="new-comment">
            <div class="panel-heading">
                <h3 class="panel-title">新的回复</h3>
            </div>
            <div class="panel-body">
                <form class="form-comment" action="" method="post">
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <input id="csrf" type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" name="topic" value="<?php echo $topic['id']; ?>">
                    <textarea id="comment-content" name="content" data-provide="markdown" class="form-control" placeholder="回复（支持Markdown）" rows="5"></textarea>
                    <button class="btn btn-default comment" type="submit">回复</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">

                    <h3 class="panel-title">作者</h3>
            </div>
            <div class="panel-body author">
                <a href="member/<?php echo $topic['author_id']['id'] ?>" class="pull-left">
                    <img class="img-rounded avatar" src="http://www.gravatar.com/avatar/<?php echo $topic['author_id']['avatar']; ?>?d=monsterid&s=48">
                </a>
                <div>
                    <a href="member/<?php echo $topic['author_id']['id'] ?>">
                        <strong> <?php echo $topic['author_id']['username'] ?></strong></a>
                    <p><?php echo $topic['author_id']['intro'] ?></p>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">热度榜 &nbsp;•&nbsp; <?php echo $topic['subject_id']['name'] ?></h3>
            </div>
            <ul class="list-group">
                <?php foreach($hot_topics as $hot_topic){ ?>
                    <li class="list-group-item">
                        <h6 class="hot-topic"><a href="topic/<?php echo $hot_topic['id'] ?>"><?php echo $hot_topic['title'] ?></a></h6>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <?php require dirname(__FILE__) . '/../sidebar_dev_link.php'; ?>
        <?php require dirname(__FILE__) . '/../sidebar_statistics.php'; ?>
    </div>
</div>
<?php require dirname(__FILE__) . '/../go_top.php'; ?>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="http://cdn.staticfile.org/jquery-validate/1.11.1/jquery.validate.min.js"></script>
<script src="static/js/markdown.js"></script>
<script src="static/js/to-markdown.js"></script>
<script src="static/js/bootstrap-markdown.js"></script>
<script src="static/js/go_top.js"></script>
<script>
    $(function(){
        var topic = $(".collect").data("topic");
        var collect =  $(".collect");
        if(collect.length){
            var status = false;
            $.ajax({
                url:"api/collections/status/" +  $(".form-comment input[name='topic']").val(),
                success:function(data){
                    if(status = data.status){
                        collect.children(".glyphicon").removeClass("glyphicon-heart")
                            .addClass("glyphicon-heart-empty");
                        collect.children(".text").html("取消收藏");
                    }
                },
                complete:function(){
                    collect.removeAttr("disabled");
                }
            });
            collect.click(function(){
                collect.attr("disabled", true)
                var key = $("#csrf").attr('name');
                var value = $("#csrf").attr('value');
                var data = {"topic" :  topic};
                data[key] = value;
                if(status){
                    $.ajax({
                        url:"api/collections/delete",
                        data: data,
                        type:"post",
                        success:function(data){
                            if(!data.error){
                                collect.children(".glyphicon").removeClass("glyphicon-heart-empty")
                                    .addClass("glyphicon-heart");
                                collect.children(".text").html("收藏");
                                status = false;
                            }else{
                                location.href = data.location;
                            }
                        },
                        complete:function(){
                            collect.removeAttr("disabled");
                        }
                    });
                } else{
                    $.ajax({
                        url:"api/collections/create",
                        data: data,
                        type:"post",
                        success:function(data){
                            if(!data.error){
                                collect.children(".glyphicon").removeClass("glyphicon-heart")
                                    .addClass("glyphicon-heart-empty");
                                collect.children(".text").html("取消收藏");
                                status = true;
                            }else{
                                location.href = data.location;
                            }
                        },
                        complete:function(){
                            collect.removeAttr("disabled");
                        }
                    });
                }
            });
        }
        $(".comment-reply").click(function(){
            var author = $(this).data("author");
            $("textarea[name='content']").val(function(index, old){
                author = "@" + author + " ";
                return old ? old + "\n" + author : author;
            });
        });
        $(".form-comment").validate({
            rules: {
                "content": {
                    required: true,
                    minlength: 5,
                    maxlength: 400
                }
            },
            messages: {
                "content": {
                    required: "请输入回复",
                    minlength: "回复至少需要{0}个字",
                    maxlength: "回复不超过{0}个字"
                }
            },
            invalidHandler:function(){
                $(".alert-danger p").remove();
            },
            submitHandler: function(form) {
                $("button.comment").attr("disabled", true);
                $.ajax({
                    url:"api/comments/create",
                    data: $(form).serializeArray(),
                    type:"post",
                    success:function(data){
                        if(data.error == "invalid content"){
                            $(".alert-danger p").remove();
                            $(".alert-danger").append(data.content);
                            $(".alert-danger").show();
                        }else if(data.error == "invalid user"){
                            $(".alert-danger p").remove();
                            $(".alert-danger").append("<p>@了无效用户</p>");;
                            $(".alert-danger").show();
                        }else if(data.error == "Unauthorized"){
                            location.href = data.location;
                        }else{
                            $(".alert-danger").hide();
                            $("#comment-content").val("");
                            if($("li.comment:first-child").hasClass("tip"))
                                $("li.comment:first-child").remove();
                            $(".comment-list").append(data.content);
                        }
                    },
                    complete: function(){
                        $("button.comment").removeAttr("disabled");
                    }
                });
            },
            onkeyup: false,
            onfocusout: false,
            errorLabelContainer: ".alert-danger",
            errorElement: "p"
        });
    });
</script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>