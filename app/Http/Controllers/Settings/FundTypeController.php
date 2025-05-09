<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FundTypeController extends Controller
{
    public function edit()
    {
        // Get the main fund
        $main_fund = Fund::where('type', 'main')->first();

        // Check if a main fund is found and get its id
        $main_fund_id = $main_fund ? $main_fund->id : null;

        // Pass funds and main_fund_id to the Inertia render
        return Inertia::render('settings/FundType', [
            'funds' => Fund::whereNull('closed_at')->get(['id', 'name', 'type']),
            'main_fund_id' => $main_fund_id,  // Pass the main fund ID to the component
        ]);
    }


    public function update(Request $request)
    {
        $request->validate([
            'main_fund_id' => 'required|exists:funds,id',
        ]);

        // Set all funds to 'campaign' first
        Fund::where('type', 'main')->update(['type' => 'campaign']);

        // Then set the selected fund as 'main'
        Fund::where('id', $request->main_fund_id)->update(['type' => 'main']);

        return back()->with('status', 'Fund type updated successfully.');
    }
}
