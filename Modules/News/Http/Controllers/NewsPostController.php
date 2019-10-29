<?php

namespace Modules\News\Http\Controllers;

use App\Models\KMsg;
use function GuzzleHttp\Psr7\parse_query;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Core\Models\Group;
use Modules\Core\Models\UserGroup;
use Modules\News\Http\Requests\PostAddRequest;
use Modules\News\Http\Requests\PostEditRequest;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\NewsCategoryPost;
use Modules\News\Models\NewsPost;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;
use Modules\News\Repositories\Post\PostRepository;
use Intervention\Image\ImageManagerStatic as Image;
use Modules\News\Models\NewsTag;
use Modules\News\Models\NewsTagsPost;

class NewsPostController extends Controller
{
    protected $post;

    public function __construct(PostRepository $post)
    {
        $this->post = $post;

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * return to index post
     */
    public function index()
    {
        return view('news::news_post.index');
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function show(Request $request)
    {
        $data = NewsPost::query();
        return Datatables::of($data)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (($value == "") || ($value == -1) || ($value == null)) {

                    } else {
                        if ($key == 'title') {
                            $query->where('news_posts.title', 'LIKE', '%' . $value . '%');
                        } elseif ($key == 'published_at') {
                            $query->whereDate('published_at', Carbon::parse($value)->toDateTimeString());
                        } elseif ($key == 'post_status') {
                            $query->where('post_status', $value);
                        }elseif ($key == 'post_famous') {
                            if($value >=0 ){
                                $query->where('post_famous', $value);
                            }

                        } elseif ($key == 'tag') {
                            $query->whereHas('tags', function ($q) use ($value) {
                                $q->where('name', $value);
                            });
                        }
                    }
                }
            })
            ->escapeColumns([])
            ->editColumn('published_at', function ($post) {
//                Carbon::setLocale('en');
//                return Carbon::parse($post->published_at)->diffForHumans();
                return Carbon::parse($post->published_at)->format('d-m-Y');
            })
            ->editColumn('post_status', function ($post) {
                if ($post->post_status == NewsPost::STATUS_PUBLISHED) {
                    return "<label class='label label-success'>Xuất bản</label>";
                } else {
                    return "<label class='label label-warning'>Nháp</label>";
                }
            })
            ->editColumn('post_famous', function ($post) {
                if ($post->post_famous == NewsPost::POST_FAMOUS_ON) {
                    return "Nổi bật";
                } else {
                    return "Thường";
                }
            })
            ->editColumn('post_view', function ($post) {
                return number_format((int)$post->post_view, 0);
            })
            /*->editColumn('title', function ($post) {
                if(empty($post->show_title_post)){
                    $data = $post->title;
                }
                else{
                    if($post->show_title_post == 0){
                        $data = $post->title;
                    }
                    else{
                        $data = "";
                    }
                }
                return $data;
            })*/
            ->addColumn('show_title', function ($post) {
                $data = '';
                if(empty($post->show_title_post)){
                    $data .= "<input type='checkbox' onclick='return updateShowTitle(". $post->id .")' value='{$post->id}'>";
                }
                else{
                    if($post->show_title_post == 0){
                        $data .= "<input type='checkbox' onclick='return updateShowTitle(". $post->id .")' value='{$post->id}'>";
                    }
                    else{
                        $data .= "<input type='checkbox' checked onclick='return updateShowTitle(". $post->id .")' value='{$post->id}'>";
                    }
                }
                return $data;
            })
            /*->addColumn('tag', function ($post) {
                $data = '';
                foreach ($post->tags as $val) {
                    $data .= "<label class='label label-info'>" . $val->name . "</label>" . ' ';
                }
                return $data;
            })*/
            ->addColumn('actions', function ($post) {
                $html = view('news::includes.post.colum', ['module' => 'actions', 'column' => 'actions', 'post' => $post])->render();
                return $html;
            })
            ->make(true);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
//        $user_id = Auth::id();
//        $group = UserGroup::where('user_id', $user_id)->select('group_id')->first();
//        $listCatePermission = Group::where('id', $group['group_id'])->select('category')->first();
//        if (count($listCatePermission->category) == 0) {
//            $listCatePermission = [];
//        } else {
//            $listCatePermission = \GuzzleHttp\json_decode($listCatePermission->category);
//        }
//        $categories = NewsCategory::where('status', 1)->orderBy('position')->orderBy('name')->get();
        return view('news::news_post.create');
    }
    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(PostAddRequest $request)
    {

        // dd($request);
        try {
            $data = $request->only(['title', 'summary', 'data', 'post_type', 'post_status', 'slug', 'post_famous']);
            if ($request->slug == '') {
                $data['slug'] = str_slug($request->title);
            }

            if ($request->post_status == '') {
                $data['post_status'] = 0;
            }
            $data['published_at'] = Carbon::parse($request->published_at)->toDateTimeString();

            if ($request->hasFile('thumbnail')) {
                $img = $request->file('thumbnail')->getClientOriginalName();
                $request->thumbnail->move('img/posts', $img);
                $data['images'] = $img;
                $thumnail = Image::make('img/posts/' . $img)->resize(300, 200);

                $thumnail->save('img/posts/thumbnail_' . $img);
                $data['thumbnail'] = 'thumbnail_' . $img;
            }

            $media = NewsPost::uploadMedia();

            $data['media'] = json_encode($media);
            $data['created_id'] = Auth::id();
            // $data['author'] = Auth::user()->username;

            //Create Object Here
            $post = NewsPost::create($data);

            // Update post category
//            if (isset($request->category) && !empty($request->category)) {
//                // Update post category
//                if (isset($request->category)) {
//                    NewsCategoryPost::updateForPost($post->id, $request->category);
//                }
//            }

            return redirect(route('news.news_post.index'))->with('messages', trans('news::Controller.post_add'));
        } catch (\Exception $ex) {
            Log::error('[NewsPost] ' . $ex->getMessage());
            return redirect()->back()->withInput()->with('messages', 'Something wrong');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $post = NewsPost::find($id);
        return view('news::news_post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(PostEditRequest $request, $id)
    {
        try {
            $post = NewsPost::find($id);

            $request->only(['title', 'images', 'summary', 'data', 'post_type', 'slug', 'post_status', 'post_famous']);
            if ($request->slug == '') {
                $post['slug'] = str_slug($request->title);
            } else $post['slug'] = $request->slug;

            $post['title'] = $request->title;
            $post['summary'] = $request->summary;
            $post['data'] = $request->data;
            $post['post_type'] = $request->post_type;
            $post['post_status'] = $request->post_status;
            $post['post_famous'] = $request->post_famous;
            $post['published_at'] = Carbon::parse($request->published_at)->toDateTimeString();

            //Image
            $media = NewsPost::uploadMedia();

            $post['media'] = json_encode($media);

            if ($request->hasFile('thumbnail')) {
                $img = $request->file('thumbnail')->getClientOriginalName();
                if ($img != $post['images']) {
                    $request->file('thumbnail')->move('img/posts', $img);
                    $post['images'] = $img;
                    $thumbnail = Image::make('img/posts/' . $img)->resize(300, 200);

                    $thumbnail->save('img/posts/thumbnail_' . $img);
                    $post['thumbnail'] = 'thumbnail_' . $img;
                }
            }

            $post->save();

            return redirect()->route('news.news_post.index')->with('messages', trans('news::Controller.post_edit'));
        } catch (\Exception $ex) {
            Log::error('[NewsPost] ' . $ex->getMessage());
            return redirect()->back()->withInput()->with('message', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $obj = NewsPost::where("id", $id)->first();
        if ($obj) {
            $obj->post_status = NewsPost::STATUS_DELETED;
            $obj->deleted_at = date('Y-m-d H:i:s');
            $obj->deleted_id = Auth::id();
            $obj->save();

            // Delete new category post
            DB::table('news_category_posts')->where('post_id', $id)->delete();

            // Delete new tag post
            DB::table('news_tags_post')->where('post_id', $id)->delete();

            return redirect(route('news.news_post.index'))->with('messages', trans('news::Controller.post_delete'));
        } else {
            return Redirect::route('news.news_post.index')->withErrors([trans('news::Controller.post_delete_fail')]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateShowTitle(Request $request){
        if(!empty($request->id)){
            $detailNewPost = NewsPost::where('id', $request->id)->first();
            if(!empty($detailNewPost)){
                if(empty($detailNewPost->show_title_post)){
                    NewsPost::where('id', $request->id)->update([
                        'show_title_post' => 1
                    ]);
                }
                else{
                    if($detailNewPost->show_title_post == 1){
                        NewsPost::where('id', $request->id)->update([
                            'show_title_post' => 0
                        ]);
                    }else{
                        NewsPost::where('id', $request->id)->update([
                            'show_title_post' => 1
                        ]);
                    }
                }

                $result = new KMsg();
                $result->result = KMsg::RESULT_SUCCESS;
                $result->message = "Cập nhật trạng thái ẩn tiêu đề bài viết thành công";
                return \response()->json($result);
            }
            else{
                $result = new KMsg();
                $result->result = KMsg::RESULT_ERROR;
                $result->message = "Không tồn tại ID";
                return \response()->json($result);
            }
        }
        else{
            $result = new KMsg();
            $result->result = KMsg::RESULT_ERROR;
            $result->message = "Không tồn tại ID";
            return \response()->json($result);
        }
    }

}
