<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index()
    {
        $shipments = Shipment::with('order')->latest()->paginate(15);
        return view('admin.shipments.index', compact('shipments'));
    }

    public function show(Shipment $shipment)
    {
        $shipment->load('order');
        return view('admin.shipments.show', compact('shipment'));
    }

    public function updateTracking(Request $request, Shipment $shipment)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:255',
        ]);

        $shipment->tracking_number = $request->tracking_number;
        $shipment->save();

        return redirect()->back()->with('success', 'Tracking number updated!');
    }

    public function markAsShipped(Shipment $shipment)
    {
        $shipment->markAsShipped();
        return redirect()->back()->with('success', 'Shipment marked as shipped!');
    }

    public function markAsDelivered(Shipment $shipment)
    {
        $shipment->markAsDelivered();
        return redirect()->back()->with('success', 'Shipment marked as delivered!');
    }
}