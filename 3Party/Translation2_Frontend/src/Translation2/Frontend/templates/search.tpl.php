<div class="search">
	<form action="<?php echo url('./'); ?>" method="get">
		<label>Search: <input type="text" name="search" value="" /></label> <input type="submit" value=" > " />
	</form>
</div>

<p><a href="<?php e(url(null, array('create'))); ?>">Create</a></p>

<?php if(isset($result) && count($result) > 0): ?>
    <table>
        <caption>Result</caption>
        <tr>
            <th>Identifier</th>
            <th>PageID</th>
            <?php foreach($langs AS $lang => $description): ?>
                <th><?php e(ucfirst($description)); ?></th>
            <?php endforeach ?>
            <th></th>
        </tr>
        <?php foreach($result AS $translation): ?>
            <tr>
                <td><?php e($translation['id']); ?></td>
                <td><?php e($translation['page_id']); ?></td>
                <?php foreach($langs AS $lang => $description): ?>
                    <td><?php e($translation[$lang]); ?></td>
                <?php endforeach ?>
                <td><a href="<?php e(url($translation['id'], array('page_id' => $translation['page_id']))); ?>">Edit</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif; ?>
