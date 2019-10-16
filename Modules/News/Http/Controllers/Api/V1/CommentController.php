<?php

namespace Modules\News\Http\Controllers\Api\V1;

use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redis;
use Mockery\Exception;
use Modules\Core\Http\Controllers\ApiController;
use Modules\Core\Models\User;
use Modules\News\Models\Comment;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Session;

class CommentController extends ApiController
{
    /**
     * Get list
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        try{
            if(empty($request->post_id)){
                return $this->errorResponse([],"Param post_id is empty");
            }
            $result = array(
                'total'=>0,
                'data'=>array()
            );
            $params = $request->all();
            $page = !empty($params['page']) ? (int)$params['page'] : 1;
            $page_size = !empty($params['page_size']) ? (int)$params['page_size'] : 10;

            $query = Comment::select(['news_comments.id', 'news_comments.content', 'news_comments.created_at', 'users.username', 'users.avatar'])
                ->join('users', 'users.id', '=', 'news_comments.created_id')
                ->where('post_id', $request->post_id)->orderBy('id', 'DESC');
            $result['total'] = $query->count();
            $data = $query->skip(($page - 1) * $page_size)->take($page_size)->get()->toArray();
            foreach ($data as $item){
                $item = (array)$item;
                $result['data'][] = array(
                    'id'=>(int)$item['id'],
                    'content'=>(string)$item['content'],
                    'created_at'=>(string)$item['created_at'],
                    'username'=>(string)$item['username'],
                    'avatar'=>User::getAvatarUrl($item['avatar'])
                );
            }
            
            return $this->successResponse($result,'Response Successfully');
       
        }
        catch(Exception $ex){
            return $this->errorResponse([],$ex->getMessage());
        }
    }
    
    /**
     * Add comment
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request){
        try{
            $input = $request->all();
            $validator = Validator::make($input,[
                'content'=>'required',
                'post_id'=>'required|integer'
            ],[
                'content.required'=>'Content is not allowed null',
                'post_id.required'=>'Post_id is not allowed null',
                'post_id.integer'=>'Post_id is integer'
            ]);
            if($validator->fails()){
                return $this->errorResponse($validator,'ERR');
            }
            $userInfo = User::getUserInfoFromAccessToken($request->header('AccessToken'));
            
            Comment::create(array(
                'post_id'=>$input['post_id'],
                'content'=>$input['content'],
                'created_id'=>!empty($userInfo->id) ? $userInfo->id : 0
            ));
            return $this->successResponse([],'Response Successfully');
        }
        catch(Exception $ex){
            return $this->errorResponse([],$ex->getMessage());
        }
    }
}