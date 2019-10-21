<?php

namespace Modules\Product\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\Category;
use Validator;
use Response;

class ProductController extends Controller
{
    protected $product;
    protected $category;

    public function __construct(Product $product, Category $category){
        $this->product = $product;
        $this->category = $category;
    }

    public function getProductForTopic(Request $request) {
        try{
            $user = User::where('phone','=',$request->phone)->first();
            if(!empty($user)){
                if(!Auth::attempt(['phone' => $request->phone, 'password' => $request->password, 'admin' => 0],$request->remember_me))
                    return $this->errorResponse([],'Số điện thoại hoặc mật khẩu không đúng');
                $user->token = $params['token'];
                $user->save();
                $user = $request->user();

                $tokenResult = $user->createToken('Personal Access Token');
                $token = $tokenResult->token;
                if ($request->remember_me)
                    $token->expires_at = Carbon::now()->addWeeks(1);
                $token->save();
                $agency = Agency::where('user_id', $user->id)->first();
                $result = [
                    'user_id' => $user->id,
                    'agency_name' => $agency->name,
                    'agency_child_count' => Agency::where('parent', $agency->id)->count(),
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                        $tokenResult->token->expires_at
                    )->toDateTimeString()
                ];
                return $this->successResponse(["user" => $result],'Response Successfully');
            }
            else{
                return $this->errorResponse([],'Số điện thoại không đúng ');
            }

        }catch (\Exception $ex){
            return $this->errorResponse([],$ex->getMessage());
        }
    }

    public function getDetaiProduct(Request $request) {
        try{
            $id = $request->id;
            
            if (!$id) {
                return response()->json(['success' => 500, 'Invalid id']);
            }
            $product = $this->product->getProductById($id);

            if ($product) {
                if ($product->cover_path != null) {
                    $product->cover_path = json_decode($product->cover_path);
                    $arr = array();
                    foreach ($product->cover_path as $key => $path) {
                        if ($path) {
                            $arr[$key] = url($path);
                        } else {
                            $arr[$key] = null;
                        }
                    }
                    $product->cover_path = $arr;
                }
               
                return Response::json([
                    'status' => 200,
                    'result' => $product
                ]);
            } else {
                return Response::json([
                    'status' => 404,
                    'message' => 'Không tìm thấy dữ liệu'
                ]);
            }
        } catch (\Exception $ex){
            return response()->json(['status' => 403, $ex->getMessage()]);
        }
    }

    public function getProductByCategory(Request $request) {
        // try{
            $cate_id = $request->id;
            if (!$cate_id) {
                return response()->json(['success' => 500, 'Invalid category id']);
            }
            $product = $this->product->getProductByCategory($cate_id);
            return $product;

            if ($product) {
                if ($product->cover_path != null) {
                    $product->cover_path = json_decode($product->cover_path);
                    $arr = array();
                    foreach ($product->cover_path as $key => $path) {
                        if ($path) {
                            $arr[$key] = url($path);
                        } else {
                            $arr[$key] = null;
                        }
                    }
                    $product->cover_path = $arr;
                }
                return Response::json(['status' => 200, 'result' => $product]);
            } else {
                return Response::json(['status' => 404, 'message' => 'Không tìm thấy dữ liệu']);
            }
        // } catch (\Exception $ex){
        //     return Response::json(['status' => 500, 'message' => 'Đã có lỗi xảy ra']);
        // }
    }
}
