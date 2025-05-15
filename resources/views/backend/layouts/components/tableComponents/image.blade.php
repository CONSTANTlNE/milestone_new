<?php 
    $image = isset($image) && $image ? $image : '';
    $folder = isset($folder) && $folder ? $folder : 'images';
    $size = isset($size) && $size ? $size : '1x';
    $width = 50 * floatval($size);
?>
<img style="height: {{$width}}px;" src="{{ asset('files/'.$folder.'/'.$image) }}"/>
