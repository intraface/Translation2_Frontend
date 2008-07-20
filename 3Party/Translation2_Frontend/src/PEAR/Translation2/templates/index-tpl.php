<div class="search">
    <form action="<?php echo $this->url('search'); ?>" method="GET">
        <label for="search">Search</label> <input id="search" type="text" name="search" value="" /> 
        <input type="submit" value=" > " />
    </form>
</div>

<table>
    <caption>Translations</caption>
    <?php foreach ($translations as $identifier => $t): ?>
        <tr>
            <th><?php e($identifier); ?></th>
            <td><?php e($t); ?></td>
        </tr>
    <?php endforeach; ?>
</table>