<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ICBTECH\Helpdesk\Models\Priority;
use ICBTECH\Helpdesk\Helpers\LaravelVersion;

class PrioritiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('helpdesk::admin.priority.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('helpdesk::admin.priority.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'color'     => 'required',
        ]);

        $priority = new Priority();
        $priority->create(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.priority-name-has-been-created', ['name' => $request->name]));
        \Cache::forget('helpdesk::priorities');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        return trans('helpdesk::lang.priority-all-tickets-here');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $priority = Priority::findOrFail($id);

        return view('helpdesk::admin.priority.edit', compact('priority'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'      => 'required',
            'color'     => 'required',
        ]);

        $priority = Priority::findOrFail($id);
        $priority->update(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.priority-name-has-been-modified', ['name' => $request->name]));
        \Cache::forget('helpdesk::priorities');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $priority = Priority::findOrFail($id);
        $name = $priority->name;
        $priority->delete();

        session()->flash('success',trans('helpdesk::lang.priority-name-has-been-deleted', ['name' => $name]));
        \Cache::forget('helpdesk::priorities');

        return redirect()->route('\ICBTECH\Helpdesk\Http\Controllers\PrioritiesController@index');
    }

    /**
     * Remove the specified resources from database
     *
     * @return \Illuminate\Http\Response
     */
    public function massDestroy()
    {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            $indexes = explode(',', request()->input('indexes'));

            foreach ($indexes as $key => $value) {

                $priority = Priority::findOrFail($value);

                try {
                    $priority->delete();
                    $suppressFlash = true;
                } catch (\Exception $e) {
                    report($e);
                    $suppressFlash = false;
                    continue;
                }
            }

            if ($suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'priorities']));
            } else {
                session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Priority']));
            }

            return redirect()->back();

        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
