<?php $id = isset($id) ? $id : (isset($params['id']) ? $params['id'] : 0) ?>
<a href="javascript:void(0);" data-id="{{$id}}"
    class="btn btn-outline-danger btn-icon waves-effect waves-themed sortable-delete deleteRow">
    <!-- data-toggle="modal" data-target="#delete-modal-alert" -->
</a>