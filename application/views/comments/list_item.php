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
    </div>
</li>