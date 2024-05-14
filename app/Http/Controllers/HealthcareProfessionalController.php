<?php

namespace App\Http\Controllers;

use App\Models\HealthcareProfessional;
use App\Http\Requests\StoreHealthcareProfessionalRequest;
use App\Http\Requests\UpdateHealthcareProfessionalRequest;
use App\Http\Traits\ApiHelpers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HealthcareProfessionalController extends Controller
{
    use ApiHelpers; // Using the apiHelpers Trait

    /**
     * Get all projects with their associated tasks and users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
         // Get query string parameters
        $searchKeyword = $request->input('q', ''); // search keyword, default to empty string
        $pageIndex = $request->input('pageIndex', 0); // page index, default to 0
        $pageSize = $request->input('pageSize', 3); // page size, default to 3
        $sortBy = $request->input('sortBy', 'name'); // attribute to sort, default to 'name'
        $sortDirection = $request->input('sortDirection', 'ASC'); // sort direction, default to 'ASC'

        // Query Healthcare Professional
        $query = HealthcareProfessional::query();

        // Apply search keyword filter
        if ($searchKeyword) {
            $query->where('name', 'like', '%' . $searchKeyword . '%');
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortDirection);

        // Get total count of Healthcare Professional
        $totalCount = $query->count();

        // Apply pagination
        $query->skip($pageIndex * $pageSize)->take($pageSize);

        // Fetch Healthcare Professional
        $healthcareProfessional = $query->get();

        // Return response

        return $this->onSuccess([
                'healthcareProfessional' => $healthcareProfessional,
                'totalCount' => $totalCount,
                'pageIndex' => $pageIndex,
                'pageSize' => $pageSize,
                'sortBy' => $sortBy,
                'sortDirection' => $sortDirection,
            ],
            'Healthcare Professional All Retrieved'
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HealthcareProfessional  $healthcareProfessional
     * @return \Illuminate\Http\Response
     */
    public function show(HealthcareProfessional $healthcareProfessional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HealthcareProfessional  $healthcareProfessional
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthcareProfessional $healthcareProfessional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Request $request
     * @param  \App\Models\HealthcareProfessional  $healthcareProfessional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthcareProfessional $healthcareProfessional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HealthcareProfessional  $healthcareProfessional
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthcareProfessional $healthcareProfessional)
    {
        //
    }
}
