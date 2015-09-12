<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<h1 class="content-subhead">List</h1>
<div class="container">
    <div>
        <h3>Add/Update A Day</h3>
        <form class="pure-form" action="<?php echo URL_WITH_INDEX_FILE; ?>list/addDay" method="POST">
            <input type="text" placeholder="Day Number" name="Day" value="" required />
            <input type="text" placeholder="Max Temp" name="MxT" value="" required />
            <input type="text" placeholder="Min Temp" name="MnT" value="" required/>
            <input type="text" placeholder="Avg Temp" name="AvT" value="" required/>
            <input type="submit" class="pure-button pure-button-primary" name="submit_add_day" value="Add" />
        </form>
    </div>
    <!-- main content output -->
    <div>
        <h3>List of Days With Temps</h3>
        <table class="pure-table">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Day</td>
                <td>Max Temp</td>
                <td>Min Temp</td>
                <td>Avg Temp</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
               
            <?php foreach ($days as $key => $day) { ?>
                <tr<?php if($key % 2 != 0){echo ' class="pure-table-odd"';}?>>
                    <td><?php if (isset($day['Day'])) echo htmlspecialchars($day['Day'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['MxT'])) echo htmlspecialchars($day['MxT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['MnT'])) echo htmlspecialchars($day['MnT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['AvT'])) echo htmlspecialchars($day['AvT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL_WITH_INDEX_FILE . 'list/deleteDay/' . htmlspecialchars($day['Day'], ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL_WITH_INDEX_FILE . 'list/editDay/' . htmlspecialchars($day['Day'], ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
