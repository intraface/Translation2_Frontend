<form <?php echo $this->getFormProperties(); ?>>
<?php foreach ($this->fields as $field) : ?>
<p>
<label for="<?php echo $field->id; ?>"><?php echo $field->name; ?></label>
<?php echo $field; ?>
<?php foreach ($field->messages as $error) : ?>
<span><?php echo $error; ?></span>
<?php endforeach; ?>

</p>
<?php endforeach; ?>

<input type="submit" />
</form>