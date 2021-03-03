<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ICBTECH\Helpdesk\Models\Status;
use ICBTECH\Helpdesk\Helpers\LaravelVersion;

class StatusesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('helpdesk::admin.status.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('helpdesk::admin.status.create');
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

        $status = new Status();
        $status->create(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.status-name-has-been-created', ['name' => $request->name]));
        \Cache::forget('helpdesk::statuses');

        return redirect()->route('admin.helpdesk.status.index');
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
        $status = Status::findOrFail($id);

        return view('helpdesk::admin.status.edit', compact('status'));
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

        $status = Status::findOrFail($id);
        $status->update(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.status-name-has-been-modified', ['name' => $request->name]));
        \Cache::forget('helpdesk::statuses');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\StatusesController@index');
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
        $status = Status::findOrFail($id);
        $name = $status->name;
        $status->delete();

        session()->flash('success',trans('helpdesk::lang.status-name-has-been-deleted', ['name' => $name]));
        \Cache::forget('helpdesk::statuses');

        return redirect()->route('\ICBTECH\Helpdesk\Http\Controllers\StatusesController@index');
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

                $status = Status::findOrFail($value);

                try {
                    $status->delete();
                    $suppressFlash = true;
                } catch (\Exception $e) {
                    report($e);
                    $suppressFlash = false;
                    continue;
                }
            }

            if ($suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'statuses']));
            } else {
                session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Status']));
            }

            return redirect()->back();

        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
