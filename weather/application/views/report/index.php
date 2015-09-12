<?php

?>
<div id="chart">
    
</div>
<h3>List of Days With Temps</h3>
<form class="pure-form">
    <input id="filter-input" type="search" placeholder="Filter">
    </form><br><br>
        <table id="report-table" class="pure-table pure-table-bordered">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <th data-sort="int">Day</th>
                <th data-sort="int">Max Temp</th>
                <th data-sort="int">Min Temp</th>
                <th data-sort="int">Avg Temp</th>
            </tr>
            </thead>
            <tbody>
               
            <?php foreach ($days as $key => $day) { ?>
                <tr>
                    <td><?php if (isset($day['Day'])) echo htmlspecialchars($day['Day'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['MxT'])) echo htmlspecialchars($day['MxT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['MnT'])) echo htmlspecialchars($day['MnT'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($day['AvT'])) echo htmlspecialchars($day['AvT'], ENT_QUOTES, 'UTF-8'); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php 
        /**
         * This could probably be done way nicer some other way.... :P
         */
        $MxT = array();
        $MnT = array();
        $AvT = array();
        foreach($days as $day){
            $MxT[]=$day['MxT'];
            $MnT[]=$day['MnT'];
            $AvT[]=$day['AvT'];
        }
        $mxtList = implode(', ', $MxT);
        $mntList = implode(', ', $MnT);
        $avtList = implode(', ', $AvT);
        ?>
        <script>
        var chart = c3.generate({
    data: {
        columns: [
            ['Max', <?= $mxtList ?>],
            ['Min', <?= $mntList ?>],
            ['Avg', <?= $avtList ?>]
        ],
        type: 'bar'
    
    
        // or
        //width: 100 // this makes bar width 100px
    }
});
            
        </script>