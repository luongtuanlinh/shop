<?php

namespace Modules\News\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use Modules\Core\Models\Group;

class NewsPost extends Model
{
    protected $fillable = [
        'media', 'title', 'slug', 'thumbnail', 'images', 'summary', 'data', 'post_type', 'post_status', 'post_famous','post_view', 'status', 'published_at', 'author','created_id', 'updated_id', 'deleted_id'
    ];
    protected $table = "news_posts";
    
    const STATUS_DELETED = -1;
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    
    const POST_FAMOUS_ON = 1;
    const POST_FAMOUS_OFF = 0;
    
    public function cat()
    {
        return $this->belongsToMany('Modules\News\Models\NewsCategory', 'news_category_posts', 'post_id', 'category_id', 'news_category');
    }
    
    
    public function categories()
    {
        return $this->hasMany('Modules\News\Models\NewsCategoryPost', 'post_id');
    }
    
    
    public function tags()
    {
        return $this->belongsToMany('Modules\News\Models\NewsTag', 'news_tags_post', 'post_id', 'tag_id');
    }
    
    /**
     * @param $id
     * @param $data
     */
    public static function updateById($id, $data)
    {
        return self::where('id', $id)->update($data);
    }
    
    /**
     * Filter post
     * @param $id
     * @param string $title
     * @return $this|NewsPost
     */
    public function filterPost($id, $title = "")
    {
        $post = new NewsPost();
        if ($title == "") {
            $post = $post->join('news_category_posts', 'news_posts.id', '=', 'news_category_posts.post_id')
                ->where('category_id', '=', $id)
                ->select(['news_posts.id', 'title', 'thumbnail', 'summary', 'published_at'])
                ->orderBy('title', 'asc');
            
        } else {
            $post = $post->join('news_category_posts', 'news_posts.id', '=', 'news_category_posts.post_id')
                ->where('category_id', '=', $id)
                ->where('news_post.title', 'like', '%' . $title . '%')
                ->select(['news_post.id', 'title', 'thumbnail', 'summary', 'published_at'])
                ->orderBy('title', 'asc');
        }
        return $post;
    }
    
    /**
     * Get post relate
     * @param $post_id
     * @return array
     */
    public static function getPostRelate($post_id)
    {
        return self::select('id', 'title')
            ->whereRaw("id IN (SELECT post_id FROM news_category_posts WHERE category_id IN (SELECT category_id FROM news_category_posts WHERE post_id = {$post_id}))")
            ->where('id', '!=', $post_id)
            ->where('post_status',self::STATUS_PUBLISHED)->limit(2)->get()->toArray();
    }
    
    /**
     * Upload media
     * @return array
     */
    public static function uploadMedia()
    {
        $media = array();
        if (!empty($_POST['caption'])) {
            for ($i = 0; $i < count($_POST['caption']); $i++) {
                if (!empty($_FILES['file']['name'][$i])) {
                    $name = Auth::id() . "_" . md5(microtime()) . $_FILES['file']['name'][$i];
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], public_path('img/posts/') . $name)) {
                        // Resize image
                        if (strpos($_FILES['file']['type'][$i], 'image') !== false) {
                            $imageSize = getimagesize(public_path('img/posts/') . $name);
                            if($imageSize[0] > env('WIDTH_FILE_IMG')){
                                $thumnail = Image::make('img/posts/' . $name)->resize(env('WIDTH_FILE_IMG'), null, function ($constraint){
                                    $constraint->aspectRatio();
                                });
                                $thumnail->save('img/posts/' . $name);
                            }
                        }

                        $media[] = array(
                            'caption' => $_POST['caption'][$i],
                            'link' => $name
                        );
                    }
                }else if(!empty($_POST['link'][$i])){
                    $media[] = array(
                        'caption' => $_POST['caption'][$i],
                        'link' => $_POST['link'][$i]
                    );
                }

            }
        }
        return $media;
    }
    
    /**
     *
     * ASC view
     * @param $post_id
     * @param $user_id
     */
    public static function ascView($post_id, $user_id)
    {
        $user_id = $user_id->id;
        $checkview = NewsPostView::where('user_id',$user_id)->where('post_id',$post_id)->first();

        if (count($checkview) > 0) {
            $initial_time = Carbon::parse($checkview->created_at);
            $diff_time = Carbon::now()->diffInMinutes($initial_time);
            if ($diff_time > 60) {
                $post_save = NewsPost::find($post_id);
                $post_save['post_view'] += 1;
                $post_save->save();

                $data = NewsPostView::find($checkview->id);
                $data->created_at = date('Y-m-d H:i:s');
                $data->save();
            }
        } else {

            $post_save = NewsPost::find($post_id);
            $post_save['post_view'] += 1;
            $post_save->save();

            NewsPostView::create(array(
                'user_id' => $user_id,
                'post_id' => $post_id,
                'created_at' => date('Y-m-d H:i:s')
            ));
        }
    }
    
    /**
     * Get data url
     * @param $data
     * @return string
     */
    public static function getDataUrl($data)
    {
        if (!empty($data)) {
            return env("APP_URL") . "/img/posts/{$data}";
        }
        return env("APP_URL") . '/img/placeholder.jpg';
    }
    
    /**
     * Format media
     * @param $media
     * @return array
     */
    public static function formatMedia($media)
    {
        $data = "";
        $media = json_decode($media, true);
        foreach ($media as $row) {
            $data = "<p>".$row['caption']."</p>"."<p><img src=".self::getDataUrl($row['link'])."></p>";
        }
        return $data;
    }
    
    /**
     * Get cate permission
     *
     * @param $user_id
     * @return array
     */
    public static function getCatePermission($user_id){
        $listGroupOfUser = Group::whereIn('id', function ($q) use ($user_id) {
            return $q->select('group_id')->from('user_groups')->where('user_id', $user_id);
        })->select('category')->get();
    
        $listCatePermission = array();
        foreach ($listGroupOfUser as $item) {
            if ($item->category != null) {
                $listCatePermission = array_unique(array_merge($listCatePermission, \GuzzleHttp\json_decode($item->category, true)));
            }
        }

        $listCateCreated = NewsCategory::where('created_id',$user_id)->select('id')->get();
        $listCategoryCreated = array();
        foreach($listCateCreated as $item){
            $listCategoryCreated[]=$item->id;
        }

        $listCatePermission = array_unique(array_merge($listCatePermission, $listCategoryCreated));

        return implode(',',$listCatePermission);
    }
}
