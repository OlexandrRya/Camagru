<?php foreach($photos as $photo): ?>
    <div class="photo-container">
        <img class="img-gallery" src="<?php echo $photo['photo_path'] ?>" alt="">
    </div>
    <?php var_dump($photo['photo_path']); ?>
<?php endforeach; ?>


