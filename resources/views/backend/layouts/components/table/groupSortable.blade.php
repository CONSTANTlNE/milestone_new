@extends('CMS.layout.cms')
@section('header')
    <title>{{sitename()}} - {{tr('project')}}</title>
@stop
@section('content')
<main id="js-page-content" role="main" class="page-content">
        
        <div class="row">
            <div class="col-xl-12">
                <div id="panel-1" class="panel">
                    @if(Session::has('success'))
                        <div class="alert bg-success-400 text-white" role="alert">
                            {!! Session::get("success") !!}
                        </div>
                    @elseif(Session::has('error'))
                        <div class="alert bg-danger-400 text-white" role="alert">
                            {!! Session::get("error") !!}
                        </div>
                    @endif <br>
                    <div class="panel-hdr">
                        <h2>
                            {{tr($module)}} <span class="fw-300"><i>{{tr('sortable list')}}</i></span>
                        </h2>
                        <div class="panel-toolbar">
                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                    data-offset="0,10" data-original-title="{{tr('collapse')}}"></button>
                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                    data-offset="0,10" data-original-title="{{tr('fullscreen')}}"></button>
                        </div>
                    </div>
                    @yield('groupSortableContent')

            </div>
        </div>
    </div>
</main>
@endsection

@push('componentScripts')
    <script>
            $(document).ready(function()
            {
                var table = $('#table-sortable').DataTable(
                {
                    responsive: true,
                    searching: true,
                    paging: false,
                    rowReorder:
                    {
                        selector: 'tr td:not(:first-child)'
                    },
                    filter: true, //for demo purpose only
                    lengthChange: true, //for demo purpose only
                    buttons: [
                        {
                            extend: 'csvHtml5',
                            text: 'CSV',
                            titleAttr: 'Generate CSV',
                            className: 'btn-outline-default'
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-default'
                        }

                    ],
                    rowGroup:
                    {
                        dataSrc: 2
                    },
                    order: [[2, "asc" ]],
                });

                /* log events - demo purpose only */
                // e, details, edit 
                table.on('row-reorder', function(e, diff, edit)
                {
                    let sortableData = [];
                    for (var i = 0, ien = diff.length; i < ien; i++)
                    {
                        let id = diff[i].node.childNodes[0].nextElementSibling.getAttribute('data-id');
                        var object = {
                            id: id,
                            newPos: diff[i].newData,
                        };
                        sortableData.push(object);
                    }
                    if(sortableData.length > 0){
                        //use ajax to set order
                        data = {
                            model: @yield('sortableModel'),
                            data: sortableData,
                        };
                        $.ajax({
                            type: "POST",
                            beforeSend: function (request) {
                                request.setRequestHeader(
                                    "X-CSRF-Token",
                                    $('meta[name="csrf-token"]').attr("content")
                                );
                            },
                            url: "/connect/set-sortable-data",
                            data: data,
                            success: function (msg) {
                                console.log(msg);
                            },
                        });
                    }
                });

                @if(isset($links->delete) && $links->delete)
                    $('#table-sortable tbody').on( 'click', '.deleteRow', function () {
                        let id = $(this).data('id');
                        self = $(this);
                        Swal.fire(
                        {
                                title: "{{tr('are you sure, you want to delete?')}}",
                                type: "question",
                                showCancelButton: true,
                                cancelButtonText: '{{tr('cancel')}}',
                                confirmButtonText: "{{tr('yes, delete!')}}"
                            }).then(function (result) {
                            if (result.value) {
                                table
                                    .row( self.parents('tr') )
                                    .remove()
                                    .draw();

                                    $.ajax({
                                        type: "POST",
                                        beforeSend: function (request) {
                                            request.setRequestHeader(
                                                "X-CSRF-Token",
                                                $('meta[name="csrf-token"]').attr("content")
                                            );
                                        },
                                        url: '{!! route($links->delete) !!}',
                                        data: {id: id},
                                        success: function (msg) {
                                            // Swal.fire('{{tr('data removed successfully!')}}', '', "success");
                                        },
                                    });

                            }
                        });
                    } );
                @endif

            });

        </script>

@endPush








