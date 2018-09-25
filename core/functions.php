<?php

function show_table($arr, $params=array())
{
    if (!empty($arr) && is_array($arr[0])) {
        echo "<table class=\"db-table\" ".(isset($params["style"]) ? "style=\"{$params["style"]}\"":"")."><tr>";
        foreach ($arr[0] as $n => $v) echo "<th noWrap>".$n."</th>";
        echo "</tr>";
        foreach ($arr as $n => $v) {
            echo "<tr>";
            foreach ($v as $nn => $vv) echo "<td>" . $vv . "</td>";

            echo "</tr>";
        }
        echo "</table>";
    }
}
?>