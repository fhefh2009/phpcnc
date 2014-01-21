<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/sidebar_dev_link.css" rel="stylesheet" type="text/css">
<link href="static/css/sidebar_statistics.css" rel="stylesheet" type="text/css">
<link href="static/css/go_top.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    ul.pager{
        margin: 0;
    }
    ul.pager li {
        margin-left: 10px;
    }
    li.topic-info > div.main {
        padding-left: 60px;
        padding-right: 45px
    }
    button.delete {
        margin-top: 6px;
    }
    a.refresh {
        margin-right: 10px;
    }
    h4.topic-title{
        margin: 0 0 7px;
    }
    small.topic-extra {
        color: darkgray
    }

    li.topic-info .avatar {
        width:48px;
        height:48px;
    }

    h6.hot-topic {
        margin: 0;;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <?php if($collections){ ?>
                    <form class="form-comment" action="collections/empty" method="post">
                        <input id="csrf" type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                        <button class="btn btn-default btn-xs pull-right" type="submit">删除所有</button>
                    </form>
                    <a class="btn btn-default btn-xs pull-right refresh" href="<?php echo uri_string(); ?>" role="button">刷新</a>
                <?php } ?>
                <h3 class="panel-title">我的收藏</h3>
            </div>
            <ul class="list-group collections">
                <?php if($collections){ ?>
                    <?php foreach($collections as $collection){ ?>
                        <li class="list-group-item topic-info collection">
                            <div  class="pull-right">
                                <a href="topic/<?php echo $collection['topic_id']['id'] ?>/page/<?php echo $collection['topic_id']['max_page'] ?>" class="pull-right">
                                    <span class="badge"><?php echo $collection['topic_id']['comment_count'] ?></span></a><br/>
                                <button type="button" class="btn btn-default btn-xs delete pull-right" data-topic="<?php echo $collection['topic_id']['id']; ?>">删除</button>
                            </div>
                            <a href="member/<?php echo $collection['topic_id']['author_id']['id'] ?>" class="pull-left">
                                <img class="img-rounded avatar" src="http://www.gravatar.com/avatar/<?php echo $collection['topic_id']['author_id']['avatar']; ?>?s=48&d=monsterid">
                            </a>
                            <div class="main">
                                <h4 class="topic-title"><a href="topic/<?php echo $collection['topic_id']['id'] ?>"><?php echo $collection['topic_id']['title'] ?></a></h4>
                                <small class="topic-extra">
                                    <a href="topics/<?php echo $collection['topic_id']['subject_id']['id'] ?>"><span class="label label-default"><?php echo $collection['topic_id']['subject_id']['name'] ?></span></a>
                                    &nbsp;•&nbsp; <a href="member/<?php echo $collection['topic_id']['author_id']['id'] ?>"><?php echo $collection['topic_id']['author_id']['username'] ?></a>
                                    &nbsp;•&nbsp; <?php echo $collection['topic_id']['created_on'] ?>前创建
                                    <?php if($collection['topic_id']['updated_on']){ ?>
                                        &nbsp;•&nbsp; <?php echo $collection['topic_id']['updated_on'] ?>前更新过
                                    <?php } ?>
                                    <?php if($collection['topic_id']['last_commenter_id']){ ?>
                                        &nbsp;•&nbsp; 最后回复来自<a href="member/<?php echo $collection['topic_id']['last_commenter_id']['id'] ?>"><?php echo $collection['topic_id']['last_commenter_id']['username'] ?></a>
                                        &nbsp;•&nbsp; <?php echo $collection['topic_id']['last_comment_on'] ?>前
                                    <?php } ?>
                                    &nbsp;•&nbsp; <?php echo $collection['created_on'] ?>前加入收藏
                                </small>
                            </div>
                        </li>
                    <?php } ?>
                <?php }else{ ?>
                    <li class="list-group-item">目前还没有收藏！</li>
                <?php } ?>
            </ul>
            <?php if($next_page || $pre_page){ ?>
                <div class="panel-footer">
                    <ul class="pager">
                        <?php if($next_page){ ?>
                            <li class="pull-right"><a href="page/<?php echo $next_page; ?>">向右走</a></li>
                        <?php } ?>
                        <?php if($pre_page){ ?>
                            <li class="pull-right"><a href="page/<?php echo $pre_page; ?>">向左走</a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">热门话题</h3>
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
<script src="static/js/go_top.js"></script>
<script>
    $(function(){
        $("button.delete").click(function(){
            var collection = $(this).parents(".collection")
            if( $(".collection").length == 1)
                collection.html("该页的所有收藏均被删除，请刷新！");
            else
                collection.remove();
            var key = $("#csrf").attr("name");
            var value = $("#csrf").attr("value");
            var data = {"topic" : $(this).data("topic")};
            data[key] = value;
            $.ajax({
                url:"api/collections/delete",
                data: data,
                type:"post",
                success:function(data){
                    if(data.error){
                        location.href = data.location;
                    }
                }
            });
        });
    });
</script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>
