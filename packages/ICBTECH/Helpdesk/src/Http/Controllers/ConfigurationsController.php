<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use ICBTECH\Helpdesk\Models\Configuration;
use ICBTECH\Helpdesk\Models\Setting;

class ConfigurationsController extends Controller
{
    /**
     * Display a listing of the Setting.
     *
     * @return Response
     */
    public function index()
    {
        return view('helpdesk::admin.configuration.index');
    }

    /**
     * Show the form for creating a new Setting.
     *
     * @return Response
     */
    public function create()
    {
        return view('helpdesk::admin.configuration.create');
    }

    /**
     * Store a newly created Configuration in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'slug'      => 'required',
            'default'   => 'required',
            'value'     => 'required',
        ]);

        $input = $request->all();

        $configuration = new Configuration();
        $configuration->create($input);

        Session::flash('configuration', 'Setting saved successfully.');
        \Cache::forget('helpdesk::settings'); // refresh cached settings
        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController@index');
    }

    /**
     * Show the form for editing the specified Configuration.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $configuration = Configuration::findOrFail($id);

        return view('helpdesk::admin.configuration.edit', compact('configuration'));
    }

    /**
     * Update the specified Configuration in storage.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'value'      => 'required',
            'default'     => 'required',
        ]);

        $configuration = Configuration::findOrFail($id);
        $configuration->update(['value' => $request->value, 'default' => $request->default]);

        session()->flash('success',trans('admin::app.configuration.save-message'));
        \Cache::forget('helpdesk::settings');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\ConfigurationsController@index');

    }
}
