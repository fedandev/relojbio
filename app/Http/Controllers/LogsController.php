<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogRequest;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$this->authorize('show', Log::class);
		return view('logs.index');
	}

    public function show(Log $log)
    {
    	$this->authorize('show', $log);	
        return view('logs.show', compact('log'));
    }

	public function create(Log $log)
	{
		$this->authorize('create', $log);
		return view('logs.create_and_edit', compact('log'));
	}

	public function store(LogRequest $request)
	{
		$this->authorize('store', Log::class);
		$log = Log::create($request->all());
		return redirect()->route('logs.show', $log->id)->with('message', 'Created successfully.');
	}

	public function edit(Log $log)
	{
        $this->authorize('edit', $log);
		return view('logs.create_and_edit', compact('log'));
	}

	public function update(LogRequest $request, Log $log)
	{
		$this->authorize('update', $log);
		$log->update($request->all());

		return redirect()->route('logs.show', $log->id)->with('message', 'Updated successfully.');
	}

	public function destroy(Log $log)
	{
		$this->authorize('destroy', $log);
		$log->delete();

		return redirect()->route('logs.index')->with('message', 'Deleted successfully.');
	}
}