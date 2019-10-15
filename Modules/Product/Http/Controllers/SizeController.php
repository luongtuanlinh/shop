<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Size;
use Yajra\Datatables\Datatables;
use Google_Client;
use Google_Service_Drive;
use League\Csv\Reader;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('product::sizes/index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('product::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('product::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDataFromSheet() {

        $client = new Google_Client();
        putenv('GOOGLE_APPLICATION_CREDENTIALS=..path/to/your/json/file.json');
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google_Service_Drive::DRIVE);
        
        $driveService = new Google_Service_Drive($client);
        
       
        // Set File ID and get the contents of your Google Sheet
        $fileID = 'YOUR-FILE-ID';
        $response = $driveService->files->export($fileID, 'text/csv', array('alt' => 'media'));
        $content = $response->getBody()->getContents();
        
        // Create CSV from String
        $csv = Reader::createFromString($content, 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        
        // Create an Empty Array and Loop through the Records
        $newarray = array();
        foreach ($records as $value) {
        $newarray[] = $value;
        }
        
        dd($newarray);
    }

    public function get(Request $request)
    {
        $query = Size::whereNull('deleted_at');

        return Datatables::of($query)
                ->escapeColumns([])
                // ->addColumn('actions', function ($product) {
                //     $html = Product::genColumnHtml($product);
                //     return $html;
                // })
                // ->addColumn('cate_name', function ($product) {

                //     return $product->category->cate_name;
                // })
                // ->addColumn('source', function ($product) {

                //     return 'Trung quốc';
                // })
                // ->addColumn('cover_path', function ($product) {
                //     if ($product->cover_path != null) {
                //         $data = json_decode($product->cover_path);
                //         $html = '';
                //         foreach ($data as $key => $path) {
                //             $html .= '<img class="image-product" src="'.( ($path != null) ? url($path) : "") .'">';
                //         }
                //         return $html;
                //     }else{
                //         return '';
                //     }
                // })
                ->make(true);
    }
}
