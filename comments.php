<section class="bg-white border rounded shadow-sm pt-3 px-3 mb-4">
	
	<form class="form-comment" method="POST" action="<?php echo esc_url(get_option('siteurl')); ?>/wp-comments-post.php"  id="commentform">
		<h2 class="h4 mb-3">Leave a Comment</h2>
		<input type="hidden" name="action" value="k_comment">
		<input type="hidden" name="post_id" value="143071">
        <input type="hidden" id="url" name="url" required="" value="admin">
		<div class="form-group">
			<textarea class="form-control" rows="5"  id="comment" name="comment" required  placeholder="Comment"></textarea>
		</div>
		<div class="row">
			<div class="col-12 col-sm-6 form-group">
				<input class="form-control" type="text" name="author" id="author" required="" value="" placeholder="Name">
			</div>
			<div class="col-12 col-sm-6 form-group">
				<input class="form-control" type="email" id="email" name="email" required="" placeholder="Email">
			</div>
		</div>
		<div class="form-group">
			<button class="btn btn-primary" name="submit" type="submit" id="submit">Send comment
            <?php comment_id_fields(); ?>

            </button>
		</div>
    <?php do_action('comment_form', $post->ID); ?>

	</form>
</section>