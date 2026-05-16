<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->get();

        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code',
            'type' => 'required',
            'value' => 'required|numeric',
            'minimum_order' => 'nullable|numeric',
            'expired_at' => 'required|date',
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'minimum_order' => $request->minimum_order ?? 0,
            'usage_limit' => 999,
            'used' => 0,
            'expired_at' => $request->expired_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dibuat');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code,' . $voucher->id,
            'type' => 'required',
            'value' => 'required|numeric',
            'minimum_order' => 'nullable|numeric',
            'expired_at' => 'required|date',
        ]);

        $voucher->update([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'value' => $request->value,
            'minimum_order' => $request->minimum_order ?? 0,
            'expired_at' => $request->expired_at,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil diupdate');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return back()->with('success', 'Voucher berhasil dihapus');
    }
}