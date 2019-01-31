<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $marketplace->name }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="table-responsive modal-body gutters">
    @if($marketplace->image!='')
    <div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="baguetteBoxThree gallery">
                <div class="row gutters">
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-6">
                        <a href="{{ $marketplace->image }}" data-toggle="tooltip" title="{{ trans('admin/polls.image') }}" class="effects">
                            <img src="{{ $marketplace->image }}" class="img-thumbnail" style="width: 200px; height: 150px;" />
                            <div class="overlay">
                                <span class="expand">+</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <table class="table table-hover table-striped">
        <tbody>
            <tr>
                <td>{{ trans('admin/marketplaces.name') }}</td>
                <td>{{ $marketplace->name }}</td>
            </tr>
            <tr>
                <td>{{ trans('admin/common.status') }}</td>
                <td>
                    @if($marketplace->status==1)
                        <span class="badge badge-success"><span class="icon-done_all"></span> {{ trans('admin/common.active') }}</span>
                    @else
                        <span class="badge badge-warning"><span class="icon-done_all"></span> {{ trans('admin/common.inactive') }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>{{ trans('admin/common.created_at') }}</td>
                <td>{{ $marketplace->created_at }}</td>
            </tr>
            <tr>
                <td>{{ trans('admin/common.updated_at') }}</td>
                <td>{{ $marketplace->updated_at }}</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
</div>