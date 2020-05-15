<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealEstateRequest;
use App\RealEstate;

class RealEstateController extends Controller
{
    private $realEstate;

    public function __construct(RealEstate $realEstate)
    {
        $this->realEstate = $realEstate;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $realEstate = $this->realEstate->paginate('10');

        return response()->json($realEstate, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RealEstateRequest $request)
    {
        $data = $request->all();

        try {
            
            $realEstate = $this->realEstate->create($data);

            if(isset($data['categories']) && count($data['categories'])){

                $realEstate->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Property registered successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){

        try {
            
            $realEstate = $this->realEstate->findOrFail($id);

            return response()->json([

                'data' =>  $realEstate
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RealEstateRequest $request, $id)
    {
        $data = $request->all();

        try {
            
            $realEstate = $this->realEstate->findOrFail($id);
            $realEstate->update($data);

            if(isset($data['categories']) && count($data['categories'])){

                $realEstate->categories()->sync($data['categories']);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Property updated successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            
            $realEstate = $this->realEstate->findOrFail($id);
            $realEstate->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Property deleted successfully!'
                ]
            
            ], 200);

        } catch (\Exception $e) {
            
            $message = new ApiMessages($e->getMessage());

            return response()->json($e->getMessage(), 401);
        }
    }
}
