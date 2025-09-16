<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use App\Models\Customer;
use App\Helpers\SmsHelper;

class OTPController extends Controller
{
    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
        ]);

        $user = Customer::where('mobile_number', $request->mobile_number)->first();

        if (!$user) {
            return response()->json(['error' => 'Mobile number not found.'], 404);
        }

        $otp = rand(100000, 999999); // You can use a more secure generator
        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addDay();
        $user->save();

        // TODO: Integrate with SMS API like Twilio or Fast2SMS
        // sendSm($user->mobile_number, "Your OTP is: $otp");
        SmsHelper::sendSms($user->mobile_number, "Your OTP is: $otp");

        return response()->json(['message' => 'OTP sent to your mobile number.']);
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $user = Customer::where('mobile_number', $request->mobile_number)->first();

        if (!$user || !$user->otp_code) {
            return response()->json(['error' => 'User not found or OTP not sent.'], 404);
        }

        if ($user->otp_code !== $request->otp) {
            return response()->json(['error' => 'Invalid OTP.'], 401);
        }

        if (Carbon::now()->gt($user->otp_expires_at)) {
            return response()->json(['error' => 'OTP expired.'], 401);
        }

        // Mark as verified
        $user->mobile_verified_at = now();
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        return response()->json(['message' => 'Mobile number verified successfully.']);
    }
}
