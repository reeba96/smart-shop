<?php

namespace ICBTECH\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ICBTECH\Helpdesk\Models;

class CommentsController extends Controller
{
    public function __construct()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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
            'ticket_id'   => 'required|exists:ticketit,id',
            'content'     => 'required|min:6',
        ]);

        $comment = new Models\Comment();
        $comment->setPurifiedContent($request->get('content'));
        $comment->ticket_id = $request->get('ticket_id');

        if(app('\ICBTECH\Helpdesk\Http\Controllers\ToolsController')->isUrlExtends('admin')) {

            $comment->admin_id = auth()->guard('admin')->user()->id;
            $comment->user_id = 0;

            $comment->save();

            $ticket = Models\Ticket::find($comment->ticket_id);
            $ticket->updated_at = $comment->created_at;
            $ticket->save();

            session()->flash('success', trans('helpdesk::lang.comment-has-been-added-ok'));

            return back()->with('status', trans('helpdesk::lang.comment-has-been-added-ok'));
        } else {

            $comment->user_id = $request->customer_id;
            $comment->admin_id = 0;
            $comment->save();

            $ticket = Models\Ticket::find($comment->ticket_id);
            $ticket->updated_at = $comment->created_at;
            $ticket->save();

            session()->flash('success', trans('helpdesk::lang.comment-has-been-added-ok'));

            return back()->with('status', trans('helpdesk::lang.comment-has-been-added-ok'));
        }
        
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
        //
    }
}
