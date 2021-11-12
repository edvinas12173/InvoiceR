<?php

namespace App\Http\Controllers;

use App\Models\Date;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function index() {
        $days = Date::orderBy('day', 'ASC')->get();
        return view('settings.days.index', [
            'days' => $days
        ]);
    }

    public function create() {
        return view('settings.days.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'days' => 'required'
        ]);

        $days =  new Date;
        $days->day = $request->input('days');
        $days->save();

        return redirect()
            ->route('days.index');
    }

    public function destroy($id) {
        $day = Date::findOrFail($id);
        $day->delete();
        return redirect()
            ->route('days.index');
    }
}
