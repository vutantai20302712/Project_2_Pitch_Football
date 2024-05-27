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
use Illuminate\Support\Facades\DB;
class SchedulingFromController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('scheduling_froms')
            ->join('customers', 'scheduling_froms.customer_id', '=', 'customers.id')
            ->join('admins', 'scheduling_froms.admin_id', '=', 'admins.id')
            ->join('payments', 'scheduling_froms.payment_method', '=', 'payments.id')
            ->select('scheduling_froms.*', 'customers.name as customer_name', 'customers.email', 'customers.phone_number as customer_phone_number', 'admins.name as admin_name', 'payments.payment_method as payment_method');
    
        // Apply the status filter if it is set
        if ($request->has('status') && !empty($request->status)) {
            $query->where('scheduling_froms.scheduling_form_status', $request->status);
        }
    
        $data = $query->paginate(5); // Paginate 5 items per page
        
        $customers = DB::table('customers')->get();
        $admins = DB::table('admins')->get();
    
        // Retrieve cart items from the session
        return view('Manager.SchedulingForm.list', compact('data', 'customers', 'admins'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $pitches = Pitch::all();
        $time_frames = Time_frame::all();
        $customers = Customer::all();
        $admins = Admin::all();
        $payments = Payment::all();
        $carttimes = session()->get('carttime',[]);
        $cartItems = session()->get('cart', []);
        return view('Manager.SchedulingForm.create', compact('customers','admins','payments','pitches','time_frames','cartItems','carttimes'));
    }
    
    public function addToCart(Request $request, $id) {
        // Kiểm tra sự tồn tại của sân
        $pitch = Pitch::find($id);
        if(!$pitch) {
            abort(404); // Hoặc xử lý thông báo lỗi khác tùy theo yêu cầu của bạn
        }
        // Lấy thông tin giỏ hàng từ session
        $cart = session()->get('cart', []);
    
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if(!isset($cart[$id])) {
            // Nếu sản phẩm chưa tồn tại, thêm sản phẩm vào giỏ hàng
            $cart[$id] = [
                'name' => $pitch->name,
                'price' => $pitch->price,
                'image' => $pitch->image,
                // Bạn có thể thêm các trường thông tin khác của sản phẩm vào đây nếu cần
            ];
        }
    
        // Cập nhật giỏ hàng trong session
        session()->put('cart', $cart);
        // Chuyển hướng người dùng trở lại trang scheduling.create
        return redirect()->route('scheduling_form.create')->with('success', 'Thêm sân thành công');
    }

    public function addToCartTime(Request $request, $id) {
        // Kiểm tra sự tồn tại của sân
       $timeframes = Time_frame::find($id);
        if(!$timeframes) {
            abort(404); // Hoặc xử lý thông báo lỗi khác tùy theo yêu cầu của bạn
        }
    
        // Lấy thông tin giỏ hàng từ session
        $carttime = session()->get('carttime', []);
    
        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if(!isset($carttime[$id])) {
            // Nếu sản phẩm chưa tồn tại, thêm sản phẩm vào giỏ hàng
            $carttime[$id] = [
                'start_time' => $timeframes ->start_time,
                'end_time' => $timeframes ->end_time,
                // Bạn có thể thêm các trường thông tin khác của sản phẩm vào đây nếu cần
            ];
        }
        // Cập nhật giỏ hàng trong session
        session()->put('carttime', $carttime);
    
        // Chuyển hướng người dùng trở lại trang scheduling.create
        return redirect()->route('scheduling_form.create')->with('success', 'Thêm thời gian thành công');
    }
    
    public function clear(Request $request)
    {
        // Xóa toàn bộ giỏ hàng
        $request->session()->forget(['cart', 'carttime']);
        // Trả về thông báo xóa thành công
        return redirect()->route('scheduling_form.create')->with('success', 'Đã xóa toàn bộ giỏ hàng');
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduling_fromRequest $request)
    {
        // Lưu thông tin vào bảng scheduling_forms
        $scheduling_form = DB::table('scheduling_froms')->insertGetId([
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'payment_method' => $request->payment_method,
            'scheduling_form_status' => $request->scheduling_form_status,
            'scheduling_form_date' => $request->scheduling_form_date
        ]);
        // Lấy thông tin từ session
        $cartItems = session('cart', []);
        $carttime = session('carttime', []);
        // Lưu thông tin chi tiết đơn hàng vào bảng scheduling_form_details
        foreach ($cartItems as $pitchId => $item) {
            // Kiểm tra xem pitch có tồn tại không
            if ($pitch = Pitch::find($pitchId)) {
                // Lặp qua mảng carttime để lấy id của time frame tương ứng
                foreach ($carttime as $timeId => $item1) {
                    // Kiểm tra xem time frame có tồn tại không
                    if ($timeframe = Time_frame::find($timeId)) {
                        // Tạo mới chi tiết đơn hàng và lưu vào cơ sở dữ liệu
                        $scheduling_form_details = new Scheduling_from_detail();
                        $scheduling_form_details->scheduling_form_id = $scheduling_form;
                        $scheduling_form_details->pitch_id = $pitch->id;
                        $scheduling_form_details->time_id = $timeframe->id;
                        $scheduling_form_details->price = $pitch->price;
                        // Thêm các thông tin khác của chi tiết đơn hàng nếu cần
                        $scheduling_form_details->save();
                    }
                }
            }
        }
        
        return redirect()->route('scheduling_form.index')->with('msg', 'Add Successful');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Scheduling_from $scheduling_from)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Scheduling_from $scheduling_from, String $id)
    {
        //
        $data = DB::table('scheduling_froms')
        ->join('customers', 'scheduling_froms.customer_id', '=', 'customers.id')
        ->join('admins', 'scheduling_froms.admin_id', '=', 'admins.id')
        ->join('payments', 'scheduling_froms.payment_method', '=', 'payments.id')
        ->select('scheduling_froms.*', 'customers.name as customer_name','admins.name as admin_name','payments.payment_method as payment_method') // Chọn cột 'category_name'
        ->where('scheduling_froms.id', $id) // Lọc theo ID của sản phẩm
        ->get(); // Sử dụng first() thay vì get() để lấy một bản ghi đơn
        $admins = DB::table('admins')->get();
        $scheduling_form_details = Scheduling_from_detail::all();
        $customers = DB::table('customers')->get();
        $payments = DB::table('payments')->get();
        $pitches = Pitch::all();
        $time_frames = Time_frame::all();
        return view('Manager.SchedulingForm.edit', compact('data','admins','customers','payments','pitches','scheduling_form_details','time_frames'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduling_fromRequest $request, Scheduling_from $scheduling_from, String $id)
    {
        DB::table('scheduling_froms')->where('id', $id)->update([
            'customer_id' => $request->customer_id,
            'admin_id' => $request->admin_id,
            'payment_method' => $request->payment_method,
            'scheduling_form_status' => $request->scheduling_form_status,
            'scheduling_form_date' => $request->scheduling_form_date,
        ]);
        return Redirect::route('scheduling_form.index')->with('msg', 'Update Successful');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id)
    {
        // Xóa tất cả các chi tiết của biểu mẫu lịch trình có id tương ứng
        DB::table('scheduling_from_details')->where('scheduling_form_id', $id)->delete();
        // Sau khi xóa tất cả các chi tiết, tiến hành xóa biểu mẫu lịch trình
        DB::table('scheduling_froms')->where('id', $id)->delete();
    
        return Redirect::route('scheduling_form.index')->with('msg', 'Delete Successful');
    }

}
