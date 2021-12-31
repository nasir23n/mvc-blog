<div class="container mt-5">
	<?php echo message('message'); ?>
	<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
		<symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
			<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
		</symbol>
	</svg>

	<div class="row">
		<form action="<?php echo (isset($edit_post)) ? base_url('update') : base_url('create'); ?>" class="col-md-12" method="POST">
			<?php if(isset($edit_post)) { ?>
			<input type="hidden" name="_post_id" value="<?php echo $edit_post->id; ?>">
			<?php } ?>
			<div class="mb-3">
				<label for="title" class="form-label">Post Title</label>
				<input type="text" name="title" class="form-control" id="title" placeholder="Post title" value="<?php if(isset($edit_post)) echo $edit_post->title; ?>">
			</div>
			<div class="mb-3">
				<label for="body" class="form-label">Post body</label>
				<textarea class="form-control" name="body" id="body" rows="3" placeholder="Post body"><?php if(isset($edit_post)) echo trim($edit_post->body); ?></textarea>
			</div>
			<div class="mb-3">
				<button class="btn btn-primary">Submit</button>
			</div>
		</form>
		<br><br>
		<?php foreach ($posts as $post) { ?>
			<div class="col-sm-4">
				<div class="card">
					<!-- <img src="..." class="card-img-top" alt="..."> -->
					<div class="card-body">
						<h5 class="card-title"><?php echo $post->title; ?></h5>
						<p class="card-text"><?php echo str_limit($post->body, 500); ?></p>
						<form class="d-inline-block" action="<?php echo base_url('delete?id='.$post->id); ?>" method="POST" onsubmit="return confirm('Are you sure to delete this post?')">
							<button type="submit" class="btn btn-danger">Delete</button>
						</form>
						<a href="<?php echo base_url('edit?id='.$post->id); ?>" class="btn btn-warning">Edit</a>
						<a href="<?php echo base_url('show?id='.$post->id); ?>" class="btn btn-primary">Show</a>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>