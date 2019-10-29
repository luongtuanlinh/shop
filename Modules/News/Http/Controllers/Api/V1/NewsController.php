<?php

namespace Modules\News\Http\Controllers\Api\V1;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;
use Modules\Core\Models\UserGroup;
use Modules\News\Http\Requests\ApiDetailNewsRequest;
use Modules\News\Http\Requests\ApiListNewsRequest;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\NewsCategoryPost;
use Modules\News\Models\NewsPost;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Session;

class NewsController extends ApiController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * return list categories depend on request params
     */
    public function listCategories(Request $request)
    {
        try {
            $params = $request->all();
            
            /**
             * If id!=0 -> return category by id
             * Else !isset id or id ==0 => return all category
             */
            
            //Page and perPape
            
            $page = !empty($params['page']) ? (int)$params['page'] : 1;
            $page_size = !empty($params['page_size']) ? (int)$params['page_size'] : 10;
            
            $level = empty($params['level']) ? 1 : $params['level'];
            
            $query = NewsCategory::where('status', '=', 1)->select(['id', 'parent_id', 'status', 'region_id', 'name', 'slug', 'position', 'cover', 'summary', 'updated_at', 'created_at'])->orderBy('position')->orderBy('name');
            $count = $query->count();
            if ((($page - 1) * $page_size) < $count) {
                $query = $query->skip(($page - 1) * $page_size)->take($page_size);
                if (isset($params['id'])) {
                    if ($params['id'] != 0) {
                        $categories = $query->where('id', '=', $params['id'])->get();
                        foreach ($categories as $item) {
                            if ($level > 1) {
                                $item['children'] = $this->filterCategory($item->id, $level - 1);
                            }
                        }
                    } else if ($params['id'] == 0) {
                        $categories = $query->where('parent_id', '=', $params['id'])->get();
                        foreach ($categories as $item) {
                            if ($level > 1) {
                                $item['children'] = $this->filterCategory($item->id, $level - 1);
                            }
                        }
                    }
                    foreach ($categories as $category) {
                        if (!empty($category['cover'])) {
                            $category['cover'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http") . "://" . @$_SERVER['HTTP_HOST'] . '/img/category/' . $category['cover'];
                        }
                    }
                    
                } else $categories = [];
                
                return $this->successResponse(['categories' => $categories], 'Response Successfully');
            } else {
                return $this->errorResponse([], 'Not enough record in page ' . $page . ' with ' . $page_size . ' records per page');
            }
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage());
        }
    }
    
    
    /**
     * Filter category
     * @param $parent_id
     * @param int $level
     * @param int $count
     * @return \Illuminate\Support\Collection
     */
    public function filterCategory($parent_id, $level = 1, $count = 1)
    {
        $categories = NewsCategory::where('parent_id', '=', $parent_id)
            ->where('status', '=', 1)->orderBy('position')->orderBy('name')->get();
        foreach ($categories as $item) {
            if ($count < $level) {
                $item['children'] = $this->filterCategory($item->id, $level, $count + 1);
            }
            $count = 1;
        }
        return $categories;
    }
    
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * return Posts filter by category_id and title
     */
    public function listPosts(Request $request)
    {
        try {
            //Params
            $params = $request->all();
            $page = isset($params['page']) ? (int)$params['page'] : 1;
            $pageSize = isset($params['page_size']) ? (int)$params['page_size'] : 15;
            
            //Sortby
            $sortBy = isset($params['sort_by']) && ($params['sort_by'] == "post_view") ? $params['sort_by'] : "published_at";
            $sortType = isset($params['sort_type']) && ($params['sort_type'] == "asc") ? $params['sort_type'] : "desc";
            
            
            $result = array();
            $query = NewsPost::select(DB::raw('id, title, slug, thumbnail, images, summary, post_type, post_view,show_title_post, data, media, created_id, published_at, created_at, (SELECT count(*) as comment_num FROM news_comments WHERE news_comments.post_id = news_posts.id LIMIT 1) as comment_num'));
            
            if (!empty($params['category_id'])) {
                $category_id = $params['category_id'];
                $query = $query->whereIn('id', function ($q) use ($category_id) {
                    $q->select('post_id')
                        ->from('news_category_posts')
                        ->where('category_id', $category_id);
                });
            }
    
            if (!empty($params['type']) && $params['type'] = 'famous') {
                $query = $query->where('post_famous', NewsPost::POST_FAMOUS_ON);
            }
            if (!empty($params['title'])) {
                $query = $query->where('title', 'LIKE', "%{$params['title']}%");
            }
            $query = $query->where('status', '>=', 0)->where('post_status', '=', NewsPost::STATUS_PUBLISHED);
            $count = $query->count();
            if ($count > (($page - 1) * $pageSize)) {
                $posts = $query->orderBy($sortBy, $sortType)->skip(($page - 1) * $pageSize)->take($pageSize)->get();
                foreach ($posts as $item) {
                    
                    if (!empty($item['thumbnail'])) {
                        $item['thumbnail'] = NewsPost::getDataUrl($item['thumbnail']);
                    }
                    if (!empty($item['images'])) {
                        $item['images'] = NewsPost::getDataUrl($item['images']);
                    }
                    if ($item['post_type'] == 'news') {
                        unset($item['data'], $item['media']);
                    } else {
                        $item['data'] = \GuzzleHttp\json_decode($item['media']);
                        unset($item['media']);
                    }
                    if(!empty($item["show_title_post"]) && $item["show_title_post"] == 1){
                        $item["title"] = "";
                    }
                    $result[] = $item;
                }
                return $this->successResponse(['posts' => $result], 'Response Successfully');
            } else {
                return $this->errorResponse([], 'Not enough record in page ' . $page . ' with ' . $pageSize . ' records per page');
            }
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage());
        }
    }
    
    /**
     * @param ApiDetailNewsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailPost(ApiDetailNewsRequest $request)
    {
        
        $post = NewsPost::select(['id', 'title', 'slug', 'post_view', 'post_type', 'data', 'images', 'thumbnail', 'summary', 'published_at', 'post_status', 'media', 'author','created_id', 'updated_at', 'created_at'])->find($request->post_id);
        
        if ($post) {
            if($post->post_status != NewsPost::STATUS_PUBLISHED){
                return $this->errorResponse([], 'POST IS NOT PUBLISH');
            }
            //Count view
            $user_id = User::where('access_token', $request->header('AccessToken'))->select('id')->first();
            if (!empty($user_id)) {
    
                if (!empty($post['thumbnail'])) {
                    $post['thumbnail'] = NewsPost::getDataUrl($post['thumbnail']);
                }
                if (!empty($post['images'])) {
                    $post['images'] = NewsPost::getDataUrl($post['images']);
                }
    
                if ($post['post_type'] != "news") {
                    $post['data'] = NewsPost::formatMedia($post['media']);
                }
    
                //Post relate
                $post['relate_post'] = NewsPost::getPostRelate($request->post_id);
                
                NewsPost::ascView($request->post_id, $user_id);

                return $this->successResponse(['post' => $post]);

            } else {
                return $this->errorResponse([], 'Access token was wrong');
            }
            
        } else {
            return $this->errorResponse([], trans('news::api.post_not_found'));
        }
    }
    
    /**
     * Detail post v2
     * @param ApiDetailNewsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function detailPostV2(ApiDetailNewsRequest $request)
    {
        
        $post = NewsPost::select(['id', 'title', 'slug', 'post_view', 'post_type', 'data', 'images', 'thumbnail', 'summary', 'published_at', 'post_status', 'media', 'author','created_id', 'updated_at', 'created_at'])->find($request->post_id);
        
        if ($post) {
            if($post->post_status != NewsPost::STATUS_PUBLISHED){
                return $this->errorResponse([], 'POST IS NOT PUBLISH');
            }
            //Count view
            $user_id = User::where('access_token', $request->header('AccessToken'))->select('id')->first();
            if (!empty($user_id)) {
                
                if (!empty($post['thumbnail'])) {
                    $post['thumbnail'] = NewsPost::getDataUrl($post['thumbnail']);
                }
                if (!empty($post['images'])) {
                    $post['images'] = NewsPost::getDataUrl($post['images']);
                }
                
                $post['data'] = (string)$post['data'];
                
                //Post relate
                $post['relate_post'] = NewsPost::getPostRelate($request->post_id);
                
                NewsPost::ascView($request->post_id, $user_id);
                
                return $this->successResponse(['post' => $post]);
                
            } else {
                return $this->errorResponse([], 'Access token was wrong');
            }
            
        } else {
            return $this->errorResponse([], trans('news::api.post_not_found'));
        }
    }
    
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * return root category_id for each category of specific post_id
     */
    public function rootCategory(Request $request)
    {
        try {
            $params = $request->all();
            if (!empty($params['post_id'])) {
                $post_id = $params['post_id'];
                $cat_array = NewsCategoryPost::select('category_id')->where('post_id', '=', $post_id)->get()->toArray();
                $result = array();
                foreach ($cat_array as $item) {
                    $parent = NewsCategory::select(['parent_id', 'id'])->where('id', $item['category_id'])->first();
                    while ($parent['parent_id'] != 0) {
                        $parent = NewsCategory::select(['parent_id', 'id'])->where('id', $parent['parent_id'])->first();
                    }
                    $flag = 1;
                    foreach ($result as $val) {
                        if ($val == $parent['id']) {
                            $flag = 0;
                            break;
                        }
                    }
                    if ($flag == 1) {
                        $result[] = $parent['id'];
                    }
                }
                return $this->successResponse($result, 'Response successfully');
            } else {
                return $this->errorResponse([], 'Error param post_id');
            }
            
        } catch (Exception $ex) {
            return $this->errorResponse([], $ex->getMessage());
        }
    }
    /**
     * @param id brand
     * @return \Illuminate\Http\JsonResponse
     * return Brand info
     */
    public function getBrandDetai($id){
        if($id){
            $filename = 'config.json';
            $data = json_decode(file_get_contents($filename));
            $brandDetail = $data->result[$id];
            return $this->successResponse(['brandDetail' => $brandDetail]);
        }
        else {
            return $this->errorResponse([], 'Error id');
        }
    }
    /**
     * @param
     * @return \Illuminate\Http\JsonResponse
     * return Brand list
     */
    public function getListBrand(){
        $filename = 'config.json';
        $listBrand = json_decode(file_get_contents($filename));
        return $this->successResponse(['listBrand' => $listBrand]);
    }
}