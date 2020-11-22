<table class="table">
    <tbody>
        <?php foreach (($loggers?:[]) as $logs): ?>
            <tr>
                <?php foreach (($logs?:[]) as $element): ?>
                    <td><?= ($element) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>