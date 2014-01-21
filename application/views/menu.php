<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./" style="padding-top: 10px; padding-bottom: 10px"><img src="static/img/site/logo.png" style="width: 102px"></a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="">社区</a></li>
                <li><a href="subjects">主题</a></li>
                <li><a href="members">一百零八将</a></li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="搜索">
                </div>
            </form>
            <?php if($current_user){ ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="notifications"><span class="badge"><?php echo $unread_notifications_count ?></span></a></li>
                    <li><a href="member/<?php echo $current_user['id'] ?>"><?php echo $current_user['username'] ?></a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="collections">我的收藏</a></li>
                            <li class="divider"></li>
                            <li><a href="settings/profile">资料维护</a></li>
                            <li><a href="settings/avatar">头像维护</a></li>
                            <li class="divider"></li>
                            <li><a href="settings/password">密码维护</a></li>
                            <li class="divider"></li>
                            <li><a href="logout">退出</a></li>
                        </ul>
                    </li>
                </ul>
            <?php }else{ ?>
                <div class="btn-group navbar-btn navbar-right">
                    <a class="btn btn-default" href="register">加入</a>
                    <a class="btn btn-default" href="login">冒泡</a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>