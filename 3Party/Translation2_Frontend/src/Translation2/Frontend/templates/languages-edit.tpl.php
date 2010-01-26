<form action="<?php e(url(null, array($context->subview()))); ?>" method="post">
	<label>Lang_id
		<input type="text" value="" name="lang_id" />
	</label>
	<label>table_name
		<input type="text" value="" name="table_name" />
	</label>
	<label>name
		<input type="text" value="" name="name" />
	</label>
	<label>meta
		<input type="text" value="" name="meta" />
	</label>
	<label>error_text
		<input type="text" value="" name="error_text" />
	</label>
	<label>encoding
		<input type="text" value="" name="encoding" />
	</label>
	<input type="submit" value="Gem" name="submit" />
</form>
