<?php if(!empty($message['main'])): ?><div class="message"><?php echo $message['main']; ?></div><?php endif; ?>

<form action="<?php e(url(NULL)); ?>" method="POST">

<div class="formrow"><label for="identifier">Identifier</label><input type="text" name="identifier" value="<?php if(isset($values['identifier'])) echo $values['identifier']; ?>" /></div>


<div class="formrow"><label for="page_id">PageId</label>
    <select name="page_id">
        <?php for($i = 0; $i < count($created_page_id); $i++): ?>
            <option value="<?php e($created_page_id[$i]); ?>" <?php if(isset($values['page_id']) && $values['page_id'] == $created_page_id[$i]) e('selected="selected"'); ?> ><?php e($created_page_id[$i]); ?></option>
        <?php endfor; ?>
    </select>
    Ny: <input type="text" name="new_page_id" value="<?php if(isset($values['new_page_id'])) echo $values['new_page_id']; ?>" /> 
</div>

<?php foreach($langs AS $lang => $description): ?>
    <?php if(!empty($message['translation_'.$lang])): ?><div class="message"><?php e($message['translation_'.$lang])?></div><?php endif; ?>
    <div class="formrow"><label for="translation_<?php e($lang); ?>"><?php e(ucfirst($description)); ?></label><textarea id="translation_<?php e($lang); ?>" name="translation[<?php e($lang); ?>]"><?php if(isset($values['translation'][$lang])) echo $values['translation'][$lang]; ?></textarea></div>
<?php endforeach; ?>

<input type="submit" name="submit" value="  <?php (!empty($values['overwrite'])) ? e('Confirm save') : e('Save'); ?>  " />
<a href="<?php e(url(null)); ?>">Cancel</a>
<input type="hidden" name="overwrite" value="<?php if(!empty($values['overwrite'])) e('1'); ?>" />


</form>