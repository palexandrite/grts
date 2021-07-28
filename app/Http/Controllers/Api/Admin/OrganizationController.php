<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\OrganizationRequest;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the org resource.
     */
    public function index()
    {
        /**
         * @return Illuminate\Pagination\LengthAwarePaginator
         */
        $pagination = Organization::paginate(15);

        return response()->json([
            'items' => $pagination->getCollection()->map(function($item) {
                return $item->getAttributesForTable();
            }),
            'currentPage' => $pagination->currentPage(),
            'lastPage' => $pagination->lastPage(),
            'attrnames' => $this->getAttributesAsKeys($pagination->getCollection())
        ]);
    }

    /**
     * Save a new org
     */
    public function store(OrganizationRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $organization = Organization::create([
            'name' => $validated['name'],
            'status' => Organization::setStatus($validated['status']),
        ]);

        if (! $organization) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = ['serverError' => 'Something went wrong on my side. Mr. Server'];
        } else {
            $responseCode = Response::HTTP_OK;
            $response = ['success' => 'Passed data were successfully saved'];
        }

        return response()->json($response, $responseCode);
    }

    /**
     * Show the specified org
     */
    public function edit(Request $request)
    {
        $id = $request->post('item');
        $org = Organization::find($id);

        return response()->json($org);
    }

    /**
     * Update the specified org
     */
    public function update(OrganizationRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $response = [];

        $updateableFields = [
            'name' => $validated['name'],
            'status' => Organization::setStatus($validated['status']),
        ];

        if (!empty($validated['password'])) {
            $updateableFields['password'] = Hash::make($validated['password']);
        }

        $org = Organization::where(['id' => $validated['id']])->update($updateableFields);

        if (! $org) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = ['serverError' => 'Something went wrong on my side. Mr. Server'];
        } else {
            $responseCode = Response::HTTP_OK;
            $response = ['success' => 'Passed data were successfully saved'];
        }

        return response()->json($response, $responseCode);
    }

    /**
     * Remove the specified organization from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $deleted = Organization::destroy($id);

        $response = [];

        if ($deleted) {

            /**
             * @return Illuminate\Pagination\LengthAwarePaginator
             */
            $response['pagination'] = Organization::paginate(15);
            
            $response['success'] = 'It is successfully deleted';

        } else {
            $response['error'] = 'None of the items was deleted';
        }

        return response()->json($response);
    }

    /**
     * Find a searchable getting from an organization
     */
    public function search(Request $request)
    {
        $searchable = $request->input('search');
        $org = Organization::where('name', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($org);
    }

    /**
     * Select a first item from the collection and retrieve all attribute names of the model
     */
    private function getAttributesAsKeys(Collection $collection)
    {
        $model = $collection->first();
        return $model ? $model->getAttributeNamesForTable() : null;
        // return $model->getAttributeNames();
    }
}
