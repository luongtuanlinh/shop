@if($column == 'actions')
    <a onclick="BlockHelper.detail('{{$block->id}}')" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-eye-open"></i> {{trans('news::column.view_content')}}</a>
    <a href="{{route('news.news_block.edit',$block->id)}}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-edit"></i> {{trans('news::column.edit')}}</a>
    <a href="{{route('news.news_block.delete',$block->id)}}" onclick = "if (! confirm('{{trans('news::column.confirm')}}')) { return false; }" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> {{trans('news::column.delete')}}</a>
@endif