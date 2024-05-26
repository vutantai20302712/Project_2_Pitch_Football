<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pitch;
use App\Models\Scheduling_from;
use App\Models\Scheduling_from_detail;
use App\Models\Time_frame;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Yard_category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function showall()
    {
        $pitches = Pitch::with('yardCategory')->get();
        return view('welcome', ['pitches' => $pitches]);
    }

    public function pitch_detail($id)
    {
        $pitches = DB::table('pitches')
            ->join('yard_categories', 'pitches.yard_category', '=', 'yard_categories.id')
            ->select('pitches.*', 'yard_categories.name as yard_category_name')
            ->where('pitches.id', $id)
            ->first();
            
        $time_frames = Time_frame::all();
        
        // Retrieve the booked time slots for the given pitch
        $bookedTimeFrames = DB::table('scheduling_from_details')
            ->join('scheduling_froms', 'scheduling_from_details.scheduling_form_id', '=', 'scheduling_froms.id')
            ->where('scheduling_from_details.pitch_id', $id)
            ->where('scheduling_froms.scheduling_form_status', '!=', 'Cancelled')
            ->pluck('scheduling_from_details.time_id')
            ->toArray();
        
        $choosetime = session()->get('selected_time_frames', []);
        $choosepitch = session()->get('selected_pitch', []);
        $yard_categories = Yard_category::all();
        
        return view('pitch_information', compact('pitches', 'yard_categories', 'time_frames', 'choosetime', 'choosepitch', 'bookedTimeFrames'));
    }
    

    public function view_register()
    {
        return view('pageregister');
    }

    public function registerProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:customers,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|string|unique:customers,phone_number',
        ]);

        $existingCustomer = Customer::where('email', $request->email)
            ->orWhere('phone_number', $request->phone_number)
            ->first();
        if ($existingCustomer) {
            return redirect()->back()->withInput()->withErrors(['email' => 'Email hoặc số điện thoại đã được sử dụng.']);
        }

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_number' => $request->phone_number,
        ]);

        session([
            'id' => $customer->id,
            'name' => $customer->name,
            'email' => $customer->email,
            'phone_number' => $customer->phone_number,
        ]);

        return redirect()->route('welcome')->with('success', 'Tạo tài khoản thành công!');
    }

    public function selectPitch(Request $request)
    {
        $pitchDetails = [
            'pitch_id' => $request->input('pitch_id'),
            'pitch_name' => $request->input('pitch_name'),
            'pitch_price' => $request->input('pitch_price'),
            'pitch_image' => $request->input('pitch_image'),
        ];
    
        session(['selected_pitch' => $pitchDetails]);
    
        return redirect()->back()->with('success', 'Pitch selected successfully!');
    }
    

    public function addTimeFrame(Request $request)
    {
        $timeFrameId = $request->input('selected_time_frame');
        $timeFrame = Time_frame::find($timeFrameId);
    
        if ($timeFrame) {
            $timeFrames = session('selected_time_frames', []);
            $timeFrames[] = [
                'id' => $timeFrame->id,
                'start_time' => $timeFrame->start_time,
                'end_time' => $timeFrame->end_time,
            ];
            session(['selected_time_frames' => $timeFrames]);
    
            // Log the session data for debugging
            Log::info('Time frames added to session:', $timeFrames);
        } else {
            Log::error('Time frame not found:', ['timeFrameId' => $timeFrameId]);
        }
    
        return redirect()->back()->with('success', 'Time frame added successfully!');
    }    

    public function schedulingformProcess()
    {
        $payments = Payment::all();
        return view('schedulingform_process', compact('payments'));
    }

    public function deletePitch(Request $request)
    {
        $request->session()->forget(['selected_pitch', 'selected_time_frames']);

        return redirect()->back()->with('success', 'Pitch and time frames removed successfully!');
    }

    public function viewLogin()
    {
        return view('pagelogin');
    }

    public function loginProcess(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $customer = Customer::where('email', $email)->first();
        if ($customer && Hash::check($password, $customer->password)) {
            $request->session()->put('id', $customer->id);
            $request->session()->put('name', $customer->name);
            $request->session()->put('email', $customer->email);
            $request->session()->put('phone_number', $customer->phone_number);

            return redirect()->route('welcome');
        } else {
            return redirect()->route('pagelogin')->with('error', 'Email hoặc mật khẩu không chính xác. Vui lòng thử lại.');
        }
    }

    public function customerlogout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('pagelogin');
    }

    public function paymentvnpay(Request $request)
    {
        $vnp_TmnCode = "NFNU4AI0"; // Your test TmnCode
        $vnp_HashSecret = "S65QQLIECQ442Q91PTQCRP3MXJCNPZEN"; // Your test HashSecret
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return'); // Ensure this route exists
        $vnp_TxnRef = rand(00, 9999); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toan VNPay";
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->input('total') * 100; // Amount in VND
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }


    public function vnpayReturn(Request $request)
    {
        // Log the input data for debugging
        Log::info('VNPay Return Data: ', $request->all());
        // Simulate a successful payment
        session(['payment_status' => 'success']);
        return redirect()->route('schedulingform.process')->with('success', 'Bạn đã thanh toán đơn đặt lịch thành công');
    }

    public function Process_booking_orders_when_paying_offline(Request $request)
    {
        // Validate the input
        $request->validate([
            'scheduling_form_date' => 'required|date',
        ]);
    
        // Lấy thông tin khách hàng từ session
        $customerId = session('id');
    
        // Tạo một bản ghi mới trong bảng scheduling_forms và lưu lại đối tượng đã tạo
        $schedulingForm = Scheduling_from::create([
            'customer_id' => $customerId,
            'scheduling_form_status' => 'Unconfirmed', // Chỉnh sửa chính tả thành 'Unconfirmed'
            'scheduling_form_date' => $request->scheduling_form_date,
            'admin_id' => 1, // ID của admin (tạm thời là 1)
            'payment_method' => 1, // Phương thức thanh toán offline
        ]);
    
        // Lấy thông tin về pitch từ session
        $selectedPitch = session('selected_pitch');
        $timeFrames = session('selected_time_frames'); // Retrieve time frame entries from session
    
        // Kiểm tra nếu $schedulingForm không null trước khi tiếp tục
        if ($schedulingForm) {
            // Lưu thông tin vào bảng scheduling_form_details
            foreach ($timeFrames as $timeFrame) {
                Scheduling_from_detail::create([
                    'pitch_id' => $selectedPitch['pitch_id'],
                    'scheduling_form_id' => $schedulingForm->id,
                    'price' => $selectedPitch['pitch_price'],
                    'time_id' => $timeFrame['id'] // Truyền id của time_frame trong session đã được chọn vào
                ]);
            }
    
            // Xóa các session liên quan đến đặt lịch và thanh toán
            $request->session()->forget(['selected_pitch', 'selected_time_frames', 'payment_status']);
    
            // Chuyển hướng người dùng đến trang chính hoặc trang thông báo thành công
            return redirect()->route('welcome')->with('success', 'Đơn đặt lịch của bạn đã được ghi nhận và đang chờ xác nhận.');
        } else {
            // Xử lý trường hợp không tạo được schedulingForm
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý đơn đặt lịch. Vui lòng thử lại.');
        }
    }
    
    



    public function Process_booking_orders_when_paying_online(Request $request)
    {
          // Validate the input
          $request->validate([
            'scheduling_form_date' => 'required|date',
        ]);
        // Lấy thông tin khách hàng từ session
    $customerId = session('id');
    
    // Tạo một bản ghi mới trong bảng scheduling_forms và lưu lại đối tượng đã tạo
    $schedulingForm = Scheduling_from::create([
        'customer_id' => $customerId,
        'scheduling_form_status' => 'Paid', // Chỉnh sửa chính tả thành 'Unconfirmed'
        'scheduling_form_date' => $request->scheduling_form_date,
        'admin_id' => 1, // ID của admin (tạm thời là 1)
        'payment_method' => 3, // Phương thức thanh toán offline
    ]);
    
    // Lấy thông tin về pitch từ session
    $selectedPitch = session('selected_pitch');
    $timeFrames = session('selected_time_frames'); // Retrieve time frame entries from session
    
    // Kiểm tra nếu $schedulingForm không null trước khi tiếp tục
    if ($schedulingForm) {
        // Lưu thông tin vào bảng scheduling_form_details
        foreach ($timeFrames as $timeFrame) {
            Scheduling_from_detail::create([
                'pitch_id' => $selectedPitch['pitch_id'],
                'scheduling_form_id' => $schedulingForm->id,
                'price' => $selectedPitch['pitch_price'],
                'time_id' => $timeFrame['id'] // Truyền id của time_frame trong session đã được chọn vào
            ]);
        }
        
        // Xóa các session liên quan đến đặt lịch và thanh toán
        $request->session()->forget(['selected_pitch', 'selected_time_frames', 'payment_status']);
        
        // Chuyển hướng người dùng đến trang chính hoặc trang thông báo thành công
        return redirect()->route('welcome')->with('success', 'Đơn đặt lịch của bạn đã được ghi nhận và đang chờ xác nhận.');
    } else {
        // Xử lý trường hợp không tạo được schedulingForm
        return redirect()->back()->with('error', 'Có lỗi xảy ra khi xử lý đơn đặt lịch. Vui lòng thử lại.');
    }

    }
}
