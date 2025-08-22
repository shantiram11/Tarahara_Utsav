<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class PasswordOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email']
        ]);

        $email = Str::lower($validated['email']);
        $user = User::where('email', $email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        $key = 'password-otp:'.$request->ip().':'.$email;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors(['email' => __('Please wait :seconds seconds before retrying.', ['seconds' => $seconds])]);
        }
        RateLimiter::hit($key, 60);

        $otp = random_int(100000, 999999);

        $request->session()->put('password_otp', [
            'email' => $email,
            'otp' => (string) $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($email)->send(new PasswordOtpMail($otp));

        return redirect()->route('password.otp.form')->with('status', __('We\'ve emailed your OTP code.'));
    }

    public function showForm(Request $request)
    {
        $data = $request->session()->get('password_otp');
        return view('frontend.auth.password-otp', [
            'email' => $data['email'] ?? null,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $session = $request->session()->get('password_otp');
        if (!$session) {
            return back()->withErrors(['otp' => __('Your OTP session has expired. Please request a new code.')]);
        }

        if (now()->greaterThan($session['expires_at'])) {
            $request->session()->forget('password_otp');
            return back()->withErrors(['otp' => __('OTP has expired. Please request a new code.')]);
        }

        if ($validated['otp'] !== ($session['otp'] ?? '')) {
            return back()->withErrors(['otp' => __('Invalid OTP. Please try again.')]);
        }

        $request->session()->put('password_otp_verified', true);

        return redirect()->route('password.otp.reset.form');
    }

    public function showResetForm(Request $request)
    {
        $session = $request->session()->get('password_otp');
        $verified = $request->session()->get('password_otp_verified');
        if (!$session || !$verified) {
            return redirect()->route('password.otp.form')->withErrors(['otp' => __('Please verify the OTP first.')]);
        }

        return view('frontend.auth.reset-with-otp', [
            'email' => $session['email'] ?? null,
        ]);
    }

    public function resetWithOtp(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $session = $request->session()->get('password_otp');
        $verified = $request->session()->get('password_otp_verified');
        if (!$session || !$verified) {
            return redirect()->route('password.otp.form')->withErrors(['otp' => __('Please verify the OTP first.')]);
        }

        $user = User::where('email', $session['email'])->first();
        if (!$user) {
            return redirect()->route('password.otp.form')->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        $user->forceFill([
            'password' => Hash::make($validated['password'])
        ])->save();

        $request->session()->forget('password_otp');
        $request->session()->forget('password_otp_verified');

        return redirect()->route('login')->with('status', __('Your password has been reset.'));
    }
}
