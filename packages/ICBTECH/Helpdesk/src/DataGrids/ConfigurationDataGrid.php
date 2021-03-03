<?php

namespace ICBTECH\Helpdesk\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\Ui\DataGrid\DataGrid;

class ConfigurationDataGrid extends DataGrid
{
    protected $index = 'id';

    protected $sortOrder = 'desc';

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('ticketit_settings')
            ->where('slug','default_status_id')
            ->orwhere('slug','default_close_status_id')
            ->orwhere('slug','default_reopen_status_id')
            ->orwhere('slug','paginate_items');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('helpdesk::admin.table-id'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'slug',
            'label'      => trans('helpdesk::admin.table-slug'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
            
        $this->addColumn([
            'index'      => 'value',
            'label'      => trans('helpdesk::admin.table-value'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
        
        $this->addColumn([
            'index'      => 'default',
            'label'      => trans('helpdesk::admin.table-default'),
            'type'       => 'string',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);
    }

    public function prepareActions()
    {
        $this->addAction([
            'title'  => trans('helpdesk::admin.datagrid-edit'),
            'method' => 'GET',
            'route'  => 'admin.helpdesk.configuration.edit',
            'icon'   => 'icon pencil-lg-icon',
        ]);

    }
}