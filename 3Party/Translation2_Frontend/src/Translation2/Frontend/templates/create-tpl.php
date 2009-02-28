<form action="<?php e(url('.')); ?>" method="POST">

<div class="formrow"><label for="identifier">Identifier</label><input type="text" name="identifier" value="<?php if(isset($id)) echo $id; ?>" /></div>

<div class="formrow"><label for="page_id">PageId</label>
    <select name="page_id">
        <?php for($i = 0; $i < count($created_page_id); $i++): ?>
            <option value="<?php e($created_page_id[$i]); ?>" <?php if(isset($page_id) && $page_id == $created_page_id[$i]) e('selected="selected"'); ?> ><?php e($created_page_id[$i]); ?></option>
        <?php endfor; ?>
    </select>
    Ny: <input type="text" name="new_page_id" value="<?php if(isset($new_page_id)) echo $new_page_id; ?>" /> 
</div>

<div class="formrow"><label for="translation_dk">DK</label><textarea id="translation_dk" name="translation[dk]"><?php if(isset($dk)) echo $dk; ?></textarea></div>

<div class="formrow"><label for="translation_uk">UK</label><textarea id="translation_uk" name="translation[uk]"><?php if(isset($uk)) echo $uk; ?></textarea></div>

<input type="submit" name="submit" value="  Gem  " />
<input type="hidden" name="overwrite" value="0" />


</form>