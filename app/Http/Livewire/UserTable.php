<?php

namespace App\Http\Livewire;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use Auth;
use App\Models\ServiceRegion;
final class UserTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;
    public $roles = [];
    public $statuses = [];
    public $serviceRegions = [];



    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
            ->showSearchInput()
            ->showExportOption('download', ['excel', 'csv']);

        $this->roles = Role::where([
            ['name',"!=","Banned"],
            ['name',"!=","Administrator"],
        ])->get();
        $this->serviceRegions = ServiceRegion::get();
        $this->statuses = $array = [
            0 => "Pending",
            1 => "Approved",
            2 => "Suspended",
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */
    public function datasource(): ?Builder
    {
        // return User::query()->where([['firstname','<>',''],['email_verified_at','<>','']])
        //             ->orderBy('status', 'asc')
        //             ->select("*",  DB::raw("CONCAT(users.firstname,' ',users.lastname) as name" ));
        $users = User::query()
                ->leftJoin("users as aprover", "aprover.id", "users.approver_id")
                ->leftJoin("model_has_roles as rol", "rol.model_id", "users.id")
                ->leftJoin("roles", "roles.id", "rol.role_id")
                ->leftJoin("service_regions", "service_regions.id", "users.serreg_id")
                ->where("users.email_verified_at", "!=", null)
                // ->where("users.id", "!=", @Auth::user()->id)
                ->where("users.firstname", "!=", null)
                ->orderBy('status', 'asc')
                ->select([ "service_regions.service_region as region",  "users.*", "roles.name as role", DB::raw("CONCAT(aprover.firstname,' ',aprover.lastname) as approver" ), DB::raw("CONCAT(users.firstname,' ',users.lastname) as name" )]);
        return $users;
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('firstname', function (User $model) {
               return $model->firstname;
              })
              ->addColumn('lastname', function (User $model) {
                return $model->lastname;
               })
              ->addColumn('approver', function (User $model) {
                  if(isset($model->approver))
                  {
                    return $model->approver;
                  }
                  return 'N/A';
              })
            ->addColumn('email')
            ->addColumn('role', function (User $model) {
                $roles = $this->roles;
                $role_list = '';
                foreach ($roles as $key => $role) {
                   $role_list .='<a onclick="onChangeRole('.$model->id.','.$role->id.')" class="dropdown-item">'.$role->name.'</a>';
                }
                return '<div class="btn-group">
                <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.@$model->role.'
                </button>
                <div class="dropdown-menu">
                '.$role_list.'
                </div>
              </div>';
              })
                            ->addColumn('region', function(User $model){
                                    $serviceRegions = $this->serviceRegions;
                                    $service_list = '';
                                    foreach ($serviceRegions as $sr) {
                                         $service_list .= '<a onclick="onChangeService('.$model->id.','.$sr->id.')" class="dropdown-item">'.$sr->service_region.'</a>';
                                    }
                                    $current = $model->region ?? 'N/A';
                                    return '<div class="btn-group">'
                                        .'<button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'
                                        . $current .
                                        '</button>'
                                        .'<div class="dropdown-menu">'
                                        . $service_list .
                                        '</div>'
                                        .'</div>';
                            })
            ->addColumn('status', function (User $model) {
                $statuses = $this->statuses;
                $status_list = '';
                foreach ($statuses as $key => $status) {
                   $status_list .='<a onclick="onChangeStatus('.$model->id.','.$key.')" class="dropdown-item">'.$status.'</a>';
                }
                return '<div class="btn-group">
                <button type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                '.$statuses[$model->status].'
                </button>
                <div class="dropdown-menu">
                '.$status_list.'
                </div>
              </div>';
              })
              ->addColumn('created_at_formatted', function(User $model) { 
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
            })
            ->addColumn('updated_at_formatted', function(User $model) { 
                return Carbon::parse($model->updated_at)->format('d/m/Y H:i:s');
            });

    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id', "users.id")
                ->makeInputRange(),

            Column::add()
                ->title('Firstname')
                ->field('firstname', "users.firstname")
                ->sortable()
                ->searchable()
                ->makeInputText(),
                Column::add()
                ->title('Lastname')
                ->field('lastname', "users.lastname")
                ->sortable()
                ->searchable()
                ->makeInputText(),
               
            Column::add()
                ->title('EMAIL')
                ->field('email', "users.email")
                ->sortable()
                ->searchable()
                ->makeInputText(),
            Column::add()
            ->title('Role')
            ->field('role', "roles.name")
            ->searchable()
            ->makeInputText()
            ->sortable(),
            Column::add()
            ->title('Service Region')
            ->field('region', "service_regions.service_region")
            ->searchable()
            ->makeInputText()
            ->sortable(),
            Column::add()
            ->title('Status')
            ->field('status', "users.status")
            ->sortable()
            ->searchable()
            ->makeInputText(),

            Column::add()
            ->title('APPROVED BY')
            ->field('approver', "approver.firstname"),

            Column::add()
            ->title('CREATED AT')
            ->field('created_at_formatted', 'users.created_at')
            ->searchable()
            ->sortable()
            ->makeInputDatePicker('users.created_at'),
            Column::add()
            ->title('UPDATED AT')
            ->field('updated_at_formatted', 'users.updated_at')
            ->searchable()
            ->sortable()
            ->makeInputDatePicker('users.updated_at'),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable this section only when you have defined routes for these actions.
    |
    */

     /**
     * PowerGrid User action buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('user.edit', ['user' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('user.destroy', ['user' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable this section to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid User Update.
     *
     * @param array<string,string> $data
     */
/*
    public function update(array $data ): bool
    {
       try {
           $updated = User::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }
    */
}
