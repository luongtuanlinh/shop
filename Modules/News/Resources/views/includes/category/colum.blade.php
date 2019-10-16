@if($column == 'actions')
    <a href="{{ route('news.news_category.edit', $category->id)}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"> {{trans('news::column.edit')}}</i></a>
    <a href="{{route('news.news_category.delete',$category->id)}}" onclick="return confirm('{{trans('news::column.confirm')}}')" class="btn btn-xs btn-danger"><i class="fa fa-trash"> {{trans('news::column.delete')}}</i></a>
@endif
