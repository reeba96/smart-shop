<?php

namespace Webkul\Shop\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use ICBTECH\Helpdesk\Models\Status;

class HelpdeskDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('ticketit')
            ->leftJoin('ticketit_statuses', 'ticketit_statuses.id', '=', 'ticketit.status_id')
            ->leftJoin('ticketit_priorities', 'ticketit_priorities.id', '=', 'ticketit.priority_id')
            ->leftJoin('ticketit_categories', 'ticketit_categories.id', '=', 'ticketit.category_id')
            ->select(
                'ticketit.id',
                'ticketit.subject',
                'ticketit.created_at',
                'ticketit_statuses.name as status_name',
                'ticketit_statuses.color as status_color',
                'ticketit_priorities.name as priority_name',
                'ticketit_priorities.color as priority_color',
                'ticketit_categories.name as category_name'
            )->where('user_id', '=', auth()->guard('customer')->user()->id);

        $this->setQueryBuilder($queryBuilder);
    }   

    public function addColumns()
    {

        $this->addColumn([
            'index'      => 'subject',
            'label'      => trans('helpdesk::lang.table-subject'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
            
        $this->addColumn([
            'index'      => 'status_name',
            'label'      => trans('helpdesk::lang.table-status'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return '<span class="badge badge-pill" style="background-color: '. $value->status_color .'">' . $value->status_name . '</span>';
            },
            'filterable' => true
        ]);

        $this->addColumn([
            'index'      => 'priority_name',
            'label'      => trans('helpdesk::lang.table-priority'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'closure'    => true,
            'wrapper'    => function ($value) {
                return '<span class="badge badge-pill" style="background-color: '. $value->priority_color .'">' . $value->priority_name . '</span>';
            },
            'filterable' => true
        ]);


        $this->addColumn([
            'index'      => 'category_name',
            'label'      => trans('helpdesk::lang.table-category'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
        
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('helpdesk::lang.created'),
            'type'       => 'datetime',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('admin::app.datagrid.view'),
            'method' => 'GET',
            'route'  => 'customer.helpdesk.show',
            'icon'   => 'icon eye-icon',
        ]);
    }
}