<?php

namespace Modules\News\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\News\Http\Requests\ApiDetailNewsRequest;
use Modules\News\Models\Block;
use App\Http\Controllers\Controller;
use Modules\Core\Http\Controllers\ApiController;

class BlocksController extends ApiController
{

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * filter by Key
     */

    public function Block(Request $request){


            $params = $request->all();

            if(!empty($params['key'])){
                $block =new Block();
                $block=$block->where('key','=',$params['key'])->first();

                return $this->successResponse($block, 'Response Successfully');
            }
            else return $this->errorResponse(0,'\'key\'field is required');
    }

}