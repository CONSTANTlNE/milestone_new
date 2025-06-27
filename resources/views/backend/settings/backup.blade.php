@extends('dashboard.layouts.master')
@section('title') ყველა სარეზერვო ასლი @endsection
@section('css')
    <link href="{{ URL::asset('/libs/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    @component('common-components.breadcrumb')
         @slot('title') ყველა სარეზერვო ასლი  @endslot
         @slot('li_1') სარეზერვო ასლები  @endslot
    @endcomponent
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="card border border-success">
                            <div class="card-header bg-transparent border-success">
                                <h5 class="my-0 text-success"><i class="mdi mdi-check-all mr-3"></i>{!! Session::get("success") !!}</h5>
                            </div>
                        </div>
                    @elseif(Session::has('error'))
                        <div class="card border border-danger">
                            <div class="card-header bg-transparent border-danger">
                                <h5 class="my-0 text-danger"><i class="mdi mdi-block-helper mr-3"></i>{!! Session::get("error") !!}</h5>
                            </div>
                        </div>
                    @endif
                  @can('dashboard.socials.create')
                  <div class="row" style="margin-bottom: 20px;">
                      <div class="col-12">
                        <button id="create-new-backup-button" href="{{ route('dashboard.backup.store', app()->getLocale()) }}" class="btn btn-primary ladda-button mb-2" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> ახალი სარეზერვო ასლის შექმნა</span></button>
                        <div id="warning" class="btn btn-primary ladda-button mb-2" style="float: right;margin-left: 15px;">შეცდომაა! მიმართეთ მთავარ ადმინისტრატორს!</div>
                        <span id="timer" class="btn btn-primary ladda-button mb-2" style="float: right;margin-left: 15px;"></span>
                        <a href="{{ route('dashboard.backup', app()->getLocale()) }}" id="backup-view" class="backup-view btn btn-outline-primary default" style="float: right;"> განახლება</a>
                      </div>
                  </div>
                  @else
                      თქვენ არ გაქვთ უფლება შექმნათ  "ახალი სარეზერვო ასლი", გთხოვ მიმართოთ ადმინისტრატორს!
                  @endif
                    @can('dashboard.socials.index')
                        <table id="datatable-buttons3" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>ფაილის მდებარეობა</th>
                                    <th>შექმნის თარიღი</th>
                                    <th>ფაილის ზომა</th>
                                    <th>მოქმედება</th>
                                </tr>
                            </thead>
                             <tbody>
                              @foreach ($backups as $k => $b)
                                <tr>
                                  <td scope="row">{{ $k+1 }}</td>
                                  <td>{{ $b['disk'] }}</td>
                                  <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
                                  <td>{{ round((int)$b['file_size']/1048576, 2).' MB' }}</td>
                                  <td class="row-actions">
                                      @if ($b['download'])
                                      <a class="btn btn-primary btn-sm action-list" href="{{ langUrl('dashboard/backup/download/') }}?disk={{ $b['disk'] }}&path={{ urlencode($b['file_path']) }}&file_name={{ urlencode($b['file_name']) }}"><i class="la la-cloud-download"></i> გადმოწერა</a>
                                      @endif
                                      <a class="btn btn-danger btn-sm" data-button-type="delete" href="{{ langUrl('dashboard/backup/delete/'.$b['file_name']) }}?disk={{ $b['disk'] }}"><i class="la la-trash-o"></i> წაშლა</a>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                        </table>
                    @else
                        თქვენ არ გაქვთ უფლება ნახოთ ჩამონათვალი უფლებების, გთხოვ მიმართოთ ადმინისტრატორს!
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ URL::asset('/libs/datatables/datatables.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/jszip/jszip.min.js')}}"></script>
    <script src="{{ URL::asset('/libs/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{ URL::asset('/js/pages/datatables.init.js')}}"></script>
  <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery(document).ready(function($) {
        $('#backup-view').hide();
        $('#warning').hide();
        $('#timer').hide();
        
        var count=60;
        $("#create-new-backup-button").click(function(e) {
            e.preventDefault();
            $('#create-new-backup-button').hide();
            var counter = setInterval(timer, 1000);
            var create_backup_url = $(this).attr('href');
            $.ajax({
                url: create_backup_url,
                type: 'Post',
                success: function(result) {
                    if (result.indexOf('failed') >= 0) {
                        $('#warning').show();
                        console.log('warning');
                    }
                    else
                    {
                        $('#backup-view').show();
                        console.log('success');
                    }
                },
                error: function(result) {
                    $('#warning').show();
                    console.log('warning');
                }
            });
        });

        function timer()
        {
          $('#timer').show();
          count=count-1;
          if (count <= 0)
          {
             location.reload();
          }
          document.getElementById("timer").innerHTML=count + " წამი";
        }
        $("[data-button-type=delete]").click(function(e) {
            e.preventDefault();
            var delete_button = $(this);
            var delete_url = $(this).attr('href');
            if (confirm("გსურთ წაშალოთ მითითებული სარეზერვო ასლი!") == true) {
                $.ajax({
                    url: delete_url,
                    type: 'Post',
                    success: function(result) {
                        console.log('success');
                        delete_button.parentsUntil('tr').parent().remove();
                    },
                    error: function(result) {
                        $('#warning').show();
                        console.log('warning');
                    }
                });
            } else {
                console.log('info');
            }
          });
      });
    </script>
@stop