<?php foreach($photos as $photo): ?>
    <div class="photo-container mr-top-xl">
        <div class="img-container">
            <img id="<?php echo $photo['id']; ?>" class="img-gallery" src="<?php echo $photo['photo_path'] ?>" alt="">
            <div class="info-likes-container">
                <div class='photo-info'>
                    <span class='post-text'>Author: </span>
                    <span class='post-data'><?php echo App\Models\User::getUserNameByUserId($photo['user_id']) ?></span>
                    <span class='post-text'>Date: </span>
                    <span class='post-data'> <?php echo $photo['created_at'] ?></span>
                </div>
                <div class="control-block">
                    <div class="likes-button">
                        <i class='fas fa-heart <?php if(App\Models\Like::checkUserLike(auth()->id, $photo['id'])) {echo "active-like";} ?>' style='padding-right: 10px;'>
                            <?php echo App\Models\Like::countLikes($photo['id']); ?>
                        </i>
                    </div>
                    <div class="control-button">
                        <i class='fas fa-comments'></i>
                        <?php if(auth() && App\Models\Photo::checkUserPhoto(auth()->id, $photo['id'])):?>
                            <i class='fas fa-times-circle'></i>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class='comments-container'>
                <div class='previous-comments'>
                    <?php foreach( (array) App\Models\Comment::getCommentsFromPhoto($photo['id']) as $comment): ?>
                        <div class="comment">
                            <span class='user-name'><?php echo App\Models\User::getUserNameByUserId($comment['user_id']) ?>: </span>
                            <span class='user-text'><?php echo htmlspecialchars(strip_tags($comment['text'])); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class='input-and-button'>
                    <input id='comment-input' type='text'/>
                    <button class='add-comment'>Add comment</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<script src="/public/js/gallery.js"></script>