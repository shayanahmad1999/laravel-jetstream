<?php

if (!function_exists('display_message')) {
    function display_message($message, $type = 'info')
    {
        $colors = [
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow',
            'info' => 'blue',
        ];

        $color = $colors[$type] ?? 'gray';

        return '
    <div class="p-4 mb-4 rounded bg-' . $color . '-100 text-' . $color . '-700 dark:bg-' . $color . '-800 dark:text-' . $color . '-200">
        ' . $message . '
    </div>
    ';
    }
}
