<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Comment;
use App\Models\Comments;
use App\Models\Option;
use App\Models\Pilot;
use App\Models\Signature;
use Illuminate\Http\Request;

class SheetController extends Controller
{
    public function index()
    {
        $sites = Signature::orderBy('created_at', 'DESC')->limit(50)->get();
        view()->share('sites', $sites);

        return $this->view('sheets.index');
    }

    public function single(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('home');
        }

        $sinature = Signature::find($id);

        if (is_null($sinature)) {
            return redirect()->route('sheets.all');
        }

        $options = Option::all();
        view()->share('options', $options);

        view()->share('site', $sinature);

        return $this->view('sheets.single');
    }

    public function addBookmarker(Requests\AddBookmarkerRequest $request, $id)
    {
        if (!is_numeric($id))
            return redirect()->route('sheets.single');

        $site = Signature::find($id);

        if (is_null($site))
            return redirect()->route('sheets.single');

        $points = Option::where('key', 'points_bookmarker')->first();

        $bookmarker = new Pilot();
        $bookmarker->sheet_id = $site->sheet->id;
        $bookmarker->name = $request->input('name');
        $bookmarker->role = 'Bookmarker';
        $bookmarker->points = $points->value;

        $bookmarker->save();

        $site->sheet->points = $site->sheet->points + $bookmarker->points;
        $site->sheet->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function addEscalator(Requests\AddEscalatorRequest $request, $id)
    {
        if (!is_numeric($id))
            return redirect()->route('sheets.single');

        $site = Signature::find($id);

        if (is_null($site))
            return redirect()->route('sheets.single');

        $points = Option::where('key', 'points_escalator')->first();

        $escalator = new Pilot();
        $escalator->sheet_id = $site->sheet->id;
        $escalator->name = $request->input('name');
        $escalator->role = 'Escalator';
        $escalator->ship = $request->input('ship');
        $escalator->points = $points->value;

        $escalator->save();

        $site->sheet->points = $site->sheet->points + $escalator->points;
        $site->sheet->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function addDefanger(Requests\AddDefangerRequest $request, $id)
    {
        if (!is_numeric($id))
            return redirect()->route('sheets.single');

        $site = Signature::find($id);

        if (is_null($site))
            return redirect()->route('sheets.single');

        $points = Option::where('key', 'points_defanger')->first();

        $defanger = new Pilot();
        $defanger->sheet_id = $site->sheet->id;
        $defanger->name = $request->input('name');
        $defanger->role = 'Defanger';
        $defanger->points = $points->value;

        $defanger->save();

        $site->sheet->points = $site->sheet->points + $defanger->points;
        $site->sheet->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function addPilots(Requests\AddPilotsRequest $request, $id)
    {

        $site = Signature::find($id);
        if (is_null($site))
            return redirect()->route('sheets.single');

        //get all options here so we dont have to fire a query for each pilot
        $options = Option::all();

        $allowed_ship_types = ['Stealth Bomber', 'Marauder', 'Dreadnaught', 'Carrier'];

        $lines = explode("\n", $request->input('pilots'));

        foreach ($lines as $line) {
            $data = explode("\t", $line);

            if (!in_array($data[3], $allowed_ship_types)) {
                continue;
            }

            $option_key = 'points_' . strtolower($data[2]);

            //dont add a pilot when we dont have a option for his ship
            $option = $options->where('key', $option_key);
            if (!$option) {
                continue;
            }

            $points = $option->first()->value;

            //if a pilot already exists for this sheet, retrive the record and update it, else create a new record
            $pilot = Pilot::firstOrNew(['name' => $data[0], 'sheet_id' => $site->sheet->id, 'role' => $data[3]]);
            $pilot->name = $data[0];
            $pilot->ship = $data[2];
            $pilot->sheet_id = $site->sheet->id;
            $pilot->points = $points;
            $pilot->role = $data[3];
            $pilot->save();

            $site->sheet->points += $points;
            $site->sheet->save();
        }

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function markAsFinished(Requests\MarkAsFinishedRequest $request, $id)
    {
        if (!is_numeric($id))
            return redirect()->route('sheets.single');

        $site = Signature::find($id);

        if (is_null($site))
            return redirect()->route('sheets.single');

        $site->active = false;
        $site->finished = true;
        $site->save();

        $site->sheet->total_isk = $request->input('payout');
        $site->sheet->save();

        if ($request->has('comment')) {
            $comment = new Comment();
            $comment->user_id = 1; //todo: link with auth
            $comment->comment = $request->input('comment');
            $comment->type = 'site_finnished_comment';
            $comment->sheet_id = $site->sheet->id;
            $comment->save();
        }

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function payPilot(Request $request, $id, $pilot_id)
    {
        if ($request->input('_action') != 'pay_pilot')
            return redirect()->route('sheets.single', ['id' => $id]);

        $pilot = Pilot::find($pilot_id);

        if (is_null($pilot))
            return redirect()->route('sheets.single', ['id' => $id]);

        $site = Signature::find($id);
        if (is_null($site))
            return redirect()->route('sheets.single', ['id' => $id]);

        $options = Option::all();

        $points = (1 + $site->sheet->modifier) * $pilot->points;
        $cut = $points / $site->sheet->points;
        $payout = $site->sheet->total_isk - ($site->sheet->total_isk * $options->where('key', 'corp_cut')->first()->value);
        $pilot_cut = $payout * $cut;

        $pilot->cut = $pilot_cut;
        $pilot->paid = true;
        $pilot->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function markAsPaid(Request $request, $id)
    {
        if ($request->input('_action') != 'mark_as_paid')
            return redirect()->route('sheets.single', ['id' => $id]);

        $site = Signature::find($id);
        if (is_null($site))
            return redirect()->route('sheets.single', ['id' => $id]);

        $site->sheet->is_paid = true;
        $site->sheet->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }

    public function removePilot(Request $request, $id, $pilot_id)
    {
        if ($request->input('_action') != 'remove_pilot')
            return redirect()->route('sheets.single', ['id' => $id]);

        $pilot = Pilot::find($pilot_id);

        if (is_null($pilot))
            return redirect()->route('sheets.single', ['id' => $id]);

        $site = Signature::find($id);
        if (is_null($site))
            return redirect()->route('sheets.single', ['id' => $id]);

        $site->sheet->points -= $pilot->points;

        $comment = new Comment();
        $comment->user_id = 0; //user id
        $comment->type = 'sheet_log';
        $comment->comment = 'Removed Pilot ' . $pilot->name . ' with role ' . $pilot->role;
        $comment->sheet_id = $site->sheet->id;
        $comment->save();

        $pilot->delete();
        $site->save();

        return redirect()->route('sheets.single', ['id' => $id]);
    }
}
