

<div class="message">Den angivet identifier eksisterer allerede</div>



<form action="<?php e(url()); ?>" method="POST">

<div class="formrow"><label for="id">Identifier</label><input type="text" name="id" value="<?php if(isset($id)) echo $id; ?>" /> (Simpelt forståeligt engelsk)</div>

<?php
if(isset($exists) && is_array($exists) && count($exists) > 0) {
    echo '<div class="exists">';
    foreach($exists AS $key => $value) {
        echo '<p>'.$key.': '.$value['id'].'</p>';
    }
    echo '</div>';
}
?> 

<div class="formrow"><label for="page_id">PageId</label>
    <select name="page_id">
        <?php for($i = 0; $i < count($created_page_id); $i++): ?>
            <option value="<?php e($created_page_id[$i]); ?>" <?php if(isset($page_id) && $page_id == $created_page_id[$i]) e('selected="selected"'); ?> ><?php e($created_page_id[$i]); ?></option>
        <?php endfor; ?>
    </select>
    Ny: <input type="text" name="new_page_id" value="<?php if(isset($new_page_id)) echo $new_page_id; ?>" /> (Modulnavn)
</div>

<div class="formrow"><label for="dk">DK</label><textarea name="dk"><?php if(isset($dk)) echo $dk; ?></textarea></div>

<?php
if(isset($exists) && is_array($exists) && count($exists) > 0) {
    echo '<div class="exists">';
    foreach($exists AS $key => $value) {
        echo '<p>'.$key.': '.$value['dk'].'</p>';
    }
    echo '</div>';
}
?>

<div class="formrow"><label for="uk">UK</label><textarea name="uk"><?php if(isset($uk)) echo $uk; ?></textarea></div>

<?php
if(isset($exists) && is_array($exists) && count($exists) > 0) {
    echo '<div class="exists">';
    foreach($exists AS $key => $value) {
        echo '<p>'.$key.': '.$value['uk'].'</p>';
    }
    echo '</div>';
}
?>

<?php
if(isset($overwrite) && $overwrite == 1) {
    ?>
    <input type="submit" name="submit" value="  Gem alligevel " /> eller <a href="index.php">Fortryd</a>
    <input type="hidden" name="overwrite" value="1" />
    <?php
}
else {
    ?>
    <input type="submit" name="submit" value="  Gem  " />
    <input type="hidden" name="overwrite" value="0" />
    <?php
}
?>

</form>