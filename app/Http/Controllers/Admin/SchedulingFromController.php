<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduling_fromRequest;
use App\Http\Requests\UpdateScheduling_fromRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Pitch;
use App\Models\Scheduling_from_detail;
use Illuminate\Http\Request;
use App\Models\Scheduling_from;
use Illuminate\Support\Facades\Redirect;
use App\Models\Payment;
use App\Models\Time_frame;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SchedulingFromController extends Controller
{
        public function index(Request $request)
        {
            // Cập nhật trạng thái đơn hàng hàng ngày
            $this->updateOrderStatus();
    
            // Tiếp tục với việc lấy danh sách đơn hàng và hiển thị nó
            $query = DB::table('scheduling_froms')
                ->join('customers', 'scheduling_froms.customer_id', '=', 'customers.id')
                ->join('admins', 'scheduling_froms.admin_id', '=', 'admins.id')
                ->join('payments', 'scheduling_froms.payment_method', '=', 'payments.id')
                ->select('scheduling_froms.*', 'customers.name as customer_name', 'customers.email', 'customers.phone_number as customer_phone_number', 'admins.name as admin_name', 'payments.payment_method as payment_method');
    
            if ($request->has('status') && !empty($request->status)) {
                $query->where('scheduling_froms.scheduling_form_status', $request->status);
            }
    
            $data = $query->paginate(5);
            
            $customers = DB::table('customers')->get();
            $admins = DB::table('admins')->get();
    
            return view('Manager.SchedulingForm.list', compact('data', 'customers', 'admins'));
        }
    
            protected function updateOrderStatus()
            {
                // Lấy tất cả các đơn hàng
                $schedulingForms = Scheduling_from::all();
        
                foreach ($schedulingForms as $schedulingForm) {
                    // Kiểm tra trạng thái của đơn hàng và ngày hiện tại
                    if ($schedulingForm->scheduling_form_status !== 'Cancelled' && $schedulingForm->scheduling_form_date < Carbon::now()) {
                        // Nếu phương thức thanh toán là Online (payment_method = 3)
                        if ($schedulingForm->payment_method == 3) {
                            // Nếu đơn hàng đã thanh toán, cập nhật thành đã hoàn thành
                            if ($schedulingForm->scheduling_form_status === 'Paid') {
                                $schedulingForm->scheduling_form_status = 'Completed';
                                $schedulingForm->save();
                            }
                        } else {
                            // Nếu đơn hàng chưa thanh toán, cập nhật thành bị hủy
                            if ($schedulingForm->scheduling_form_status === 'Paid' || $schedulingForm->scheduling_form_status === 'Completed' ) {
                                $schedulingForm->scheduling_form_status = 'Completed';
                            } else {
                                $schedulingForm->scheduling_form_status = 'Cancelled';
                            }
                            $schedulingForm->save();
                        }
                    }
                }
            }

    public function create()
    {
        $pitches = Pitch::all();
        $time_frames = Time_frame::all();
        $customers = Customer::all();
        $admins = Admin::all();
        $payments = Payment::all();
        $carttimes = session()->get('carttime', []);
        $cartItems = session()->get('cart', []);

        // Get booked time frames for each pitch
        $bookedTimeFrames = [];
        foreach ($pitches as $pitch) {
            $bookedTimeFrames[$pitch->id] = Scheduling_from_detail::where('pitch_id', $pitch->id)
                ->pluck('time_id')
                ->toArray();
        }

        return view('Manager.SchedulingForm.create', compact('customers', 'admins', 'payments', 'pitches', 'time_frames', 'cartItems', 'carttimes', 'bookedTimeFrames'));
    }

    public function addToCart(Request $request, $id)
    {
        $pitch = Pitch::find($id);
        if (!$pitch) {
            abort(404);
        }
        
        $cart = session()->get('cart', []);
        if (!isset($cart[$id])) {
            $cart[$id] = [
                'name' => $pitch->name,
                'price' => $pitch->price,
                'image' => $pitch->image,
            ];
        }
    
        session()->put('cart', $cart);
        return redirect()->route('scheduling_form.create')->with('success', 'Thêm sân thành công');
    }

    public function addToCartTime(Request $request, $id)
    {
        $timeframes = Time_frame::find($id);
        if (!$timeframes) {
            abort(404);
        }
    
        $carttime = session()->get('carttime', []);
        if (!isset($carttime[$id])) {
            $carttime[$id] = [
                'start_time' => $timeframes->start_time,
                'end_time' => $timeframes->end_time,
            ];
        }
    
        session()->put('carttime', $carttime);
        return redirect()->route('scheduling_form.create')->with('success', 'Thêm thời gian thành công');
    }

    public function clear(Request $request)
    {
        $request->session()->forget(['cart', 'carttime']);
        return redirect()->route('scheduling_form.create')->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }

    public function store(StoreScheduling_fromRequest $request)
    {
        $scheduling_form = DB::table('scheduling_froms')->insertGetId([
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'payment_method' => $request->payment_method,
            'scheduling_form_status' => $request->scheduling_form_status,
            'scheduling_form_date' => $request->scheduling_form_date,
        ]);

        $cartItems = session('cart', []);
        $carttime = session('carttime', []);
        foreach ($cartItems as $pitchId => $item) {
            if ($pitch = Pitch::find($pitchId)) {
                foreach ($carttime as $timeId => $item1) {
                    if ($timeframe = Time_frame::find($timeId)) {
                        $scheduling_form_details = new Scheduling_from_detail();
                        $scheduling_form_details->scheduling_form_id = $scheduling_form;
                        $scheduling_form_details->pitch_id = $pitch->id;
                        $scheduling_form_details->time_id = $timeframe->id;
                        $scheduling_form_details->price = $pitch->price;
                        $scheduling_form_details->save();
                    }
                }
            }
        }
        $request->session()->forget(['cart', 'carttime']);
        return redirect()->route('scheduling_form.index')->with('msg', 'Add Successful');
    }

    public function show(Scheduling_from $scheduling_from)
    {
        //
    }

    public function edit(Scheduling_from $scheduling_from, String $id)
    {
        $data = DB::table('scheduling_froms')
            ->join('customers', 'scheduling_froms.customer_id', '=', 'customers.id')
            ->join('admins', 'scheduling_froms.admin_id', '=', 'admins.id')
            ->join('payments', 'scheduling_froms.payment_method', '=', 'payments.id')
            ->select('scheduling_froms.*', 'customers.name as customer_name', 'admins.name as admin_name', 'payments.payment_method as payment_method')
            ->where('scheduling_froms.id', $id)
            ->get();
        
        $admins = DB::table('admins')->get();
        $scheduling_form_details = Scheduling_from_detail::all();
        $customers = DB::table('customers')->get();
        $payments = DB::table('payments')->get();
        $pitches = Pitch::all();
        $time_frames = Time_frame::all();

        return view('Manager.SchedulingForm.edit', compact('data', 'admins', 'customers', 'payments', 'pitches', 'scheduling_form_details', 'time_frames'));
    }

    public function update(UpdateScheduling_fromRequest $request, Scheduling_from $scheduling_from, String $id)
    {
        DB::table('scheduling_froms')->where('id', $id)->update([
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'payment_method' => $request->payment_method,
            'scheduling_form_status' => $request->scheduling_form_status,
            'scheduling_form_date' => $request->scheduling_form_date,
        ]);
          // Xóa các session liên quan đến đặt lịch và thanh toán
       
        return Redirect::route('scheduling_form.index')->with('msg', 'Update Successful');
    }

    public function destroy(String $id)
    {
        DB::table('scheduling_from_details')->where('scheduling_form_id', $id)->delete();
        DB::table('scheduling_froms')->where('id', $id)->delete();
    
        return Redirect::route('scheduling_form.index')->with('msg', 'Delete Successful');
    }
}
