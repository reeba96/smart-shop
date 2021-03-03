<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use ICBTECH\Helpdesk\Models\Category;
use ICBTECH\Helpdesk\Helpers\LaravelVersion;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // seconds expected for L5.8<=, minutes before that
        $time = LaravelVersion::min('5.8') ? 60*60 : 60;
        $categories = \Cache::remember('helpdesk::categories', $time, function () {
            return Category::all();
        });

        return view('helpdesk::admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('helpdesk::admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'color'     => 'required',
        ]);

        $category = new Category();
        $category->create(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.category-name-has-been-created', ['name' => $request->name]));
        \Cache::forget('helpdesk::categories');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\CategoriesController@index');
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
        return 'All category related agents here';
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
        $category = Category::findOrFail($id);

        return view('helpdesk::admin.category.edit', compact('category'));
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

        $category = Category::findOrFail($id);
        $category->update(['name' => $request->name, 'color' => $request->color]);

        session()->flash('success',trans('helpdesk::lang.category-name-has-been-modified', ['name' => $request->name]));
        \Cache::forget('helpdesk::categories');

        return redirect()->action('\ICBTECH\Helpdesk\Http\Controllers\CategoriesController@index');
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
        $category = Category::findOrFail($id);
        $name = $category->name;
        $category->delete();

        session()->flash('success',trans('helpdesk::lang.category-name-has-been-deleted', ['name' => $name]));
        \Cache::forget('helpdesk::categories');

        return redirect()->route('\ICBTECH\Helpdesk\Http\Controllers\CategoriesController@index');
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

                $category = Category::findOrFail($value);

                try {
                    $category->delete();
                    $suppressFlash = true;
                } catch (\Exception $e) {
                    report($e);
                    $suppressFlash = false;
                    continue;
                }
            }

            if ($suppressFlash) {
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'categories']));
            } else {
                session()->flash('error', trans('admin::app.response.user-define-error', ['name' => 'Category']));
            }

            return redirect()->back();

        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}
