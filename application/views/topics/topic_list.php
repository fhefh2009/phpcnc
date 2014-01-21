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
    li.topic-info > div {
        padding-left: 60px;
        padding-right: 45px
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
                <h3 class="panel-title">最新话题</h3>
            </div>
            <ul class="list-group">
                <?php foreach($topics as $topic){ ?>
                <li class="list-group-item topic-info">
                    <a href="topic/<?php echo $topic['id'] ?>/page/<?php echo $topic['max_page'] ?>" class="pull-right">
                        <span class="badge"><?php echo $topic['comment_count'] ?></span></a>
                    <a href="member/<?php echo $topic['author_id']['id'] ?>" class="pull-left">
                        <img class="img-rounded avatar" src="http://www.gravatar.com/avatar/<?php echo $topic['author_id']['avatar']; ?>?s=48&d=monsterid">
                    </a>
                    <div>
                        <h4 class="topic-title"><a href="topic/<?php echo $topic['id'] ?>"><?php echo $topic['title'] ?></a></h4>
                        <small class="topic-extra">
                            <a href="topics/<?php echo $topic['subject_id']['id'] ?>"><span class="label label-default"><?php echo $topic['subject_id']['name'] ?></span></a>
                            &nbsp;•&nbsp; <a href="member/<?php echo $topic['author_id']['id'] ?>"><?php echo $topic['author_id']['username'] ?></a>
                            &nbsp;•&nbsp; <?php echo $topic['created_on'] ?>前发布
                            <?php if($topic['updated_on'] != $topic['created_on']){ ?>
                                &nbsp;•&nbsp; <?php echo $topic['updated_on'] ?>前更新过
                            <?php } ?>
                            <?php if($topic['last_commenter_id']){ ?>
                                &nbsp;•&nbsp; 最后回复来自<a href="member/<?php echo $topic['last_commenter_id']['id'] ?>"><?php echo $topic['last_commenter_id']['username'] ?></a>
                                &nbsp;•&nbsp; <?php echo $topic['last_comment_on'] ?>前
                            <?php } ?>
                        </small>
                    </div>
                </li>
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
<?php require dirname(__FILE__) . '/../footer.php'; ?>
