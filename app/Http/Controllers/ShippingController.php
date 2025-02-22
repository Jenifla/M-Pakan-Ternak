<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Coupon;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Shipping::orderBy('id', 'DESC');

        if (!empty($search)) {
            $query->where('type', 'like', "%$search%")
                  ->orWhere('price', 'like', '%' . $search . '%'); 
        }

        $shippings = $query->paginate(10)->appends(['search' => $search]);

        return view('backend.shipping.index', compact('shippings', 'search'));
    }


    public function getShippingOptions(Request $request)
    {
        $kabupaten = $request->query('kabupaten');
        if (!$kabupaten) {
            return response()->json(['error' => 'Kabupaten parameter is required'], 400); // Bad Request jika tidak ada kabupaten
        }

        // Cari shipping dengan status_biaya = 1 terlebih dahulu
        $shippingOptions = Shipping::where('type', $kabupaten)
            ->where('status_biaya', 1)
            ->get();

        // Jika tidak ditemukan, cari dengan status_biaya = 0
        if ($shippingOptions->isEmpty()) {
            $shippingOptions = Shipping::where('status_biaya', 0)
            ->get();
        }

        return response()->json($shippingOptions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'type'=>'required|string',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive',
            'status_biaya'=>'required|boolean'
        ]);
        $data=$request->all();
        $data['status_biaya'] = (int) $request->status_biaya;
        // return $data;
        $status=Shipping::create($data);
        if($status){
            request()->session()->flash('success','Shipping created successfully');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping=Shipping::find($id);
        if(!$shipping){
            request()->session()->flash('error','Shipping not found');
        }
        return view('backend.shipping.edit')->with('shipping',$shipping);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping=Shipping::find($id);
        $this->validate($request,[
            'type'=>'required|string',
            'price'=>'nullable|numeric',
            'status'=>'required|in:active,inactive',
            'status_biaya'=>'required|boolean'
        ]);
        $data=$request->all();
        $data['status_biaya'] = (int) $request->status_biaya;

        // return $data;
        $status=$shipping->fill($data)->save();
        if($status){
            request()->session()->flash('success','Shipping updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping=Shipping::find($id);
        if($shipping){
            $status=$shipping->delete();
            if($status){
                request()->session()->flash('success','Shipping deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('shipping.index');
        }
        else{
            request()->session()->flash('error','Shipping not found');
            return redirect()->back();
        }
    }
}
