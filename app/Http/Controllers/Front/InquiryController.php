<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function form()
    {
        return view('front.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160'],
            'phone' => ['nullable', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:160'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Inquiry::create($data + ['status' => 'new']);

        return redirect()
            ->route('front.contact')
            ->with('status', 'Terima kasih, pesan Anda sudah kami terima. Tim Akha akan membalas segera.');
    }
}
