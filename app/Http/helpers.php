<?php

function rafator(string $path)
{
    $fullPath = public_path($path);

    return asset($path).(file_exists($fullPath) ? '?'.filemtime($fullPath) : '');
}
