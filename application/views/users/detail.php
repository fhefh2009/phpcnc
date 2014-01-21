<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/sidebar_dev_link.css" rel="stylesheet" type="text/css">
<link href="static/css/sidebar_statistics.css" rel="stylesheet" type="text/css">
<link href="static/css/go_top.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    h6.hot-topic {
        margin: 0;;
    }
    ul.pager, div.profile ul{
        margin: 0;
    }
    ul.pager li {
        margin-left: 15px;
    }
    div.profile {
        padding-left: 90px;
        height: 80px
    }
    img.avatar {
        width: 80px;
        height: 80px;;
    }
    ul.profile small, small.topic-extra{
        color: darkgray;
    }
    li.topic-info > div {
        padding-right: 45px
    }
    h4.topic-title{
        margin: 0 0 7px;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body user-detail">
                <img class="img-rounded pull-left avatar" src="http://www.gravatar.com/avatar/<?php echo $host['avatar']; ?>?d=monsterid">
                <small class="pull-right">
                    <?php echo $host['created_on'] ?>加入 &nbsp;•&nbsp; <?php echo $host['id'] ?>号会员
                </small>
                <div class="profile">
                    <ul class="list-unstyled">
                        <li><strong><?php echo $host['username'] ?></strong></li>
                        <li><?php echo $host['city'] ?></li>
                        <li><?php echo $host['company'] ?></li>
                        <?php if($host['blog']){ ?>
                        <li><a href="<?php echo $host['blog'] ?>" target="_blank">我的主页</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <?php if($host['intro']){ ?>
                <hr/>
                <p>
                    <?php echo $host['intro'] ?>
                </p>
                <?php } ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">最新话题</h3>
            </div>
            <ul class="list-group">
                <?php if($topics){ ?>
                    <?php foreach($topics as $topic){ ?>
                    <li class="list-group-item" topic-info">
                        <a href="topic/<?php echo $topic['id'] ?>/page/<?php echo $topic['max_page'] ?>" class="pull-right">
                            <span class="badge"><?php echo $topic['comment_count'] ?></span></a>
                        <div>
                            <h4 class="topic-title">
                                <a href="topic/<?php echo $topic['id'] ?>"><?php echo $topic['title'] ?></a>
                            </h4>
                            <small class="topic-extra">
                                <a href="topics/<?php echo $topic['subject_id']['id'] ?>"><span class="label label-default"><?php echo $topic['subject_id']['name'] ?></span></a>
                                &nbsp;•&nbsp; <?php echo $topic['created_on'] ?>前创建
                                <?php if($topic['updated_on']){ ?>
                                    &nbsp;•&nbsp;  <?php echo $topic['updated_on'] ?>前更新过
                                <?php } ?>
                                <?php if($topic['last_commenter_id']){ ?>
                                    &nbsp;•&nbsp; 最后回复来自<a href="member/<?php echo $topic['last_commenter_id']['id'] ?>"><?php echo $topic['last_commenter_id']['username'] ?></a>
                                    &nbsp;•&nbsp; <?php echo $topic['last_comment_on'] ?>前
                                <?php } ?>
                            </small>
                        </div>
                    </li>
                    <?php } ?>
                <?php }else{ ?>
                    <li class="list-group-item">
                        暂未发布任何话题。
                    </li>
                <?php } ?>
            </ul>
            <?php if($next_page || $pre_page){ ?>
                <div class="panel-footer">
                    <ul class="pager">
                        <?php if($next_page){ ?>
                            <li class="pull-right"><a href="member/<?php echo $host['id']; ?>/page/<?php echo $next_page; ?>#comments">向右走</a></li>
                        <?php } ?>
                        <?php if($pre_page){ ?>
                            <li class="pull-right"><a href="member/<?php echo $host['id']; ?>/page/<?php echo $pre_page; ?>#comments">向左走</a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>

    </div>
    <div class="col-md-4">
        <?php if($hot_topics){ ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">热门话题 &nbsp;•&nbsp; <?php echo $host['username'] ?></h3>
                </div>
                <ul class="list-group">
                    <?php foreach($hot_topics as $hot_topic){ ?>
                        <li class="list-group-item">
                            <h6 class="hot-topic"><a href="topic/<?php echo $hot_topic['id'] ?>"><?php echo $hot_topic['title'] ?></a></h6>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <?php require dirname(__FILE__) . '/../sidebar_dev_link.php'; ?>
        <?php require dirname(__FILE__) . '/../sidebar_statistics.php'; ?>
    </div>
</div>
<?php require dirname(__FILE__) . '/../go_top.php'; ?>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="static/js/go_top.js"></script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>