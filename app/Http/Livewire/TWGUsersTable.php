<?php

namespace App\Http\Livewire;
use Spatie\Permission\Models\Role;

use App\Models\User;
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

final class TWGUsersTable extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;
    public $roles = [];

    public $statuses = [];

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
            ['name',"!=","Super Administrator"],
            ['name',"!=","Administrator"],
            ['name',"!=","Developer"],
            ['name',"!=","Banned"],

        ])->get();
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

      
        // return User::query()->where([['email_verified_at','<>','']])
        //                     ->whereRelation("rol", function($role){
        //                         $role->where([
        //                             ["role_id", "!=", 1],
        //                             ["role_id", "!=", 2],
        //                             ["role_id", "!=", 7]
        //                         ]);
        //         })->with("rol.role")
        //         ->orderBy('status', 'asc');;
                $users = User::query()
                ->leftJoin("users as aprover", "aprover.id", "users.approver_id")
                ->leftJoin("model_has_roles as rol", "rol.model_id", "users.id")
                ->leftJoin("roles", "roles.id", "rol.role_id")
                ->leftJoin("service_regions", "service_regions.id", "users.serreg_id")
                ->where("users.email_verified_at", "!=", null)
                ->where([
                    ["role_id", "!=", 1],
                    ["role_id", "!=", 2],
                    ["role_id", "!=", 7]
                ])
                ->orderBy('status', 'asc')
                ->select([
                    "service_regions.service_region as region",
                    "users.*", "roles.name as role", 
                DB::raw("CONCAT(aprover.firstname,' ',aprover.lastname) as approver" ),
                DB::raw("CONCAT(users.firstname,' ',users.lastname) as name" )]);   
      return   $users ;

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
              ->addColumn('email')
            ->addColumn('role', function (User $model) {
            $roles = $this->roles;
            $role_list = '';
            foreach ($roles as $key => $role) {
                $role_list .='<a onclick="onChangeRole('.$model->id.','.$role->id.',`'.$role->name.'`)" class="dropdown-item cursor-pointer">'.$role->name.'</a>';
            }
            //TODO CRITICAL BUG 
            return '<div class="btn-group">
            <button roleId="3" id="buttonRole'.$model->id.'" type="button" class="btn btn-gray dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            '.@$model->role.'
            </button>
            <div class="dropdown-menu">
            '.$role_list.'
            </div>
            </div>';
            })
            ->addColumn('region', function(User $model){
                return $model->region;
            })
            ->addColumn('status', function (User $model) {
            $statuses = $this->statuses;
            $status_list = '';
            foreach ($statuses as $key => $status) {
                $status_list .='<a onclick="onChangeStatus('.$model->id.','.$key.')" class="dropdown-item cursor-pointer">'.$status.'</a>';
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
            ->addColumn('created_at')
            ->addColumn('created_at_formatted', function(User $model) {
                return Carbon::parse($model->created_at)->format('d/m/Y H:i:s');
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
                ->searchable()
                ->sortable(),

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
                ->title('Created at')
                ->field('created_at', "users.created_at")
                ->hidden(),

            Column::add()
                ->title('Created at')
                ->field('created_at_formatted')
                ->makeInputDatePicker('users.created_at')
                ->searchable()
        ];
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
           $updated = User::query()
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
