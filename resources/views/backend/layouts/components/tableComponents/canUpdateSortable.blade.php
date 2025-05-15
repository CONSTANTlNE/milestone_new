<?php 
    $editLink = isset($links->edit) ? $links->edit : '';
    $params = isset($params) ? $params : ['id' => 0];
?>
<a href="{{route($editLink, $params)}}"
    class="btn btn-outline-primary btn-icon waves-effect waves-themed sortable-edit">
</a>