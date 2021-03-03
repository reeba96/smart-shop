<?php

namespace ICBTECH\Helpdesk\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;
use ICBTECH\Helpdesk\Models\Setting;

class ActiveTicketDataGrid extends DataGrid
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
                'ticketit.updated_at',
                'ticketit_statuses.name as status_name',
                'ticketit_statuses.color as status_color',
                'ticketit_priorities.name as priority_name',
                'ticketit_categories.name as category_name'
            )->where('status_id', '!=', Setting::grab('default_close_status_id'));

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('helpdesk::lang.table-id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'subject',
            'label'      => trans('helpdesk::lang.table-subject'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
            
        $this->addColumn([
            'index'      => 'status_name',
            'label'      => trans('helpdesk::lang.table-status'),
            'type'       => 'string',
            'searchable' => false,
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
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'category_name',
            'label'      => trans('helpdesk::lang.table-category'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'updated_at',
            'label'      => trans('helpdesk::lang.table-last-updated'),
            'type'       => 'datetime',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
        
    }
    
    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('helpdesk::lang.datagrid-view'),
            'method' => 'GET',
            'route'  => 'admin.helpdesk.active.view',
            'icon'   => 'icon eye-icon',
        ]);

        $this->addAction([
            'type' => 'Delete',
            'title'  => trans('helpdesk::admin.datagrid-delete'),
            'method' => 'POST',
            'route'  => 'admin.helpdesk.active.delete',
            'icon'   => 'icon trash-icon'
        ]);
    }
}