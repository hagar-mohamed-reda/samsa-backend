<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Account\Entities\Installment;
use Modules\Account\Entities\Payment;

class InstallmentController extends Controller
{

    public function __construct() {
        /* $this->middleware(['permission:installments_read'])->only('index');
          $this->middleware(['permission:installments_create'])->only('create');
          $this->middleware(['permission:installments_update'])->only('edit');
          $this->middleware(['permission:installments_delete'])->only('destroy'); */
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        $resource = null;

        if (request()->resource_id)
            $resource = Installment::find(request()->resource_id);

        $query = Installment::query()->where('type', 'main');
        
        if (request()->user_id > 0) 
            $query->where("user_id", request()->user_id);
        
        if (request()->student_id > 0) 
            $query->where("student_id", request()->student_id);
        
        if (request()->installment_id > 0) 
            $query->where("installment_id", request()->installment_id);
        
        if (request()->type > 0) 
            $query->where("type", request()->type);
         
        if (request()->date_from) 
            $query->where("date_from", ">", request()->date_from);
         
        if (request()->date_to) 
            $query->where("date_to", "<", request()->date_to);
        

        $resources = $query->OrderBy('created_at', 'desc')->paginate(10);
        return view('account::installments.index', compact('resources', 'resource'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function install(Request $request, Installment $installment) {
        $resource = $installment; //Installment::find($request->installment_id); 

        return view('account::installments.install', compact("resource"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function pay(Request $request, Installment $installment) {
        $resource = Payment::where("installment_id", $installment->id)->first(); //Installment::find($request->installment_id);  
        if (!$resource)
            $resource = new Payment();
        
        return view('account::installments.payment', compact("installment", "resource"));
    }
    /**
     * Installment a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storeInstall(Request $request, Installment $installment) {
        try {

            $sum = 0;
            foreach ($request->value as $value) {
                $sum += $value;
            }

            if ($sum != $installment->remaining) {
                return responseJson(0, __('sum of values must be equal to ') . $installment->value);
            }

            for ($index = 0; $index < count($request->date_from); $index ++) {
                $id = $request->id[$index];
                $subInstallment = Installment::find($id);
                if ($subInstallment) {
                    $subInstallment->update([
                        "date_from" => $request->date_from[$index],
                        "date_to" => $request->date_to[$index],
                        "value" => $request->value[$index],
                        "student_id" => $installment->student_id,
                        "installment_id" => $installment->id,
                        "type" => "sub",
                            //"notes" => $request->notes[$index],
                    ]);
                } else {
                    $subInstallment = Installment::create([
                                "date_from" => $request->date_from[$index],
                                "date_to" => $request->date_to[$index],
                                "value" => $request->value[$index],
                                "student_id" => $installment->student_id,
                                "user_id" => $installment->user_id,
                                "installment_id" => $installment->id,
                                "type" => "sub",
                                    //"notes" => $request->notes[$index],
                    ]);
                }
            }

            notfy(__('install installment'), __('install installment ') . $installment->id, "fa fa-circle");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('process has been success'));
    }
    /**
     * Installment a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function storePay(Request $request, Installment $installment) {
        try { 
            $payment = Payment::find($request->id);
            $data = $request->all();
            $data['student_id'] = $installment->student_id;
            $data['user_id'] = $installment->user_id; 
            $data['installment_id'] = $installment->id; 
            $data['value'] = $installment->value - $data['discount'];
            
            if (!$payment) {
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
            } else {
                $payment->update($data);
                // decrease value from store
                if ($payment->store) {
                    $payment->store->balance -= $payment->value; 
                    $payment->store->balance += $data['value'];
                    $payment->store->update();
                }
                
                // upload attachment
                uploadImg($request->file('attachment'), "uploads/payments", function($filename) use ($payment) {
                    if (file_exists(public_path() . "/" . $payment->attachment)) {
                        unlink(public_path() . "/" . $payment->attachment);
                    }
                    
                    $payment->update([
                        'attachment' => "uploads/payments" . "/" . $filename
                    ]);
                });
            }
            
            $installment->update([
                "paid" => '1'
            ]);
            
            

            notfy(__('pay installment'), __('pay installment ') . $installment->id, "fa fa-circle");
        } catch (\Exception $th) {
            return responseJson(0, $th->getMessage());
        }

        return responseJson(1, __('process has been success'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('account::installments.create');
    }

    /**
     * Installment a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $resource = Installment::create($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('add installment'), __('add installment') . $resource->code, "fa fa-calendar");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('installments.index');
    }
    
    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id) {
        $resource = Installment::find($id);
        return view('account::installments.edit', compact('resource'));
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
            $data['user_id'] = Auth::user()->id;

            $resource = Installment::find($id);
            $resource->update($data);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('edit installment'), __('edit installment') . $resource->code, "fa fa-calendar");
        } catch (\Exception $th) {
            notify()->error($th->getMessage(), "", "bottomLeft", "");
        }

        return redirect()->route('installments.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id) {
        try {
            $resource = Installment::find($id);
            notify()->success(__('process has been success'), "", "bottomLeft", "");
            notfy(__('remove installment'), __('remove installment') . $resource->name, "fa fa-calendar");

            $resource->delete();
        } catch (\Exception $ex) {
            notify()->error($ex->getMessage(), "", "bottomLeft");
        }
        return redirect()->route('installments.index');
    }
}
