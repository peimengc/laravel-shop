<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressRequest;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create(UserAddress $userAddress)
    {
        return view('user_addresses.create_edit', compact('userAddress'));
    }

    public function store(UserAddressRequest $request)
    {
        $request->user()->addresses()->create($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }

    public function edit(UserAddress $userAddress)
    {
        $this->authorize('own', $userAddress);

        return view('user_addresses.create_edit', compact('userAddress'));
    }

    public function update(UserAddressRequest $request,UserAddress $userAddress)
    {
        $this->authorize('own', $userAddress);

        $userAddress->update($request->only([
            'province',
            'city',
            'district',
            'address',
            'zip',
            'contact_name',
            'contact_phone',
        ]));

        return redirect()->route('user_addresses.index');
    }

    public function destroy(UserAddress $userAddress)
    {
        $this->authorize('own', $userAddress);

        $userAddress->delete();

        return response()->json([

        ]);
    }

}
