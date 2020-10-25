<?php 

  namespace App\DataTables;

  use App\Models\Role;
  use Yajra\DataTables\Datatables;
  use Hexters\Ladmin\Contracts\DataTablesInterface;

  class RoleDatatables extends Datatables implements DataTablesInterface {

    public function render() {
      return $this->eloquent(Role::query())
        ->addColumn('action', function($item) {
          return view('ladmin::table.action', [
            'show' => null,
            'edit' => [
              'gate' => 'administrator.account.admin.update',
              'url' => route('administrator.account.admin.edit', [$item->id, 'back' => request()->fullUrl()])
            ],
            'destroy' => [
              'gate' => 'administrator.account.admin.destroy',
              'url' => route('administrator.account.admin.destroy', [$item->id, 'back' => request()->fullUrl()]),
            ]
          ]);
        })
        ->escapeColumns([])
        ->make(true);
    }

    public function options() {

      return [
        'title' => 'Roles',
        'fields' => [
          [ 'name' => 'ID', 'class' => 'text-center'],
          [ 'name' => 'Name' ],
          [ 'name' => 'Action', 'class' => 'text-center' ]
        ],
        'options' => [
          'topButton' => view('vendor.ladmin.role._partials._topButton'),
          'processing' => true,
              'serverSide' => true,
              'ajax' => route('administrator.access.role.index'),
              'columns' => [
                  ['data' => 'id', 'class' => 'text-center'],
                  ['data' => 'name'],
                  ['data' => 'action', 'class' => 'text-center', 'orderable' => false]
              ]
        ]
      ];

    }

  }