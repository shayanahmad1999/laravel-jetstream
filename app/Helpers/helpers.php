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
    <div class="max-w-7xl mx-auto py-4 mt-4 sm:px-6 lg:px-8 rounded-2xl bg-' . $color . '-100 text-' . $color . '-50 dark:bg-' . $color . '-500 dark:text-' . $color . '-200">
        ' . $message . '
    </div>
    ';
    }
}
