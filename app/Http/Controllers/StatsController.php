<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Khill\Lavacharts\Laravel\LavachartsFacade as Lava;

class StatsController extends Controller
{

    public function index(Request $request)
    {

        $this->_siteStats();
        $this->_totalISK();
        $this->_compareBomber();
        $this->_compareShips();

        $sheets = Sheet::all();
        view()->share('sheets', $sheets);

        return $this->view('stats.index');
    }

    private function _compareBomber(){
        $ships = DB::table('pilots')
            ->select('ship', DB::raw('count(*) as count'))
            ->where('role', 'Stealth Bomber')
            ->groupBy('ship')
            ->get('ship', 'count');

        $table = Lava::DataTable()
            ->addStringColumn('Ship')
            ->addNumberColumn('Number');

        foreach($ships as $ship){
            $table->addRow([$ship->ship, $ship->count]);
        }

        Lava::PieChart('bomber', $table, [
            'is3D'   => false,
        ]);
    }

    private function _compareShips(){
        $ships = DB::table('pilots')
            ->select('ship', DB::raw('count(*) as count'))
            ->where('ship', '!=', '')
            ->groupBy('ship')
            ->get('ship', 'count');


        $table = Lava::DataTable()
            ->addStringColumn('Ship')
            ->addNumberColumn('Number');

        foreach($ships as $ship){
            $table->addRow([$ship->ship, $ship->count]);
        }

        Lava::PieChart('ships', $table, [
            'is3D'   => false,
            'sliceVisibilityThreshold' => 0,
            'reverseCategories' => false,
        ]);
    }

    private function _totalISK()
    {

        $total_isk = DB::table('sheet')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_isk) as sum'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(),
                Carbon::now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'sum');

        $total_payout = DB::table('sheet')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(payout) as sum'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(),
                Carbon::now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'sum');

        $total_corp_cut = DB::table('sheet')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(corp_cut) as sum'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(),
                Carbon::now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'sum');

        $data = [];

        foreach ($total_isk as $res) {
            $data[$res->date] = [];
            $data[$res->date]['total'] = $res->sum;
        }

        foreach ($total_payout as $res) {
            $data[$res->date]['payout'] = $res->sum;
        }

        foreach ($total_corp_cut as $res) {
            $data[$res->date]['corp'] = $res->sum;
        }


        $total_isk_data_table = Lava::DataTable()
            ->addStringColumn('Day')
            ->addNumberColumn('Total')
            ->addNumberColumn('Payout')
            ->addNumberColumn('Corp');

        foreach ($data as $date => $type) {
            $date = Carbon::parse($date)
                ->format('M j');
            $total = isset($type['total']) ? $type['total'] : 0;
            $payout = isset($type['payout']) ? $type['payout'] : 0;
            $corp = isset($type['corp']) ? $type['corp'] : 0;

            $total_isk_data_table->addRow([$date, $total, $payout, $corp]);
        }

        Lava::LineChart('totalisk', $total_isk_data_table);
    }

    private function _siteStats()
    {

        $sitesCreated = DB::table('site')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(1),
                Carbon::now()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'count');

        $sitesRun = DB::table('site')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(1),
                Carbon::now()
            ])
            ->where('finished', '1')
            ->where('active', '0')
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'count');

        $sitesClosed = DB::table('site')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [
                Carbon::now()
                    ->subWeek(1),
                Carbon::now()
            ])
            ->where('finished', '0')
            ->where('active', '0')
            ->groupBy('date')
            ->orderBy('date')
            ->get('date', 'count');

        $sitesTable = Lava::DataTable();

        $sitesTable->addDateColumn('Date')
            ->addNumberColumn('Created')
            ->addNumberColumn('Finished')
            ->addNumberColumn('Closed');

        $data = [];

        foreach ($sitesCreated as $res) {
            $data[$res->date] = [];
            $data[$res->date]['created'] = $res->count;
        }

        foreach ($sitesRun as $res) {
            $data[$res->date]['run'] = $res->count;
        }

        foreach ($sitesClosed as $res) {
            $data[$res->date]['closed'] = $res->count;
        }

        foreach ($data as $date => $count) {
            if (isset($count['created'])) {
                $created = $count['created'];
            } else {
                $created = 0;
            }

            if (isset($count['run'])) {
                $run = $count['run'];
            } else {
                $run = 0;
            }

            if (isset($count['closed'])) {
                $closed = $count['closed'];
            } else {
                $closed = 0;
            }

            $sitesTable->addRow([$date, $created, $run, $closed]);
        }

        Lava::ColumnChart('Sites', $sitesTable, [
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }
}
