<?php

namespace App\Http\Controllers;

use App\{Revenue, Currency, Wallet};
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $user = request()->user();

        /**
         * get current user percentage
         */
        $investors  = investors();
        $percentage = ($investors[$user->id] ?? 0) * 100;

        /**
         * ETH
         */
        $eth       = Revenue::user($user->id)->currency(Currency::ETH)->sum('amount');
        $ethWallet = Wallet::user($user->id)->currency(Currency::ETH)->sum('amount');

        /**
         * BTC
         */
        $btc       = Revenue::user($user->id)->currency(Currency::BTC)->sum('amount');
        $btcWallet = Wallet::user($user->id)->currency(Currency::BTC)->sum('amount');

        /**
         * TWD
         */
        $twdWallet = Wallet::user($user->id)->currency(Currency::TWD)->sum('amount');

        /**
         * set view variable
         */
        view()->share('percentage', $percentage);
        view()->share('eth', $eth);
        view()->share('ethWallet', $ethWallet);
        view()->share('btc', $btc);
        view()->share('btcWallet', $btcWallet);
        view()->share('twdWallet', $twdWallet);

        $btcPercentage = revenue_diff_percentage(Currency::BTC);
        $ethPercentage = revenue_diff_percentage(Currency::ETH);

        view()->share('btcPercentage', $btcPercentage);
        view()->share('ethPercentage', $ethPercentage);

        $btcChart = revenue_diff_chart(Currency::BTC);
        $ethChart = revenue_diff_chart(Currency::ETH);

        view()->share('btcChart', $btcChart);
        view()->share('ethChart', $ethChart);

        return view('dashboard');
    }
}
