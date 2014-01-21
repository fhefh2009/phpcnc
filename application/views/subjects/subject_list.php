<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/sidebar_dev_link.css" rel="stylesheet" type="text/css">
<link href="static/css/sidebar_statistics.css" rel="stylesheet" type="text/css">
<link href="static/css/go_top.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    small.subject-info {
        color: darkgray;
        margin-left: 10px
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">主题</h3>
            </div>
            <ul class="list-group">
                <?php foreach($subjects as $subject){ ?>
                    <li class="list-group-item">
                        <a href="topics/<?php echo $subject['id'] ?>"><?php echo $subject['name'] ?></a>
                        <a class="btn btn-default pull-right btn-xs" href="topic/create/<?php echo $subject['id'] ?>" role="button">新的话题</a>
                        <?php if($subject['topic_count']){ ?>
                        <small class="subject-info">
                            <?php echo $subject['topic_count'] ?>个话题
                                &nbsp;•&nbsp; <?php echo $subject['last_alter_on'] ?>前有更新
                        </small>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <?php require dirname(__FILE__) . '/../sidebar_dev_link.php'; ?>
        <?php require dirname(__FILE__) . '/../sidebar_statistics.php'; ?>
    </div>
</div>
<?php require dirname(__FILE__) . '/../go_top.php'; ?>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<script src="static/js/go_top.js"></script>
<?php require dirname(__FILE__) . '/../footer.php'; ?>