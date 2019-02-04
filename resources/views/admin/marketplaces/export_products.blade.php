@extends('admin.layouts.main')
@section('title')
    {!! trans('admin/common.export_products') !!}
@stop
@section('content')
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                <div class="page-icon">
                    <i class="icon-layers"></i>
                </div>
                <div class="page-title">
                    <h3>{!! trans('admin/common.export_products') !!}</h3>
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
        	{!! Form::open(['route' => 'marketplace.export_marketplace_products', 'id' => 'form', 'novalidate' => 'novalidate']) !!}
        		<input type="hidden" name="marketplace_id" value="{{$id}}" />
	            <div class="card custom-bdr">
	                <div class="table-responsive card-body">
	                    <table id="data-table" class="table table-hover table-striped">
	                        <thead class="text-uppercase">
	                            <tr>
	                                <th class="text-center">
	                                	<input type="checkbox" id="checkall" />
	                                	#{{ trans('admin/common.srno') }}
	                            	</th>
	                                <th>{{ trans('admin/products.name') }}</th>
	                                <th>{{ trans('admin/products.category') }}</th>
	                                <th>{{ trans('admin/common.created_at') }}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($products as $key=>$val)
	                        		<tr>
	                        			<td>
	                        				<input type="checkbox" name="product[]" value="{{$val->id}}" class="product" />
	                        				{{$key+1}}
	                    				</td>
	                        			<td>{{ucfirst($val->name)}}</td>
	                        			<td>{{$val->category_name}}</td>
	                        			<td>{{$val->created_at}}</td>
	                        		</tr>
	                        	@endforeach
	                        </tbody>
	                    </table>
	                    <button type="submit" class="btn btn-primary">Export</button>
	                </div>
	            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- END: .main-content -->
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
    		$('#checkall').click(function(){
    			$('input:checkbox').not(this).prop('checked', this.checked);
    		});
    		
            var table = $('#data-table').DataTable({
            	"columnDefs": [
	                { "orderable": false, "targets": [0,-1] },
	                { "searchable" : false, "targets" : [0,-1] },
	                { "targets": [0, -1, -2], "className": 'text-center' }
                ]
			});

        });
    </script>
@stop
