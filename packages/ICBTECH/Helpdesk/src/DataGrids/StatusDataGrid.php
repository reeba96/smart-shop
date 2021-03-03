<?php

namespace ICBTECH\Helpdesk\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class StatusDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('ticketit_statuses');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('helpdesk::lang.table-id'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('helpdesk::lang.table-subject'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
            
        $this->addColumn([
            'index'      => 'color',
            'label'      => trans('helpdesk::admin.table-color'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
        ]);
        
    }

    public function prepareActions()
    { 
        $this->addAction([
            'title'  => trans('helpdesk::admin.datagrid-edit'),
            'method' => 'GET',
            'route'  => 'admin.helpdesk.status.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

        $this->addAction([
            'type'   => 'Delete',
            'title'  => trans('helpdesk::admin.datagrid-delete'),
            'method' => 'POST',
            'route'  => 'admin.helpdesk.status.delete',
            'icon'   => 'icon trash-icon'
        ]);

    }
    
    public function prepareMassActions()
    {
        $this->addMassAction([
            'type'   => 'delete',
            'action' => route('admin.helpdesk.status.massdelete'),
            'label'  => trans('admin::app.datagrid.delete'),
            'index'  => 'admin_name',
            'method' => 'DELETE',
        ]);
    }
    
}