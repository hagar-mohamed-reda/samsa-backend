<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Payment;
use Modules\Account\Entities\Installment;

class PaymentController extends Controller
{

    public function __construct() {
        /* $this->middleware(['permission:payments_read'])->only('index');
          $this->middleware(['permission:payments_create'])->only('create');
          $this->middleware(['permission:payments_update'])->only('edit');
          $this->middleware(['permission:payments_delete'])->only('destroy'); */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;
        $installment = Installment::find(request()->installment_id);
        

        if (request()->resource_id)
            $resource = Payment::find(request()->resource_id);
        
        $query = Payment::query();

        if (request()->date_from && request()->date_to) {
            $query->whereBetween('date', [request()->date_from, request()->date_to]);
        }
        
        if (request()->store_id > 0) 
            $query->where('store_id', request()->store_id);
        
        if (request()->payment_type) 
            $query->where('payment_type', request()->payment_type);
         
        if (request()->user_id) 
            $query->where('user_id', request()->user_id);
        
        $resources = $query->OrderBy('created_at', 'desc')->paginate(10);
        return view('account::payments.index', compact('resources', 'resource', 'installment'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::payments.create');
    }

    /**
     * Payment a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $installment = Installment::find($request->installment_id);
            
            if ($request->value > optional($installment)->value) {
                return responseJson(0, __('value of payment is bigger than installment value ') . optional($installment)->value);
            }
            
            $data = $request->all();
            $payment = Payment::create($data);
            // decrease value from store
            if ($payment->store) {
                $payment->store->balance += $data['value'];
                $payment->store->update();
            }
            // upload attachment
            uploadImg($request->file('attachment'), "uploads/payments", function($filename) use ($payment) {
                $payment->update([
                    'attachment' => "uploads/payments" . "/" . $filename
                ]);
            });
            
            if ($installment) {
                if ($installment->isPaid())
                    $installment->update([
                        "paid" => '1'
                    ]); 
            }
            notfy(__('pay installment'), __('pay installment ') . $payment->id, "fa fa-circle"); 
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('process has been success'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id) {
        return view('account::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = Payment::find($id);
        return view('account::payments.edit', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id) {
        try {
            $data = $request->all();

            $resource = Payment::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit payment'), __('edit payment') . $resource->code, "fa fa-payment");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('payments.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {

        try {
            $resource = Payment::find($id);

            if ($resource->transformations()->count() > 0) {
                notify()->error(__('cant remove payment has transformations'), "", "bottomLeft", "");
                return redirect()->route('payments.index');
            }

            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove payment'), __('remove payment') . $resource->name, "fa fa-payment");

            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('payments.index');
    }
}
