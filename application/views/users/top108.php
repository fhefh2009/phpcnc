<?php require dirname(__FILE__) . '/../header.php'; ?>
<link href="static/css/sidebar_dev_link.css" rel="stylesheet" type="text/css">
<link href="static/css/sidebar_statistics.css" rel="stylesheet" type="text/css">
<link href="static/css/go_top.css" rel="stylesheet" type="text/css">
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    .member-info {
        margin-top: 10px;
        width: 76px;
        display: inline-block;
    }
    .member-info > div.name {
        margin-top: 5px;
        white-space:nowrap;
        word-break:keep-all;
        overflow:hidden;
        text-overflow:ellipsis;
    }
    .member-info img {
        width:48px;
        height:48px;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">一百零八将</h3>
                </div>
                <div class="panel-body">
                    <?php foreach($users as $user){ ?>
                    <div class="member-info">
                        <div class="text-center">
                            <a href="member/<?php echo $user['id']; ?>" class="center-block">
                                <img class="img-rounded" src="http://www.gravatar.com/avatar/<?php echo $user['avatar']; ?>?s=48&d=monsterid">
                            </a>
                        </div>
                        <div class="text-center name">
                            <a href="member/<?php echo $user['id'] ?>"><?php echo $user['username'] ?></a>
                        </div>
                    </div>
                    <?php } ?>
               </div>
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