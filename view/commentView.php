<ul>
    <?php foreach ($comments as $comment): ?>
        <li><?php echo $this->escape($comment['comment']) . ' - ' . $this->escape($comment['name']); ?></li>
    <?php endforeach; ?>
</ul>