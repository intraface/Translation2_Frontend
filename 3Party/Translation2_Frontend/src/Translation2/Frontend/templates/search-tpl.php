
<div class="search"><form action="<?php echo url('./'); ?>" method="GET">Search: <input type="text" name="search" value="" /> <input type="submit" value=" > " /></form></div>


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
                <td><a href="<?php echo url('../', array('edit_id' => $translation['id'], 'page_id' => $translation['page_id'])); ?>">Edit</a></td>
            </tr>
        <?php endforeach ?>
    </table>
<?php endif; ?>
