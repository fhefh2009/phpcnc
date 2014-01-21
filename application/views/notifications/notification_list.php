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
    li.notification > div.main {
        padding-left: 60px;
    }
    p.notification-content{
        margin: 0 0 7px;
    }
    a.refresh {
        margin-right: 10px;
    }
    small.notification-extra{
        color: darkgray
    }

    li.notification .avatar {
        width:48px;
        height:48px;
    }
    h6.hot-topic {
        margin: 0;;
    }
    ul.notification-tip{
        margin: 0;
        padding-left: 15px;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
            <?php if($notifications){ ?>
                <form class="form-comment" action="notifications/empty" method="post">
                    <input id="csrf" type="hidden" name="<?php echo $csrf_name; ?>" value="<?php echo $csrf_token; ?>">
                    <button class="btn btn-default btn-xs pull-right" type="submit">删除所有</button>
                </form>
                <a class="btn btn-default btn-xs pull-right refresh" href="<?php echo uri_string(); ?>" role="button">刷新</a>
            <?php } ?>
            <h3 class="panel-title">通知</h3>
            </div>
            <ul class="list-group notifications"">
                <?php if($notifications){ ?>
                    <?php foreach($notifications as $notification){ ?>
                        <li class="list-group-item notification">
                            <a href="member/<?php echo $notification['sender_id']['id'] ?>" class="pull-left">
                                <img class="img-rounded avatar" src="http://www.gravatar.com/avatar/<?php echo $notification['sender_id']['avatar']; ?>?s=48&d=monsterid">
                            </a>
                            <div class="main">
                                <p style="" class="notification-content">
                                    <?php echo $notification['comment_id']['content']; ?>
                                </p>
                                <button type="button" class="btn btn-default btn-xs delete pull-right" data-id="<?php echo $notification['id']; ?>">删除</button>
                                <?php if($notification['type'] == 0){ ?>
                                    <small class="notification-extra">
                                        <a href="member/<?php echo $notification['sender_id']['id']; ?>"><?php echo $notification['sender_id']['username']; ?></a> 回复了你的话题
                                        <a href="topic/<?php echo $notification['topic_id']['id']; ?>"><?php echo $notification['topic_id']['title']; ?></a> &nbsp;•&nbsp;
                                        <?php echo $notification['created_on']; ?>前
                                    </small>
                                <?php }else if($notification['type'] == 1){ ?>
                                    <small class="notification-extra">
                                        <a href="member/<?php echo $notification['sender_id']['id']; ?>"><?php echo $notification['sender_id']['username']; ?></a>
                                        在 <a href="topic/<?php echo $notification['topic_id']['id']; ?>"><?php echo $notification['topic_id']['title']; ?></a> 中@了你 &nbsp;•&nbsp;
                                        <?php echo $notification['created_on']; ?>前
                                    </small>
                                <?php } ?>
                            </div>

                        </li>
                    <?php } ?>
                <?php }else{ ?>
                    <li class="list-group-item">暂无通知信息！</li>
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
                <h3 class="panel-title">Tip</h3>
            </div>
            <div class="panel-body">
                <ul class="notification-tip">
                    <li>如果通知过多，可以删除不需要的通知</li>
                    <li>或者大扫除，点击“清空”</li>
                </ul>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">热门榜</h3>
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
            var notification = $(this).parents(".notification")
            if( $(".notification").length == 1)
                notification.html("该页的所有通知均被删除，请刷新！");
            else
                notification.remove();
            var key = $("#csrf").attr("name");
            var value = $("#csrf").attr("value");
            var data = {"id" : $(this).data("id")};
            data[key] = value;
            $.ajax({
                url:"api/notifications/delete",
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