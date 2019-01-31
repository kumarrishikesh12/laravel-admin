@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/admin.admins') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-users"></i>
                </div>

                <div class="page-title">
                    <h3>{!! trans('admin/admin.admins') !!}</h3>
                </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                <div class="daterange-container">
                    <a data-toggle="tooltip" title="{{ trans('admin/common.create') }}" class="btn btn-primary btn-sm btn-create" href="{{ url('admin/sub_admin/create') }}"><i class="icon-plus"></i> {{ trans('admin/admin.add_admin') }}</a>
                    <!-- <button type="button" id="reset_filter" class="btn btn-info btn-sm"><span class="icon-spinner9"></span> {{ trans('admin/common.reset_filter') }}</button> -->
                </div>
            </div>
        </div>
    </div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
    @include('admin.layouts.include.notifications')
    <!-- Row start -->
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="card custom-bdr">
                <div class="table-responsive card-body">
                    <table id="data-table" class="table table-hover table-striped">
                        <thead class="text-uppercase">
                            <tr>
                                <th class="text-center">#{{ trans('admin/common.srno') }}</th>
                                <th>{{ trans('admin/admin.name') }}</th>
                                <th>{{ trans('admin/admin.username') }}</th>
                                <th>{{ trans('admin/admin.email') }}</th>
                                <th>{{ trans('admin/common.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/common.status') }}</th>
                                <th class="text-center">{{ trans('admin/common.options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($admin as $key=>$val)
                        		<tr>
                        			<td>{{$key+1}}</td>
                        			<td>{{ucfirst($val->name)}}</td>
                                    <td>{{$val->username}}</td>
                        			<td>{{$val->email}}</td>
                        			<td>{{$val->created_at}}</td>
                        			<td>
                        				@if($val->status==1)
											<a href="javascript:void(0);" data-href="{{ url('admin/sub_admin/status') }}" data-status="0" data-id="{{ $val->id }}" class="btn btn-success btn-sm btn-status"><i class="icon-tick"></i> Active</a>
										@else
											<a href="javascript:void(0);" data-href="{{ url('admin/sub_admin/status') }}" data-status="1" data-id="{{ $val->id }}" class="btn btn-warning btn-sm btn-status"><i class="icon-warning2"></i> Inactive</a>
										@endif
                        			</td>
                        			<td>
                        				<a href="{{ url('admin/sub_admin/'.$val->id.'/edit') }}" class="btn btn-primary btn-sm btn-edit"><i class="icon-pencil"></i> Edit</a>
										<a href="javascript:void(0);" data-href="{{ url('admin/sub_admin/destroy') }}" data-id="{{ $val->id }}"  class="btn btn-danger btn-sm btn-delete"><i class="icon-trash2"></i> Delete</a>
                                       
                        			</td>
                        		</tr>
                        	@endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: .main-content -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
<!-- Modal -->
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $(".modal").on("show.bs.modal", function(e) {
                var link = $(e.relatedTarget);
                var id = link.find('.btn-view').attr("data-id");
                var target = link.find('.btn-view').attr("data-target");
                target = target!=''?target+'/':'';
                var url = "{{ url('admin/sub_admin') }}/"+target+id;
                $(this).find(".modal-content").load(url);
            });
            $(".modal").on("shown.bs.modal", function(e) {
                $('[data-toggle="tooltip"]').tooltip();
                if(typeof oldIE === 'undefined' && Object.keys)
                hljs.initHighlighting();
                baguetteBox.run('.baguetteBoxOne');
                baguetteBox.run('.baguetteBoxTwo');
                baguetteBox.run('.baguetteBoxThree', {
                    animation: 'fadeIn',
                });
                baguetteBox.run('.baguetteBoxFour', {
                    buttons: false
                });
                baguetteBox.run('.baguetteBoxFive');
            });

            $('#data-table').DataTable({
            	"columnDefs": [
	                { "orderable": false, "targets": [-1] },
	                { "searchable" : false, "targets" : [0,-1] },
	                { "targets": [0, -1, -2], "className": 'text-center' }
                ]
			});

            /*var table = $('#data-table').on( 'init.dt', function () {     
                    var jsn = JSON.parse('<?php //echo json_encode($filters); ?>');
                    $("#data-table").parents("div.row:first").before('<div class="row"><div id="filtercontent"></div></div>');
                    $.each( jsn, function(i, item){
                        var filter = table.state().columns[i].search.search!=undefined?table.state().columns[i].search.search.replace(/^\^+|\$+$/gm,''):'';
                        var select = $('<select id="filer_'+i+'" class="form-control form-control-sm selectpicker" data-live-search="true"><option value="" data-icon="icon-eye">{{ trans("admin/common.all") }}</option></select>')
                            .insertBefore('#filtercontent')
                            .on( 'change', function () {
                                var val = $(this).val();
                                table.column( i )
                                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
                                    .draw();
                            } );
                        $.each( item.data, function(j, val){
                            var sel = filter!=''&&filter==val['key']?'selected="selected"':'';
                            select.append( '<option '+sel+' value="'+ val['key'] +'" data-icon="'+ val['icon'] +'">'+val['value']+'</option>' );
                        });
                        $('#filer_'+i).wrapAll('<div class="col-sm-2 form-group"></div>');
                        $('<label>'+item.label+'</label>').insertBefore('#filer_'+i);
                        $('.selectpicker').selectpicker('refresh');
                    });
                    $('#data-table_wrapper').removeClass('form-inline');     
                }).DataTable({
                    "processing": true,
                    "serverSide": true,
                    "stateSave": true,
                    "bStateSave": true,
                    "oLanguage": {
                        "sProcessing": '<div class="datatable-loading-wrapper"><div class="datatable-loader"></div></div>',
                    },
                    "processing" : true,
                    "columnDefs": [
                        { "orderable": false, "targets": [-1] },
                        { "searchable" : false, "targets" : [0,-1] },
                        { "targets": [0, -1, -2], "className": 'text-center' },
                        {
                            "targets": 0,
                            "render": function(data, type, row, meta) {
                                meta['settings']['json']['input']['recordsFiltered'] = meta['settings']['json']['input']['recordsFiltered']==undefined?meta['settings']['json']['recordsFiltered']:parseInt(meta['settings']['json']['input']['recordsFiltered']);
                                var index = parseInt(meta['row']);
                                var no = meta['settings']['json']['input']['order'][0]['column']!=undefined&&meta['settings']['json']['input']['order'][0]['column']==0&&meta['settings']['json']['input']['order'][0]['dir']=='desc'?(parseInt(meta['settings']['json']['input']['recordsFiltered'])-parseInt(meta['settings']['json']['input']['start'])-index):(parseInt(meta['settings']['json']['input']['start'])+index+1);
                                $('td', row).eq(0).html(no);
                                return no;
                            }
                        }
                    ],
                    "order": [[ 1, "asc" ]],
                    "ajax": {
                        "url": "{{ url('admin/users/data') }}",
                        "type": 'POST',
                        "headers": {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        "data": {
                            "action": "view"
                        }
                    },
                    "columns": [
                        { "data": "id" },
                        { "data": "title" },
                        { "data": "type" },
                        { "data": "city" },
                        { "data": "created_at" },
                        { "data": "likes" },
                        { "data": "status" },
                        { "data": "id" },
                    ],
                    "createdRow": function ( row, data, index ) {
                        data['created_at'] = data['created_at'].split(" ");
                        var date = data['created_at'][0].split("-").reverse().join("-");
                        
                        $('td', row).eq(4).html(date+' '+data['created_at'][1]);
                        var options = '';
                        options += `<button type="button" data-toggle="tooltip" title="{{ trans('admin/users.likes') }}" class="btn btn-success btn-sm" data-id="`+data['id']+`" value="0"><i class="icon-thumb_up"></i> `+data['likes']+`</button> `;
                        options += `<button type="button" data-toggle="tooltip" title="{{ trans('admin/users.dislikes') }}" class="btn btn-warning btn-sm" data-id="`+data['id']+`" value="0"><i class="icon-thumb_down"></i> `+data['dislikes']+`</button> `;
                        options += `<span data-toggle="modal" data-target="#commentModal"><button type="button" data-toggle="tooltip" title="{{ trans('admin/users.comments') }}" class="btn btn-primary btn-sm btn-view" data-id="`+data['id']+`" data-target="comments"><i class="icon-mode_comment"></i> `+data['comments']+`</button></span> `;
                        options += `<span data-toggle="modal" data-target="#reportModal"><button type="button" data-toggle="tooltip" title="{{ trans('admin/users.reports') }}" class="btn btn-danger btn-sm btn-view" data-id="`+data['id']+`" data-target="reports"><i class="icon-warning4"></i> `+data['reports']+`</button></span> `;
                        options += `<span data-toggle="modal" data-target="#voteModal"><button type="button" data-toggle="tooltip" title="{{ trans('admin/users.votes') }}" class="btn btn-primary btn-sm btn-view" data-id="`+data['id']+`" data-target="votes"><i class="icon-layers2"></i> `+data['votes']+`</button></span> `;

                        $('td', row).eq(5).html(options);
                        var options = '';
                        if(data['status']=='1'){
                            options += `<button type="button" data-toggle="tooltip" title="{{ trans('admin/common.active') }}" class="btn btn-success btn-sm btn-status" data-id="`+data['id']+`" value="0"><i class="icon-check2"></i></button> `;
                        }
                        else{
                            options += `<button type="button" data-toggle="tooltip" title="{{ trans('admin/common.inactive') }}" class="btn btn-warning btn-sm btn-status" data-id="`+data['id']+`" value="1"><i class="icon-cross3"></i></button> `;
                        }
                        $('td', row).eq(-2).html(options);
                        var options = '';
                        var url = "{{ url('admin/users') }}/";
                        url += data['id']+'/edit';
                        options += `<a data-toggle="tooltip" title="{{ trans('admin/common.edit') }}" class="btn btn-primary btn-sm btn-edit" href="`+url+`"><i class="icon-pencil2"></i></a> `;

                        options += `<span data-toggle="modal" data-target="#myModal"><button type="button" data-toggle="tooltip" title="{{ trans('admin/common.view') }}" class="btn btn-primary btn-sm btn-view" data-id="`+data['id']+`" data-target=""><i class="icon-eye"></i></button></span> <button type="button" data-toggle="tooltip" title="{{ trans('admin/common.delete') }}" class="btn btn-danger btn-sm btn-delete" data-id="`+data['id']+`"><i class="icon-trash2"></i></button>`;
                        $('td', row).eq(-1).html(options);
                    },
                    "drawCallback": function(settings) {
                        $('[data-toggle="tooltip"]').tooltip();
                        $('.dataTables_length .selectpicker').attr('data-live-search','true').selectpicker('refresh');
                    }
                });
            
            $('#reset_filter').click(function(){
                table.state.clear();
                window.location.reload();
            });*/

            $(document).delegate('.btn-delete', 'click', function() { 
                var element = $(this);
                bootbox.confirm({
                    backdrop: true,
                    title: "{{ trans('admin/common.are_you_sure') }}",
                    message: "{{ trans('admin/common.delete_record_this_can_not_undone') }}",
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> {{ trans("admin/common.cancel") }}',
                            className: 'btn-light btn-sm'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> {{ trans("admin/common.confirm") }}',
                            className: 'btn-warning btn-sm'
                        }
                    },
                    callback: function (result) {
                        if(result===true){
                            var id = $(element).attr('data-id');
                            var parent = $(element).parent().parent();
                            $.ajax({
                                "url": "{{ url('admin/sub_admin/destroy') }}",
                                "type": "POST",
                                "headers": {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                "data": {
                                    "id": id,
                                    "_method": 'DELETE',
                                },
                                cache: false,
                                success: function(data){
                                    if(data['status']==1){
                                        window.location.reload();
                                    }
                                    else{
                                    }
                                },
                                error: function (request, status, error) {
                                }
                            });
                        }
                    }
                });
            });
            
            $(document).delegate('.btn-status', 'click', function() { 
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');
                var button = $(this);
                $(button).tooltip("hide");
                $.ajax({
                    "url": "{{ url('admin/sub_admin/update') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    "data": {
                        "id": id,
                        "status": status,
                        "_method": 'PUT',
                    },
                    cache: false,
                    success: function(data){
                        if(data['status']==true){
                            $(button).val(Math.abs(status-1));
                        	window.location.reload();
                        }
                        else{
                        }
                    },
                    error: function (request, status, error) {
                        console.log(error);
                    }
                });
                
            });
            
        });
    </script>
@stop
