@if($column == 'actions')
    <a onclick="return regionHelper.edit({{$region->id}});" class="btn btn-xs btn-primary"><i class="fa fa-pencil"> {{trans('news::column.edit')}}</i></a>
    <a onclick="return checkDeleteRegion.delete({{$region->id}})" class="btn btn-xs btn-danger"><i class="fa fa-trash"> {{trans('news::column.delete')}}</i></a>
@endif