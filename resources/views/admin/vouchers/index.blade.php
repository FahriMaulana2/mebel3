@extends('admin.layouts.admin')

@section('title', 'Vouchers')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Voucher List</h1>

    <a href="{{ route('admin.vouchers.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Add Voucher
    </a>
</div>



<div class="bg-white rounded shadow overflow-x-auto">

    <table class="w-full text-sm">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Code</th>
                <th class="p-3 text-left">Discount</th>
                <th class="p-3 text-left">Min Order</th>
                <th class="p-3 text-left">Expired</th>
                <th class="p-3 text-left">Status</th>
                <th class="p-3 text-center">Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($vouchers as $voucher)

                <tr class="border-t">

                    <td class="p-3 font-semibold">
                        {{ $voucher->code }}
                    </td>

                   <td class="p-3">

    @if($voucher->type == 'percent')
        {{ $voucher->value }}%
    @else
        Rp {{ number_format($voucher->value, 0, ',', '.') }}
    @endif

</td>

<td class="p-3">
    Rp {{ number_format($voucher->minimum_order ?? 0, 0, ',', '.') }}
</td>

                    <td class="p-3">
                        {{ $voucher->expired_at }}
                    </td>

                    <td class="p-3">
                        @if($voucher->is_active)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Active
                            </span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                                Inactive
                            </span>
                        @endif
                    </td>

                    <td class="p-3 text-center">

                        <a href="{{ route('admin.vouchers.edit', $voucher->id) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                              method="POST"
                              class="inline-block"
                              data-mebel-popup="confirm-delete"
                              data-title="Delete voucher?"
                              data-message="This action cannot be undone.">


                            @csrf
                            @method('DELETE')

                            <button class="bg-red-600 text-white px-3 py-1 rounded">
                                Delete
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="6" class="p-6 text-center text-gray-500">
                        No vouchers found
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection