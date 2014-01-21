<?php require dirname(__FILE__) . '/../header.php'; ?>
<style type="text/css">
    div.row {
        margin-top: 15px;
    }
    ul.avatar-tip{
        margin: 0;
        padding-left: 15px;
    }
    img.avatar {
        width:80px;
        height:80px;
    }
    div.main {
        padding-left: 90px;
    }
    small {
        color: darkgray
    }
    a.avatar {
        margin-right: 10px;
    }
</style>
<?php require dirname(__FILE__) . '/../content_start.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">头像维护</h3>
            </div>
            <div class="panel-body">
                <img class="img-rounded pull-left avatar" src="http://www.gravatar.com/avatar/<?php echo $current_user['avatar']; ?>?d=monsterid">
                <div class="main">
                    <small>
                        <p> PHPCNC采用接入Gravatar服务的方式获取成员的头像，因此如果需要修改头像，请直接修改Gravatar的头像信息，PHPCNC的头像将会在修改后自动得到更新。 </p>
                    </small>
                    <a class="btn btn-default pull-right avatar" href="https://cn.gravatar.com/" role="button" target="_blank">头像维护</a>
                    <a href="https://zh.wikipedia.org/wiki/Gravatar" target="_blank">Gravatar为何物？</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Tip</h3>
            </div>
            <div class="panel-body">
                <ul class="avatar-tip">
                    <li>换个帅气的脸，抓住第一印象</li>
                    <li>想要改资料？<a href="settings/profile">到此处</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php require dirname(__FILE__) . '/../content_end.php'; ?>
<?php require dirname(__FILE__) . '/../footer.php'; ?>