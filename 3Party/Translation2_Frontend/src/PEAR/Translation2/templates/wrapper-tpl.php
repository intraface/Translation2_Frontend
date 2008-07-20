<h1><?php e($this->document->title); ?></h1>

<?php if (!empty($this->document->options)): ?>
<ul>
    <?php foreach ($this->document->options as $url => $name): ?>
        <li><a href="<?php e($url); ?>"><?php e($name); ?></a></li>
    <?php endforeach; ?>
</ul>
<?php endif; ?>

<?php echo $content; ?>