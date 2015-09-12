<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
    <div>
        <h3>Editing Day <?= $day['Day'] ?></h3>
        <form class="pure-form pure-form-stacked" action="<?php echo URL_WITH_INDEX_FILE; ?>list/updateDay" method="POST">
            <label>Max Temp</label>
            <input type="text" name="MxT" value="<?php echo htmlspecialchars($day['MxT'], ENT_QUOTES, 'UTF-8'); ?>" /><br>
            <label>Min Temp</label>
            <input type="text" name="MnT" value="<?php echo htmlspecialchars($day['MnT'], ENT_QUOTES, 'UTF-8'); ?>" /><br>
            <label>Avg Temp</label>
            <input type="text" name="AvT" value="<?php echo htmlspecialchars($day['AvT'], ENT_QUOTES, 'UTF-8'); ?>" /><br>
            <input type="hidden" name="Day_id" value="<?php echo htmlspecialchars($day['Day'], ENT_QUOTES, 'UTF-8'); ?>" /><!-- Not the best way to handle this, easily hackable, todo: fix -->
            <input type="submit" class="pure-button pure-button-primary" name="submit_update_day" value="Update" />
        </form>
    </div>
</div>

