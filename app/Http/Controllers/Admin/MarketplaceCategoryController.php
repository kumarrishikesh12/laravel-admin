<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MarketplaceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;

class MarketplaceCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MarketplaceCategory  $marketplaceCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MarketplaceCategory $marketplaceCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MarketplaceCategory  $marketplaceCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MarketplaceCategory $marketplaceCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MarketplaceCategory  $marketplaceCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MarketplaceCategory $marketplaceCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MarketplaceCategory  $marketplaceCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MarketplaceCategory $marketplaceCategory)
    {
        //
    }
}
