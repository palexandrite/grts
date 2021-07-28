<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\{
    DB,
    Hash
};
use App\Http\Requests\ReceiverRequest;
use App\Models\{
    BankAccount,
    CreditCard,
    Receiver,
    ReceiverData
};

class ReceiverController extends Controller
{
    /**
     * Display a listing of the service provider resource.
     */
    public function index()
    {
        /**
         * @return Illuminate\Pagination\LengthAwarePaginator
         */
        $pagination = Receiver::paginate(15);

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
     * Save a new receiver
     */
    public function store(ReceiverRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $validatedString = '';

        foreach ($validated as $key => $value) {
            $validatedString .= $key .'='. $value .'&';
        }

        parse_str($validatedString, $validatedArray);

        try {

            DB::beginTransaction();

            $receiverFields = $validatedArray['receiver'];

            $receiverFields['status'] = Receiver::setStatus($receiverFields['status']);

            if (!empty($receiverFields['password'])) {
                $receiverFields['password'] = Hash::make($receiverFields['password']);
            }

            $receiver = Receiver::create($receiverFields);

            $receiverDataFields = $validatedArray['receiver_data'];
            $receiverDataFields['receiver_id'] = $receiver->id;
            $receiverData = ReceiverData::create($receiverDataFields);

            $creditCardFields = $validatedArray['credit_card'];
            $creditCardFields['cardable_id'] = $receiver->id;
            $creditCardFields['cardable_type'] = Receiver::class;
            $creditCard = CreditCard::create($creditCardFields);

            $bankAccountFields = $validatedArray['bank_account'];
            $bankAccountFields['accountable_id'] = $receiver->id;
            $bankAccountFields['accountable_type'] = Receiver::class;
            $bankAccount = BankAccount::create($bankAccountFields);

            $responseCode = Response::HTTP_OK;
            $response = ['success' => 'Passed data were successfully saved'];

            DB::commit();
            
        } catch (\Exception $e) {

            DB::rollBack();
            $errorMessage = $e->getMessage();
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = ['serverError' => "I have got some error with the next message: $errorMessage. Mr. Server"];

        }

        return response()->json($response, $responseCode);
    }

    /**
     * Show the specified receiver
     */
    public function edit(Request $request)
    {
        $id = $request->post('item');
        $receiver = Receiver::with(['receiverData', 'creditCard', 'bankAccount'])->find($id);

        return response()->json($receiver);
    }

    /**
     * Update the specified receiver
     */
    public function update(ReceiverRequest $request)
    {
        // Return the validated form data
        $validated = $request->validated();

        $validatedString = '';

        foreach ($validated as $key => $value) {
            $validatedString .= $key .'='. $value .'&';
        }

        parse_str($validatedString, $validatedArray);

        $response = [];

        $receiverFields = $validatedArray['receiver'];

        $receiverFields['status'] = Receiver::setStatus($receiverFields['status']);

        if (!empty($receiverFields['password'])) {
            $receiverFields['password'] = Hash::make($receiverFields['password']);
        }

        $receiver = Receiver::where(['id' => $receiverFields['id']])->update($receiverFields);

        $receiverData = ReceiverData::where([
            'id' => $validatedArray['receiver_data']['id']
        ])->update($validatedArray['receiver_data']);

        $creditCard = CreditCard::where([
            'id' => $validatedArray['credit_card']['id']
        ])->update($validatedArray['credit_card']);

        $bankAccount = BankAccount::where([
            'id' => $validatedArray['bank_account']['id']
        ])->update($validatedArray['bank_account']);

        if (!$receiver || !$receiverData || !$creditCard || !$bankAccount) {
            $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $response = ['serverError' => 'Something went wrong on my side. Mr. Server'];
        } else {
            $responseCode = Response::HTTP_OK;
            $response = ['success' => 'Passed data were successfully saved'];
        }

        return response()->json($response, $responseCode);
    }

    /**
     * Remove the specified provider from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');

        $receiver = Receiver::with(['receiverData', 'creditCard', 'bankAccount'])
                ->find($id);
        if (!empty($receiver->receiverData)) {
            $receiver->receiverData->delete();
        }
        if (!empty($receiver->creditCard)) {
            $receiver->creditCard->delete();
        }
        if (!empty($receiver->bankAccount)) {
            $receiver->bankAccount->delete();
        }

        $response = [];

        if ($receiver->delete()) {

            /**
             * @return Illuminate\Pagination\LengthAwarePaginator
             */
            $pagination = Receiver::paginate(15);

            $response = [
                'items' => $pagination->getCollection()->map(function($item) {
                    return $item->getAttributesForTable();
                }),
                'currentPage' => $pagination->currentPage(),
                'lastPage' => $pagination->lastPage(),
                'attrnames' => $this->getAttributesAsKeys($pagination->getCollection()),
                'success' => 'It is successfully deleted',
            ];

        } else {
            $response['error'] = 'None of the items was deleted';
        }

        return response()->json($response);
    }

    /**
     * Find a searchable getting from an provider
     */
    public function search(Request $request)
    {
        $searchable = $request->input('search');
        $receivers = Receiver::where('first_name', 'like', "%$searchable%")
            ->orWhere('last_name', 'like', "%$searchable%")
            ->orWhere('email', 'like', "%$searchable%")
            ->limit(15)
            ->get();
        return response()->json($receivers);
    }

    /**
     * Select a first item from the collection and retrieve all attribute names of the model
     */
    private function getAttributesAsKeys(Collection $collection)
    {
        $model = $collection->first();
        return $model ? $model->getAttributeNamesForTable() : null;
    }
}
